<?php
require_once 'auth.php';
require_once '../config/database.php';

$auth = new Auth();
$auth->requireLogin();

$db = Database::getInstance()->getConnection();

// Get dashboard statistics
try {
    $stats = [];
    
    // Total properties
    $stmt = $db->query("SELECT COUNT(*) as total FROM properties");
    $stats['total_properties'] = $stmt->fetchColumn();
    
    // Available properties
    $stmt = $db->query("SELECT COUNT(*) as available FROM properties WHERE status = 'available'");
    $stats['available_properties'] = $stmt->fetchColumn();
    
    // Featured properties
    $stmt = $db->query("SELECT COUNT(*) as featured FROM properties WHERE featured = 1");
    $stats['featured_properties'] = $stmt->fetchColumn();
    
    // Total inquiries
    $stmt = $db->query("SELECT COUNT(*) as total FROM inquiries");
    $stats['total_inquiries'] = $stmt->fetchColumn();
    
    // New inquiries
    $stmt = $db->query("SELECT COUNT(*) as new FROM inquiries WHERE status = 'new'");
    $stats['new_inquiries'] = $stmt->fetchColumn();
    
    // Total views
    $stmt = $db->query("SELECT SUM(views) as total FROM properties");
    $stats['total_views'] = $stmt->fetchColumn() ?? 0;
    
    // Sold properties
    $stmt = $db->query("SELECT COUNT(*) as sold FROM properties WHERE status = 'sold'");
    $stats['sold_properties'] = $stmt->fetchColumn();
    
    // Recent properties
    $stmt = $db->query("SELECT * FROM properties ORDER BY created_at DESC LIMIT 5");
    $recent_properties = $stmt->fetchAll();
    
    // Top performing properties
    $stmt = $db->query("
        SELECT id, title, location, views, price, status 
        FROM properties 
        ORDER BY views DESC LIMIT 3
    ");
    $top_properties = $stmt->fetchAll();
    
} catch (PDOException $e) {
    $stats = [];
    $recent_properties = [];
    $top_properties = [];
    error_log("Dashboard error: " . $e->getMessage());
}

$user = $auth->getUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Property CMS</title>
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
                    <h1>Dashboard</h1>
                    <p>Welcome back, <?php echo htmlspecialchars($user['full_name']); ?>!</p>
                </div>
                
                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($stats['total_properties'] ?? 0); ?></h3>
                            <p>Total Properties</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($stats['available_properties'] ?? 0); ?></h3>
                            <p>Available</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($stats['featured_properties'] ?? 0); ?></h3>
                            <p>Featured</p>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Activity -->
                <div class="dashboard-grid">
                    <!-- Recent Properties -->
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h2>Recent Properties</h2>
                            <a href="properties.php" class="btn-link">View All</a>
                        </div>
                        
                        <div class="recent-items">
                            <?php if (empty($recent_properties)): ?>
                                <p class="no-data">No properties found.</p>
                            <?php else: ?>
                                <?php foreach ($recent_properties as $property): ?>
                                    <div class="recent-item">
                                        <div class="item-info">
                                            <h4><?php echo htmlspecialchars($property['title']); ?></h4>
                                            <p><?php echo htmlspecialchars($property['location']); ?> • TZS <?php echo number_format($property['price']); ?></p>
                                            <span class="item-date"><?php echo date('M j, Y', strtotime($property['created_at'])); ?></span>
                                        </div>
                                        <div class="item-status">
                                            <span class="status-badge status-<?php echo $property['status']; ?>">
                                                <?php echo ucfirst($property['status']); ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Recent Inquiries -->
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h2>Recent Inquiries</h2>
                            <a href="inquiries.php" class="btn-link">View All</a>
                        </div>
                        
                        <div class="recent-items">
                            <?php if (empty($recent_inquiries)): ?>
                                <p class="no-data">No inquiries found.</p>
                            <?php else: ?>
                                <?php foreach ($recent_inquiries as $inquiry): ?>
                                    <div class="recent-item">
                                        <div class="item-info">
                                            <h4><?php echo htmlspecialchars($inquiry['name']); ?></h4>
                                            <p><?php echo htmlspecialchars($inquiry['property_title'] ?? 'General Inquiry'); ?></p>
                                            <span class="item-date"><?php echo date('M j, Y', strtotime($inquiry['created_at'])); ?></span>
                                        </div>
                                        <div class="item-status">
                                            <span class="status-badge status-<?php echo $inquiry['status']; ?>">
                                                <?php echo ucfirst($inquiry['status']); ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Top Performing Properties -->
                <?php if (!empty($top_properties)): ?>
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2>Top Performing Properties</h2>
                        <a href="properties.php" class="btn-link">View All</a>
                    </div>
                    
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Property</th>
                                    <th>Location</th>
                                    <th>Views</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($top_properties as $property): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($property['title']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($property['location']); ?></td>
                                        <td><?php echo number_format($property['views']); ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo $property['status']; ?>">
                                                <?php echo ucfirst($property['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="../assets/js/admin-scripts.js"></script>
</body>
</html>
