<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar">
    <div class="sidebar-header">
        <h2>Property CMS</h2>
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <li class="<?php echo $current_page === 'index.php' ? 'active' : ''; ?>">
                <a href="index.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="<?php echo $current_page === 'properties.php' ? 'active' : ''; ?>">
                <a href="properties.php">
                    <i class="fas fa-home"></i>
                    <span>Properties</span>
                </a>
            </li>
            
            <li class="<?php echo $current_page === 'add-property.php' ? 'active' : ''; ?>">
                <a href="add-property.php">
                    <i class="fas fa-plus"></i>
                    <span>Add Property</span>
                </a>
            </li>
            
            <li class="<?php echo $current_page === 'analytics.php' ? 'active' : ''; ?>">
                <a href="analytics.php">
                    <i class="fas fa-chart-line"></i>
                    <span>Analytics</span>
                </a>
            </li>
            
            <li class="<?php echo $current_page === 'settings.php' ? 'active' : ''; ?>">
                <a href="settings.php">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
