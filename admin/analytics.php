<?php
require_once 'auth.php';
require_once '../config/database.php';

$auth = new Auth();
$auth->requireLogin();

$db = Database::getInstance()->getConnection();

$date_range = intval($_GET['range'] ?? 30);
$date_range = max(1, min($date_range, 999999));
$start_date = $date_range > 999 ? '2000-01-01' : date('Y-m-d', strtotime("-{$date_range} days"));

try {
    // ===== PROPERTY ANALYTICS =====
    
    // Properties by type
    $types_stmt = $db->prepare("
        SELECT property_type, COUNT(*) as count, AVG(views) as avg_views, SUM(views) as total_views
        FROM properties
        GROUP BY property_type
    ");
    $types_stmt->execute();
    $property_types = $types_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Properties by status
    $status_stmt = $db->query("
        SELECT status, COUNT(*) as count
        FROM properties
        GROUP BY status
    ");
    $property_status = $status_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Location distribution
    $location_stmt = $db->query("
        SELECT location, COUNT(*) as count, AVG(price) as avg_price, SUM(views) as views
        FROM properties
        GROUP BY location
        ORDER BY count DESC
        LIMIT 10
    ");
    $top_locations = $location_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // ===== PRICE ANALYTICS =====
    $price_stats = $db->query("
        SELECT 
            MIN(price) as min_price,
            MAX(price) as max_price,
            AVG(price) as avg_price,
            COUNT(*) as count
        FROM properties
    ")->fetch(PDO::FETCH_ASSOC);
    
    // Price ranges
    $price_ranges = $db->query("
        SELECT 
            CASE 
                WHEN price < 10000000 THEN 'Under 10M'
                WHEN price < 50000000 THEN '10M - 50M'
                WHEN price < 100000000 THEN '50M - 100M'
                WHEN price < 200000000 THEN '100M - 200M'
                WHEN price < 500000000 THEN '200M - 500M'
                ELSE '500M+'
            END as range,
            COUNT(*) as count
        FROM properties
        GROUP BY range
        ORDER BY range
    ")->fetchAll(PDO::FETCH_ASSOC);
    
    // ===== PERFORMANCE METRICS =====
    
    // Views distribution
    $views_stmt = $db->query("
        SELECT 
            COUNT(*) as total_properties,
            SUM(views) as total_views,
            AVG(views) as avg_views,
            MAX(views) as max_views,
            MIN(views) as min_views
        FROM properties
    ")->fetch(PDO::FETCH_ASSOC);
    
    // Featured performance
    $featured_stmt = $db->query("
        SELECT 
            featured,
            COUNT(*) as count,
            AVG(views) as avg_views,
            SUM(views) as total_views
        FROM properties
        GROUP BY featured
    ")->fetchAll(PDO::FETCH_ASSOC);
    
    // ===== INQUIRY ANALYTICS =====
    
    // Inquiry trends
    $inquiry_trend_stmt = $db->prepare("
        SELECT 
            DATE(created_at) as date,
            COUNT(*) as count,
            SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new,
            SUM(CASE WHEN status = 'replied' THEN 1 ELSE 0 END) as replied
        FROM inquiries
        WHERE created_at >= ?
        GROUP BY DATE(created_at)
        ORDER BY date DESC
        LIMIT 30
    ");
    $inquiry_trend_stmt->execute([$start_date . ' 00:00:00']);
    $inquiry_trends = array_reverse($inquiry_trend_stmt->fetchAll(PDO::FETCH_ASSOC));
    
    // Status distribution
    $inquiry_status_stmt = $db->query("
        SELECT status, COUNT(*) as count
        FROM inquiries
        GROUP BY status
    ")->fetchAll(PDO::FETCH_ASSOC);
    
    // Properties with most inquiries
    $top_inquired_stmt = $db->query("
        SELECT 
            p.id, p.title, COUNT(i.id) as inquiry_count
        FROM properties p
        LEFT JOIN inquiries i ON p.id = i.property_id
        GROUP BY p.id
        ORDER BY inquiry_count DESC
        LIMIT 5
    ")->fetchAll(PDO::FETCH_ASSOC);
    $top_inquired = $top_inquired_stmt;
    
    // ===== VISITOR ANALYTICS =====
    
    // Visitor stats
    $visitor_stmt = $db->prepare("
        SELECT 
            COUNT(*) as total_visits,
            COUNT(DISTINCT ip_address) as unique_visitors,
            SUM(CASE WHEN visit_data LIKE '%true%' THEN 1 ELSE 0 END) as mobile,
            SUM(CASE WHEN visit_data LIKE '%false%' THEN 1 ELSE 0 END) as desktop,
            COUNT(DISTINCT DATE(created_at)) as active_days
        FROM page_visits
        WHERE created_at >= ?
    ");
    $visitor_stmt->execute([$start_date . ' 00:00:00']);
    $visitor_stats = $visitor_stmt->fetch(PDO::FETCH_ASSOC);
    
    // Daily visitor trends
    $daily_visitor_stmt = $db->prepare("
        SELECT 
            DATE(created_at) as date,
            COUNT(*) as visits,
            COUNT(DISTINCT ip_address) as unique
        FROM page_visits
        WHERE created_at >= ?
        GROUP BY DATE(created_at)
        ORDER BY date DESC
        LIMIT 30
    ");
    $daily_visitor_stmt->execute([$start_date . ' 00:00:00']);
    $daily_visitors = array_reverse($daily_visitor_stmt->fetchAll(PDO::FETCH_ASSOC));
    
    // ===== INQUIRY STATISTICS =====
    $inquiry_stats = $db->query("
        SELECT 
            COUNT(*) as total_inquiries,
            SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new_inquiries,
            SUM(CASE WHEN status = 'read' THEN 1 ELSE 0 END) as read_inquiries,
            SUM(CASE WHEN status = 'replied' THEN 1 ELSE 0 END) as replied_inquiries
        FROM inquiries
    ")->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    error_log("Analytics error: " . $e->getMessage());
    // Initialize empty arrays on error
    $property_types = [];
    $property_status = [];
    $top_locations = [];
    $price_stats = [];
    $price_ranges = [];
    $views_stmt = ['total_properties' => 0, 'total_views' => 0, 'avg_views' => 0];
    $featured_stmt = [];
    $inquiry_trends = [];
    $inquiry_status_stmt = [];
    $top_inquired = [];
    $visitor_stats = ['total_visits' => 0, 'unique_visitors' => 0, 'mobile' => 0];
    $daily_visitors = [];
    $inquiry_stats = ['total_inquiries' => 0, 'new_inquiries' => 0, 'read_inquiries' => 0, 'replied_inquiries' => 0];
}

$user = $auth->getUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics & Reports - Property CMS</title>
    <link rel="stylesheet" href="../assets/css/admin-styles.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/sidebar.php'; ?>
        
        <div class="main-content">
            <?php include 'includes/header.php'; ?>
            
            <div class="content-area">
                <div class="page-header">
                    <h1><i class="fas fa-chart-line"></i> Analytics Reports</h1>
                    <div class="page-actions">
                        <select id="dateRange" onchange="changeDateRange()" class="form-control">
                            <option value="7" <?php echo $date_range === 7 ? 'selected' : ''; ?>>Last 7 Days</option>
                            <option value="30" <?php echo $date_range === 30 ? 'selected' : ''; ?>>Last 30 Days</option>
                            <option value="90" <?php echo $date_range === 90 ? 'selected' : ''; ?>>Last 90 Days</option>
                            <option value="180" <?php echo $date_range === 180 ? 'selected' : ''; ?>>Last 6 Months</option>
                            <option value="365" <?php echo $date_range === 365 ? 'selected' : ''; ?>>Last Year</option>
                            <option value="999999" <?php echo $date_range > 999 ? 'selected' : ''; ?>>All Time</option>
                        </select>
                    </div>
                </div>
                
                <!-- KEY METRICS -->
                <div class="report-section">
                    <h3><i class="fas fa-chart-bar"></i> Key Performance Indicators</h3>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-home"></i></div>
                            <div class="stat-content">
                                <h3><?php echo number_format($views_stmt['total_properties'] ?? 0); ?></h3>
                                <p>Total Properties</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-eye"></i></div>
                            <div class="stat-content">
                                <h3><?php echo number_format($views_stmt['total_views'] ?? 0); ?></h3>
                                <p>Total Views</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                            <div class="stat-content">
                                <h3><?php echo number_format($views_stmt['avg_views'] ?? 0, 0); ?></h3>
                                <p>Avg Views/Property</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-envelope"></i></div>
                            <div class="stat-content">
                                <h3><?php echo number_format($visitor_stats['total_visits'] ?? 0); ?></h3>
                                <p>Page Visits</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-users"></i></div>
                            <div class="stat-content">
                                <h3><?php echo number_format($visitor_stats['unique_visitors'] ?? 0); ?></h3>
                                <p>Unique Visitors</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-mobile-alt"></i></div>
                            <div class="stat-content">
                                <h3><?php echo round(($visitor_stats['mobile'] ?? 0) / max($visitor_stats['total_visits'] ?? 1, 1) * 100); ?>%</h3>
                                <p>Mobile Traffic</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-envelope"></i></div>
                            <div class="stat-content">
                                <h3><?php echo number_format($inquiry_stats['total_inquiries'] ?? 0); ?></h3>
                                <p>Total Inquiries</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-star"></i></div>
                            <div class="stat-content">
                                <h3><?php echo number_format($inquiry_stats['new_inquiries'] ?? 0); ?></h3>
                                <p>New Inquiries</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-check"></i></div>
                            <div class="stat-content">
                                <h3><?php echo number_format($inquiry_stats['replied_inquiries'] ?? 0); ?></h3>
                                <p>Replied Inquiries</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- PRICE & PROPERTY STATISTICS -->
                <div class="report-section">
                    <h3><i class="fas fa-dollar-sign"></i> Property Market Statistics</h3>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-content">
                                <h3>TZS <?php echo number_format($price_stats['min_price'] ?? 0, 0); ?></h3>
                                <p>Minimum Price</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-content">
                                <h3>TZS <?php echo number_format($price_stats['max_price'] ?? 0, 0); ?></h3>
                                <p>Maximum Price</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-content">
                                <h3>TZS <?php echo number_format($price_stats['avg_price'] ?? 0, 0); ?></h3>
                                <p>Average Price</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-content">
                                <h3><?php echo number_format($price_stats['count'] ?? 0); ?></h3>
                                <p>Properties Listed</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- CHARTS GRID -->
                <div class="charts-grid">
                    <!-- Property Type Distribution -->
                    <div class="chart-container">
                        <h4>Properties by Type</h4>
                        <canvas id="typeChart"></canvas>
                    </div>
                    
                    <!-- Property Status -->
                    <div class="chart-container">
                        <h4>Status Distribution</h4>
                        <canvas id="statusChart"></canvas>
                    </div>
                    
                    <!-- Views Trend -->
                    <div class="chart-container">
                        <h4>Daily Visitors (Last 30 Days)</h4>
                        <canvas id="visitorChart"></canvas>
                    </div>
                    
                    <!-- Inquiry Trend -->
                    <div class="chart-container">
                        <h4>Daily Inquiries Trend</h4>
                        <canvas id="inquiryChart"></canvas>
                    </div>
                    
                    <!-- Price Distribution -->
                    <div class="chart-container">
                        <h4>Price Range Distribution</h4>
                        <canvas id="priceChart"></canvas>
                    </div>
                    
                    <!-- Featured vs Regular -->
                    <div class="chart-container">
                        <h4>Featured vs Regular Performance</h4>
                        <canvas id="featuredChart"></canvas>
                    </div>
                </div>
                
                <!-- DETAILED TABLES -->
                
                <!-- Top Inquired Properties -->
                <div class="report-section">
                    <h3>Top Inquired Properties</h3>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Property</th>
                                    <th>Inquiries</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($top_inquired as $prop): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($prop['title']); ?></td>
                                        <td><?php echo number_format($prop['inquiry_count']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Top Locations -->
                <div class="report-section">
                    <h3>Top Locations</h3>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Location</th>
                                    <th>Properties</th>
                                    <th>Avg Price</th>
                                    <th>Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($top_locations as $loc): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($loc['location']); ?></td>
                                        <td><?php echo number_format($loc['count']); ?></td>
                                        <td>TZS <?php echo number_format($loc['avg_price'], 0); ?></td>
                                        <td><?php echo number_format($loc['views']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- SUMMARY & INSIGHTS -->
                <div class="report-section">
                    <h3><i class="fas fa-lightbulb"></i> Key Insights & Summary</h3>
                    <div class="insights-container">
                        <div class="insight-item">
                            <h4><i class="fas fa-check-circle"></i> Property Performance</h4>
                            <p>
                                You have <strong><?php echo number_format($views_stmt['total_properties'] ?? 0); ?></strong> properties listed 
                                with <strong><?php echo number_format($views_stmt['total_views'] ?? 0); ?></strong> total views. 
                                The average views per property is <strong><?php echo number_format($views_stmt['avg_views'] ?? 0, 0); ?></strong>.
                            </p>
                        </div>
                        
                        <div class="insight-item">
                            <h4><i class="fas fa-envelope"></i> Inquiry Status</h4>
                            <p>
                                You have received <strong><?php echo number_format($inquiry_stats['total_inquiries'] ?? 0); ?></strong> total inquiries. 
                                <strong><?php echo number_format($inquiry_stats['new_inquiries'] ?? 0); ?></strong> are new, 
                                <strong><?php echo number_format($inquiry_stats['replied_inquiries'] ?? 0); ?></strong> have been replied to.
                            </p>
                        </div>
                        
                        <div class="insight-item">
                            <h4><i class="fas fa-chart-line"></i> Market Price Range</h4>
                            <p>
                                Property prices range from <strong>TZS <?php echo number_format($price_stats['min_price'] ?? 0, 0); ?></strong> 
                                to <strong>TZS <?php echo number_format($price_stats['max_price'] ?? 0, 0); ?></strong>, 
                                with an average of <strong>TZS <?php echo number_format($price_stats['avg_price'] ?? 0, 0); ?></strong>.
                            </p>
                        </div>
                        
                        <div class="insight-item">
                            <h4><i class="fas fa-users"></i> Visitor Analytics</h4>
                            <p>
                                You've had <strong><?php echo number_format($visitor_stats['total_visits'] ?? 0); ?></strong> page visits 
                                from <strong><?php echo number_format($visitor_stats['unique_visitors'] ?? 0); ?></strong> unique visitors. 
                                <strong><?php echo round(($visitor_stats['mobile'] ?? 0) / max($visitor_stats['total_visits'] ?? 1, 1) * 100); ?>%</strong> of traffic is from mobile devices.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    labels: { color: '#666' }
                }
            }
        };
        
        // Type Chart
        new Chart(document.getElementById('typeChart'), {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_column($property_types, 'property_type')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($property_types, 'count')); ?>,
                    backgroundColor: ['#667eea', '#764ba2', '#f093fb', '#f5576c']
                }]
            },
            options: chartOptions
        });
        
        // Status Chart
        new Chart(document.getElementById('statusChart'), {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($property_status, 'status')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($property_status, 'count')); ?>,
                    backgroundColor: ['#28a745', '#dc3545', '#ffc107']
                }]
            },
            options: chartOptions
        });
        
        // Visitor Chart
        new Chart(document.getElementById('visitorChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($daily_visitors, 'date')); ?>,
                datasets: [{
                    label: 'Visits',
                    data: <?php echo json_encode(array_column($daily_visitors, 'visits')); ?>,
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                ...chartOptions,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
        
        // Inquiry Chart
        new Chart(document.getElementById('inquiryChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($inquiry_trends, 'date')); ?>,
                datasets: [{
                    label: 'Inquiries',
                    data: <?php echo json_encode(array_column($inquiry_trends, 'count')); ?>,
                    backgroundColor: 'rgba(240, 147, 251, 0.8)',
                    borderColor: '#f093fb'
                }]
            },
            options: chartOptions
        });
        
        // Price Chart
        new Chart(document.getElementById('priceChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($price_ranges, 'range')); ?>,
                datasets: [{
                    label: 'Count',
                    data: <?php echo json_encode(array_column($price_ranges, 'count')); ?>,
                    backgroundColor: 'rgba(102, 126, 234, 0.8)'
                }]
            },
            options: chartOptions
        });
        
        // Featured Chart
        new Chart(document.getElementById('featuredChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_map(fn($f) => $f['featured'] ? 'Featured' : 'Regular', $featured_stmt)); ?>,
                datasets: [{
                    label: 'Avg Views',
                    data: <?php echo json_encode(array_column($featured_stmt, 'avg_views')); ?>,
                    backgroundColor: ['#667eea', '#f093fb']
                }]
            },
            options: chartOptions
        });
        
        function changeDateRange() {
            const range = document.getElementById('dateRange').value;
            window.location.href = `analytics.php?range=${range}`;
        }
    </script>
    <script src="../assets/js/admin-scripts.js"></script>
</body>
</html>
