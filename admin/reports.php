<?php
require_once 'auth.php';
require_once '../config/database.php';

$auth = new Auth();
$auth->requireLogin();

$db = Database::getInstance()->getConnection();

// Get date range
$date_range = $_GET['range'] ?? '30';
$date_range = intval($date_range);
if ($date_range < 1) $date_range = 30;
$start_date = date('Y-m-d', strtotime("-{$date_range} days"));
$end_date = date('Y-m-d');

try {
    // ===== SALES REPORT =====
    $sales_stmt = $db->prepare("
        SELECT 
            COUNT(*) as total_properties,
            SUM(CASE WHEN status = 'sold' THEN 1 ELSE 0 END) as sold_count,
            SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) as available_count,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
            SUM(price) as total_value,
            AVG(price) as avg_price,
            MAX(price) as max_price,
            MIN(price) as min_price
        FROM properties
    ");
    $sales_stmt->execute();
    $sales_report = $sales_stmt->fetch(PDO::FETCH_ASSOC);
    
    // ===== PROPERTY TYPE ANALYSIS =====
    $types_stmt = $db->prepare("
        SELECT 
            property_type,
            COUNT(*) as count,
            AVG(price) as avg_price,
            MAX(price) as max_price,
            SUM(views) as total_views,
            SUM(CASE WHEN status = 'sold' THEN 1 ELSE 0 END) as sold_count
        FROM properties
        GROUP BY property_type
        ORDER BY count DESC
    ");
    $types_stmt->execute();
    $property_types = $types_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // ===== LOCATION PERFORMANCE =====
    $locations_stmt = $db->prepare("
        SELECT 
            location,
            COUNT(*) as property_count,
            AVG(price) as avg_price,
            MAX(price) as max_price,
            MIN(price) as min_price,
            SUM(views) as total_views,
            SUM(CASE WHEN status = 'sold' THEN 1 ELSE 0 END) as sold_count
        FROM properties
        GROUP BY location
        ORDER BY property_count DESC
        LIMIT 15
    ");
    $locations_stmt->execute();
    $locations = $locations_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // ===== INQUIRY ANALYSIS =====
    $inquiry_stmt = $db->prepare("
        SELECT 
            COUNT(*) as total_inquiries,
            SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new_count,
            SUM(CASE WHEN status = 'read' THEN 1 ELSE 0 END) as read_count,
            SUM(CASE WHEN status = 'replied' THEN 1 ELSE 0 END) as replied_count,
            COUNT(DISTINCT DATE(created_at)) as inquiry_days
        FROM inquiries
        WHERE created_at >= ?
    ");
    $inquiry_stmt->execute([$start_date . ' 00:00:00']);
    $inquiry_report = $inquiry_stmt->fetch(PDO::FETCH_ASSOC);
    
    // ===== CONVERSION RATE =====
    $conversion_stmt = $db->prepare("
        SELECT 
            COUNT(DISTINCT i.id) as total_inquiries,
            COUNT(DISTINCT i.property_id) as inquired_properties,
            COUNT(DISTINCT p.id) as total_properties,
            ROUND((COUNT(DISTINCT i.property_id) / COUNT(DISTINCT p.id) * 100), 2) as conversion_rate
        FROM inquiries i
        CROSS JOIN properties p
        WHERE i.created_at >= ?
    ");
    $conversion_stmt->execute([$start_date . ' 00:00:00']);
    $conversion_data = $conversion_stmt->fetch(PDO::FETCH_ASSOC);
    
    // ===== TOP INQUIRED PROPERTIES =====
    $top_inquired_stmt = $db->prepare("
        SELECT 
            p.id,
            p.title,
            p.location,
            p.price,
            COUNT(i.id) as inquiry_count,
            p.views,
            p.status
        FROM properties p
        LEFT JOIN inquiries i ON p.id = i.property_id
        GROUP BY p.id
        ORDER BY inquiry_count DESC
        LIMIT 10
    ");
    $top_inquired_stmt->execute();
    $top_inquired = $top_inquired_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // ===== DAILY INQUIRIES TREND =====
    $daily_stmt = $db->prepare("
        SELECT 
            DATE(created_at) as date,
            COUNT(*) as inquiry_count,
            SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new_count
        FROM inquiries
        WHERE created_at >= ?
        GROUP BY DATE(created_at)
        ORDER BY date DESC
        LIMIT 30
    ");
    $daily_stmt->execute([$start_date . ' 00:00:00']);
    $daily_inquiries = $daily_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // ===== FEATURED VS REGULAR PERFORMANCE =====
    $featured_stmt = $db->prepare("
        SELECT 
            featured,
            COUNT(*) as count,
            AVG(views) as avg_views,
            SUM(views) as total_views,
            SUM(CASE WHEN status = 'sold' THEN 1 ELSE 0 END) as sold_count
        FROM properties
        GROUP BY featured
    ");
    $featured_stmt->execute();
    $featured_analysis = $featured_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // ===== VISITOR ANALYTICS =====
    $visitors_stmt = $db->prepare("
        SELECT 
            COUNT(*) as total_visits,
            COUNT(DISTINCT ip_address) as unique_visitors,
            SUM(CASE WHEN visit_data LIKE '%true%' THEN 1 ELSE 0 END) as mobile_visits,
            SUM(CASE WHEN visit_data LIKE '%false%' THEN 1 ELSE 0 END) as desktop_visits,
            COUNT(DISTINCT DATE(created_at)) as days_active
        FROM page_visits
        WHERE created_at >= ?
    ");
    $visitors_stmt->execute([$start_date . ' 00:00:00']);
    $visitor_stats = $visitors_stmt->fetch(PDO::FETCH_ASSOC);
    
    // ===== PRICE DISTRIBUTION =====
    $price_dist_stmt = $db->prepare("
        SELECT 
            CASE 
                WHEN price < 50000000 THEN 'Under 50M'
                WHEN price < 100000000 THEN '50M - 100M'
                WHEN price < 200000000 THEN '100M - 200M'
                WHEN price < 500000000 THEN '200M - 500M'
                ELSE '500M+'
            END as price_range,
            COUNT(*) as count,
            AVG(views) as avg_views
        FROM properties
        GROUP BY price_range
        ORDER BY price_range
    ");
    $price_dist_stmt->execute();
    $price_distribution = $price_dist_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // ===== RESPONSE TIME ANALYSIS =====
    $response_time_stmt = $db->prepare("
        SELECT 
            COUNT(*) as replied_inquiries,
            AVG(CASE WHEN status = 'replied' THEN TIMESTAMPDIFF(HOUR, created_at, updated_at) ELSE NULL END) as avg_response_hours
        FROM inquiries
        WHERE status = 'replied' AND created_at >= ?
    ");
    $response_time_stmt->execute([$start_date . ' 00:00:00']);
    $response_time = $response_time_stmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    error_log("Report error: " . $e->getMessage());
    $error = "Error loading report data: " . $e->getMessage();
}

$user = $auth->getUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Property CMS</title>
    <link rel="stylesheet" href="../assets/css/admin-styles.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/sidebar.php'; ?>
        
        <div class="main-content">
            <?php include 'includes/header.php'; ?>
            
            <div class="content-area">
                <div class="page-header">
                    <h1>Reports & Analysis</h1>
                    <div class="page-actions">
                        <select id="dateRange" onchange="changeDateRange()" class="form-control">
                            <option value="7" <?php echo $date_range === 7 ? 'selected' : ''; ?>>Last 7 Days</option>
                            <option value="30" <?php echo $date_range === 30 ? 'selected' : ''; ?>>Last 30 Days</option>
                            <option value="90" <?php echo $date_range === 90 ? 'selected' : ''; ?>>Last 90 Days</option>
                            <option value="180" <?php echo $date_range === 180 ? 'selected' : ''; ?>>Last 6 Months</option>
                            <option value="365" <?php echo $date_range === 365 ? 'selected' : ''; ?>>Last Year</option>
                            <option value="999999" <?php echo $date_range > 999 ? 'selected' : ''; ?>>All Time</option>
                        </select>
                        <button onclick="printReport()" class="btn-primary">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <!-- SALES SUMMARY -->
                <div class="report-section">
                    <h2><i class="fas fa-chart-bar"></i> Sales Summary</h2>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo number_format($sales_report['total_properties'] ?? 0); ?></h3>
                                <p>Total Properties</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo number_format($sales_report['sold_count'] ?? 0); ?></h3>
                                <p>Sold</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-list"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo number_format($sales_report['available_count'] ?? 0); ?></h3>
                                <p>Available</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo number_format($sales_report['pending_count'] ?? 0); ?></h3>
                                <p>Pending</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="stat-content">
                                <h3>TZS <?php echo number_format($sales_report['total_value'] ?? 0, 0); ?></h3>
                                <p>Total Value</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="stat-content">
                                <h3>TZS <?php echo number_format($sales_report['avg_price'] ?? 0, 0); ?></h3>
                                <p>Average Price</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- PROPERTY TYPE ANALYSIS -->
                <div class="report-section">
                    <h2><i class="fas fa-building"></i> Property Type Analysis</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Count</th>
                                    <th>Avg Price</th>
                                    <th>Max Price</th>
                                    <th>Total Views</th>
                                    <th>Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($property_types as $type): ?>
                                    <tr>
                                        <td><strong><?php echo ucfirst($type['property_type']); ?></strong></td>
                                        <td><?php echo number_format($type['count']); ?></td>
                                        <td>TZS <?php echo number_format($type['avg_price'], 0); ?></td>
                                        <td>TZS <?php echo number_format($type['max_price'], 0); ?></td>
                                        <td><?php echo number_format($type['total_views']); ?></td>
                                        <td><?php echo number_format($type['sold_count']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- LOCATION PERFORMANCE -->
                <div class="report-section">
                    <h2><i class="fas fa-map-marker-alt"></i> Location Performance (Top 15)</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Location</th>
                                    <th>Properties</th>
                                    <th>Price Range</th>
                                    <th>Avg Price</th>
                                    <th>Views</th>
                                    <th>Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($locations as $loc): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($loc['location']); ?></strong></td>
                                        <td><?php echo number_format($loc['property_count']); ?></td>
                                        <td>
                                            TZS <?php echo number_format($loc['min_price'], 0); ?> - 
                                            <?php echo number_format($loc['max_price'], 0); ?>
                                        </td>
                                        <td>TZS <?php echo number_format($loc['avg_price'], 0); ?></td>
                                        <td><?php echo number_format($loc['total_views']); ?></td>
                                        <td><?php echo number_format($loc['sold_count']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- INQUIRY & CONVERSION ANALYSIS -->
                <div class="report-section">
                    <h2><i class="fas fa-envelope"></i> Inquiry & Conversion Analysis</h2>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo number_format($inquiry_report['total_inquiries'] ?? 0); ?></h3>
                                <p>Total Inquiries</p>
                                <small><?php echo $inquiry_report['inquiry_days'] ?? 0; ?> days active</small>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo number_format($inquiry_report['new_count'] ?? 0); ?></h3>
                                <p>New Inquiries</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo number_format($inquiry_report['read_count'] ?? 0); ?></h3>
                                <p>Read</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-reply"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo number_format($inquiry_report['replied_count'] ?? 0); ?></h3>
                                <p>Replied</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-percentage"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo number_format($conversion_data['conversion_rate'] ?? 0, 1); ?>%</h3>
                                <p>Conversion Rate</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo number_format($response_time['avg_response_hours'] ?? 0, 1); ?> hrs</h3>
                                <p>Avg Response Time</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- TOP INQUIRED PROPERTIES -->
                <div class="report-section">
                    <h2><i class="fas fa-fire"></i> Top 10 Inquired Properties</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Property</th>
                                    <th>Location</th>
                                    <th>Price</th>
                                    <th>Inquiries</th>
                                    <th>Views</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($top_inquired as $prop): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($prop['title']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($prop['location']); ?></td>
                                        <td>TZS <?php echo number_format($prop['price'], 0); ?></td>
                                        <td><span class="badge badge-primary"><?php echo number_format($prop['inquiry_count']); ?></span></td>
                                        <td><?php echo number_format($prop['views']); ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo $prop['status']; ?>">
                                                <?php echo ucfirst($prop['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- VISITOR ANALYTICS -->
                <div class="report-section">
                    <h2><i class="fas fa-chart-pie"></i> Visitor Analytics</h2>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo number_format($visitor_stats['total_visits'] ?? 0); ?></h3>
                                <p>Total Visits</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo number_format($visitor_stats['unique_visitors'] ?? 0); ?></h3>
                                <p>Unique Visitors</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo number_format($visitor_stats['mobile_visits'] ?? 0); ?></h3>
                                <p>Mobile Visits</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-desktop"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?php echo number_format($visitor_stats['desktop_visits'] ?? 0); ?></h3>
                                <p>Desktop Visits</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- FEATURED VS REGULAR PERFORMANCE -->
                <div class="report-section">
                    <h2><i class="fas fa-star"></i> Featured vs Regular Performance</h2>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Count</th>
                                    <th>Avg Views</th>
                                    <th>Total Views</th>
                                    <th>Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($featured_analysis as $feat): ?>
                                    <tr>
                                        <td>
                                            <strong>
                                                <?php echo $feat['featured'] ? 'Featured' : 'Regular'; ?>
                                            </strong>
                                        </td>
                                        <td><?php echo number_format($feat['count']); ?></td>
                                        <td><?php echo number_format($feat['avg_views'], 1); ?></td>
                                        <td><?php echo number_format($feat['total_views']); ?></td>
                                        <td><?php echo number_format($feat['sold_count']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function changeDateRange() {
            const range = document.getElementById('dateRange').value;
            window.location.href = `reports.php?range=${range}`;
        }
        
        function printReport() {
            window.print();
        }
    </script>
    <script src="../assets/js/admin-scripts.js"></script>
</body>
</html>
