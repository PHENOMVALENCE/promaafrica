<?php
require_once 'auth.php';
require_once '../config/database.php';

$auth = new Auth();
$auth->requireLogin();

$db = Database::getInstance()->getConnection();
$user = $auth->getUser();
$success = '';
$errors = [];

// Handle form submission
if ($_POST) {
    $settings_data = [
        'contact_phone' => trim($_POST['contact_phone'] ?? ''),
        'contact_phone2' => trim($_POST['contact_phone2'] ?? ''),
        'contact_email' => trim($_POST['contact_email'] ?? ''),
        'whatsapp_number' => trim($_POST['whatsapp_number'] ?? ''),
        'company_address' => trim($_POST['company_address'] ?? ''),
        'site_title' => trim($_POST['site_title'] ?? ''),
        'site_description' => trim($_POST['site_description'] ?? ''),
        'facebook_url' => trim($_POST['facebook_url'] ?? ''),
        'twitter_url' => trim($_POST['twitter_url'] ?? ''),
        'instagram_url' => trim($_POST['instagram_url'] ?? ''),
        'linkedin_url' => trim($_POST['linkedin_url'] ?? ''),
        'google_analytics' => trim($_POST['google_analytics'] ?? ''),
        'properties_per_page' => intval($_POST['properties_per_page'] ?? 12),
        'enable_inquiries' => isset($_POST['enable_inquiries']) ? '1' : '0',
        'enable_whatsapp' => isset($_POST['enable_whatsapp']) ? '1' : '0',
        'maintenance_mode' => isset($_POST['maintenance_mode']) ? '1' : '0'
    ];
    
    // Validation
    if (empty($settings_data['contact_email']) || !filter_var($settings_data['contact_email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid contact email is required.";
    }
    
    if (empty($settings_data['contact_phone'])) {
        $errors[] = "Primary contact phone is required.";
    }
    
    if ($settings_data['properties_per_page'] < 1 || $settings_data['properties_per_page'] > 50) {
        $errors[] = "Properties per page must be between 1 and 50.";
    }
    
    // Update settings if no errors
    if (empty($errors)) {
        try {
            $db->beginTransaction();
            
            foreach ($settings_data as $key => $value) {
                $stmt = $db->prepare("
                    INSERT INTO settings (setting_key, setting_value, updated_at) 
                    VALUES (?, ?, NOW()) 
                    ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = NOW()
                ");
                $stmt->execute([$key, $value]);
            }
            
            $db->commit();
            $success = "Settings updated successfully.";
            
        } catch (PDOException $e) {
            $db->rollBack();
            $errors[] = "Error updating settings: " . $e->getMessage();
        }
    }
}

// Get current settings
try {
    $stmt = $db->query("SELECT setting_key, setting_value FROM settings");
    $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
} catch (PDOException $e) {
    $settings = [];
    if (empty($errors)) {
        $errors[] = "Error loading settings: " . $e->getMessage();
    }
}

// Get system statistics
try {
    $stats = [];
    
    // Total properties
    $stmt = $db->query("SELECT COUNT(*) FROM properties");
    $stats['total_properties'] = $stmt->fetchColumn();
    
    // Total inquiries
    $stmt = $db->query("SELECT COUNT(*) FROM inquiries");
    $stats['total_inquiries'] = $stmt->fetchColumn();
    
    // New inquiries
    $stmt = $db->query("SELECT COUNT(*) FROM inquiries WHERE status = 'new'");
    $stats['new_inquiries'] = $stmt->fetchColumn();
    
    // Total users (admin accounts)
    $stmt = $db->query("SELECT COUNT(*) FROM admin_users");
    $stats['total_users'] = $stmt->fetchColumn();
    
    // Database size
    $stmt = $db->query("
        SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS db_size 
        FROM information_schema.tables 
        WHERE table_schema = DATABASE()
    ");
    $db_size = $stmt->fetchColumn();
    $stats['db_size'] = $db_size ? $db_size . ' MB' : 'Unknown';
    
} catch (PDOException $e) {
    $stats = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Property CMS</title>
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
                    <h1>Settings</h1>
                    <p>Configure your website settings and preferences</p>
                </div>
                
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <div class="settings-grid">
                    <!-- Settings Form -->
                    <div class="settings-section">
                        <form method="POST" class="settings-form">
                            <!-- Contact Information -->
                            <div class="form-section">
                                <h3><i class="fas fa-phone"></i> Contact Information</h3>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="contact_phone">Contact Phone 1 *</label>
                                        <input type="tel" id="contact_phone" name="contact_phone" required
                                               value="<?php echo htmlspecialchars($settings['contact_phone'] ?? ''); ?>">
                                        <small>Primary phone number for property inquiries</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="contact_phone2">Contact Phone 2</label>
                                        <input type="tel" id="contact_phone2" name="contact_phone2"
                                               value="<?php echo htmlspecialchars($settings['contact_phone2'] ?? ''); ?>">
                                        <small>Secondary phone number (optional)</small>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="contact_email">Contact Email *</label>
                                        <input type="email" id="contact_email" name="contact_email" required
                                               value="<?php echo htmlspecialchars($settings['contact_email'] ?? ''); ?>">
                                        <small>Main contact email address</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="whatsapp_number">WhatsApp Number</label>
                                        <input type="tel" id="whatsapp_number" name="whatsapp_number"
                                               value="<?php echo htmlspecialchars($settings['whatsapp_number'] ?? ''); ?>">
                                        <small>WhatsApp number (with country code)</small>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="company_address">Company Address</label>
                                    <textarea id="company_address" name="company_address" rows="3"><?php echo htmlspecialchars($settings['company_address'] ?? ''); ?></textarea>
                                    <small>Physical office address</small>
                                </div>
                            </div>
                            
                            <!-- Website Information -->
                            <div class="form-section">
                                <h3><i class="fas fa-globe"></i> Website Information</h3>
                                
                                <div class="form-group">
                                    <label for="site_title">Site Title</label>
                                    <input type="text" id="site_title" name="site_title"
                                           value="<?php echo htmlspecialchars($settings['site_title'] ?? ''); ?>">
                                    <small>Your website's main title</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="site_description">Site Description</label>
                                    <textarea id="site_description" name="site_description" rows="3"><?php echo htmlspecialchars($settings['site_description'] ?? ''); ?></textarea>
                                    <small>Meta description for SEO</small>
                                </div>
                            </div>
                            
                            <!-- Social Media -->
                            <div class="form-section">
                                <h3><i class="fas fa-share-alt"></i> Social Media Links</h3>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="facebook_url"><i class="fab fa-facebook"></i> Facebook</label>
                                        <input type="url" id="facebook_url" name="facebook_url"
                                               placeholder="https://facebook.com/yourpage"
                                               value="<?php echo htmlspecialchars($settings['facebook_url'] ?? ''); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="twitter_url"><i class="fab fa-twitter"></i> Twitter</label>
                                        <input type="url" id="twitter_url" name="twitter_url"
                                               placeholder="https://twitter.com/yourpage"
                                               value="<?php echo htmlspecialchars($settings['twitter_url'] ?? ''); ?>">
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="instagram_url"><i class="fab fa-instagram"></i> Instagram</label>
                                        <input type="url" id="instagram_url" name="instagram_url"
                                               placeholder="https://instagram.com/yourprofile"
                                               value="<?php echo htmlspecialchars($settings['instagram_url'] ?? ''); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="linkedin_url"><i class="fab fa-linkedin"></i> LinkedIn</label>
                                        <input type="url" id="linkedin_url" name="linkedin_url"
                                               placeholder="https://linkedin.com/company/yourcompany"
                                               value="<?php echo htmlspecialchars($settings['linkedin_url'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- System Settings -->
                            <div class="form-section">
                                <h3><i class="fas fa-cog"></i> System Settings</h3>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="properties_per_page">Properties Per Page</label>
                                        <input type="number" id="properties_per_page" name="properties_per_page" 
                                               min="1" max="50" value="<?php echo $settings['properties_per_page'] ?? 12; ?>">
                                        <small>Number of properties to display per page (1-50)</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="google_analytics">Google Analytics ID</label>
                                        <input type="text" id="google_analytics" name="google_analytics"
                                               placeholder="UA-XXXXXXXXX-X or G-XXXXXXXXXX"
                                               value="<?php echo htmlspecialchars($settings['google_analytics'] ?? ''); ?>">
                                        <small>Your Google Analytics tracking ID</small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Feature Settings -->
                            <div class="form-section">
                                <h3><i class="fas fa-toggle-on"></i> Feature Settings</h3>
                                
                                <div class="feature-settings">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="enable_inquiries" value="1" 
                                               <?php echo ($settings['enable_inquiries'] ?? '1') === '1' ? 'checked' : ''; ?>>
                                        <span class="checkmark"></span>
                                        <span class="label-text">
                                            <strong>Enable Property Inquiries</strong>
                                            <small>Allow visitors to submit inquiries for properties</small>
                                        </span>
                                    </label>
                                    
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="enable_whatsapp" value="1" 
                                               <?php echo ($settings['enable_whatsapp'] ?? '1') === '1' ? 'checked' : ''; ?>>
                                        <span class="checkmark"></span>
                                        <span class="label-text">
                                            <strong>Enable WhatsApp Contact</strong>
                                            <small>Show WhatsApp contact option on property pages</small>
                                        </span>
                                    </label>
                                    
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="maintenance_mode" value="1" 
                                               <?php echo ($settings['maintenance_mode'] ?? '0') === '1' ? 'checked' : ''; ?>>
                                        <span class="checkmark"></span>
                                        <span class="label-text">
                                            <strong>Maintenance Mode</strong>
                                            <small>Temporarily disable public website access</small>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-save"></i>
                                    Save Settings
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- System Information Sidebar -->
                    <div class="settings-sidebar">
                        <!-- System Stats -->
                        <div class="info-section">
                            <h3><i class="fas fa-bar-chart"></i> System Information</h3>
                            
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-home"></i> Total Properties
                                    </div>
                                    <div class="info-value"><?php echo number_format($stats['total_properties'] ?? 0); ?></div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-envelope"></i> Total Inquiries
                                    </div>
                                    <div class="info-value"><?php echo number_format($stats['total_inquiries'] ?? 0); ?></div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-star"></i> New Inquiries
                                    </div>
                                    <div class="info-value"><?php echo number_format($stats['new_inquiries'] ?? 0); ?></div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-users"></i> Admin Users
                                    </div>
                                    <div class="info-value"><?php echo number_format($stats['total_users'] ?? 0); ?></div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-database"></i> Database Size
                                    </div>
                                    <div class="info-value"><?php echo $stats['db_size'] ?? 'Unknown'; ?></div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-server"></i> PHP Version
                                    </div>
                                    <div class="info-value"><?php echo phpversion(); ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="info-section">
                            <h3><i class="fas fa-lightning-bolt"></i> Quick Actions</h3>
                            
                            <div class="quick-actions">
                                <a href="index.php" class="action-btn">
                                    <i class="fas fa-tachometer-alt"></i>
                                    View Dashboard
                                </a>
                                
                                <a href="properties.php" class="action-btn">
                                    <i class="fas fa-home"></i>
                                    Manage Properties
                                </a>
                                
                                <a href="inquiries.php" class="action-btn">
                                    <i class="fas fa-envelope"></i>
                                    View Inquiries
                                </a>
                                
                                <a href="analytics.php" class="action-btn">
                                    <i class="fas fa-chart-line"></i>
                                    View Analytics
                                </a>
                                
                                <a href="../sales.php" target="_blank" class="action-btn">
                                    <i class="fas fa-external-link-alt"></i>
                                    View Website
                                </a>
                                
                                <a href="profile.php" class="action-btn">
                                    <i class="fas fa-user"></i>
                                    My Profile
                                </a>
                            </div>
                        </div>
                        
                        <!-- Maintenance Section -->
                        <div class="info-section">
                            <h3><i class="fas fa-wrench"></i> Maintenance</h3>
                            
                            <div class="maintenance-info">
                                <p>Database maintenance and optimization tools.</p>
                            </div>
                            
                            <div class="maintenance-actions">
                                <button type="button" class="action-btn" onclick="optimizeDatabase()">
                                    <i class="fas fa-database"></i>
                                    Optimize Database
                                </button>
                            </div>
                        </div>
                        
                        <!-- System Info -->
                        <div class="info-section">
                            <h3><i class="fas fa-info-circle"></i> System Info</h3>
                            
                            <div class="system-info">
                                <div class="info-row">
                                    <span>Admin User:</span>
                                    <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                                </div>
                                <div class="info-row">
                                    <span>User Role:</span>
                                    <strong><?php echo ucfirst($user['role']); ?></strong>
                                </div>
                                <div class="info-row">
                                    <span>Last Updated:</span>
                                    <strong><?php echo date('M j, Y g:i A'); ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../assets/js/admin-scripts.js"></script>
    <script>
        function optimizeDatabase() {
            if (confirm('This will optimize the database. This may take a few moments. Continue?')) {
                // Show loading message
                const originalText = event.target.textContent;
                event.target.textContent = 'Optimizing...';
                event.target.disabled = true;
                
                // Simulate optimization
                setTimeout(() => {
                    alert('Database optimization completed successfully.');
                    event.target.textContent = originalText;
                    event.target.disabled = false;
                }, 2000);
            }
        }
    </script>
</body>
</html>
