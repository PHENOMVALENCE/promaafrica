<?php
require_once 'auth.php';
require_once '../config/database.php';

$auth = new Auth();
$auth->requireLogin();

$db = Database::getInstance()->getConnection();
$user = $auth->getUser();

// Handle actions
$success = '';
$error = '';

// Mark as replied
if (isset($_POST['mark_replied']) && isset($_POST['inquiry_id'])) {
    try {
        $stmt = $db->prepare("UPDATE inquiries SET status = 'replied' WHERE id = ?");
        $stmt->execute([$_POST['inquiry_id']]);
        $success = "Inquiry marked as replied.";
    } catch (PDOException $e) {
        $error = "Error updating inquiry: " . $e->getMessage();
    }
}

// Delete inquiry
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    try {
        $stmt = $db->prepare("DELETE FROM inquiries WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        $success = "Inquiry deleted successfully.";
    } catch (PDOException $e) {
        $error = "Error deleting inquiry: " . $e->getMessage();
    }
}

// Bulk actions
if (isset($_POST['bulk_action']) && !empty($_POST['selected_inquiries'])) {
    $action = $_POST['bulk_action'];
    $selected_ids = array_map('intval', $_POST['selected_inquiries']);
    
    try {
        if ($action === 'delete') {
            $placeholders = str_repeat('?,', count($selected_ids) - 1) . '?';
            $stmt = $db->prepare("DELETE FROM inquiries WHERE id IN ($placeholders)");
            $stmt->execute($selected_ids);
            $success = count($selected_ids) . " inquiries deleted.";
        } elseif ($action === 'mark_read') {
            $placeholders = str_repeat('?,', count($selected_ids) - 1) . '?';
            $stmt = $db->prepare("UPDATE inquiries SET status = 'read' WHERE id IN ($placeholders)");
            $stmt->execute($selected_ids);
            $success = count($selected_ids) . " inquiries marked as read.";
        } elseif ($action === 'mark_replied') {
            $placeholders = str_repeat('?,', count($selected_ids) - 1) . '?';
            $stmt = $db->prepare("UPDATE inquiries SET status = 'replied' WHERE id IN ($placeholders)");
            $stmt->execute($selected_ids);
            $success = count($selected_ids) . " inquiries marked as replied.";
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Get filters
$search = trim($_GET['search'] ?? '');
$status = $_GET['status'] ?? '';
$property = $_GET['property'] ?? '';
$sort_by = $_GET['sort'] ?? 'newest';
$page = max(1, intval($_GET['page'] ?? 1));
$per_page = 20;

// Build query
$conditions = [];
$params = [];

if (!empty($search)) {
    $conditions[] = "(name LIKE ? OR email LIKE ? OR phone LIKE ? OR message LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($status)) {
    $conditions[] = "status = ?";
    $params[] = $status;
}

if (!empty($property)) {
    $conditions[] = "property_id = ?";
    $params[] = intval($property);
}

$where_clause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

// Determine sort
$order_by = "created_at DESC";
switch ($sort_by) {
    case 'oldest':
        $order_by = "created_at ASC";
        break;
    case 'status':
        $order_by = "status ASC, created_at DESC";
        break;
}

try {
    // Get total count
    $count_sql = "SELECT COUNT(*) FROM inquiries $where_clause";
    $count_stmt = $db->prepare($count_sql);
    $count_stmt->execute($params);
    $total = $count_stmt->fetchColumn();
    $total_pages = ceil($total / $per_page);
    
    // Get inquiries
    $offset = ($page - 1) * $per_page;
    $sql = "
        SELECT i.*, p.title as property_title, p.price 
        FROM inquiries i 
        LEFT JOIN properties p ON i.property_id = p.id 
        $where_clause 
        ORDER BY $order_by
        LIMIT $per_page OFFSET $offset
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $inquiries = $stmt->fetchAll();
    
    // Get properties list
    $props_stmt = $db->query("SELECT id, title FROM properties ORDER BY title");
    $properties = $props_stmt->fetchAll();
    
    // Get statistics
    $stats_stmt = $db->query("
        SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new,
            SUM(CASE WHEN status = 'read' THEN 1 ELSE 0 END) as read,
            SUM(CASE WHEN status = 'replied' THEN 1 ELSE 0 END) as replied,
            COUNT(DISTINCT property_id) as property_inquired,
            COUNT(DISTINCT email) as unique_emails
        FROM inquiries
    ");
    $stats = $stats_stmt->fetch();
    
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
    $inquiries = [];
    $properties = [];
    $stats = null;
    $total = 0;
    $total_pages = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiries - Property CMS</title>
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
                    <h1><i class="fas fa-envelope"></i> Inquiries Management</h1>
                    <div class="page-actions">
                        <span class="inquiry-count">
                            Total: <?php echo number_format($total); ?>
                        </span>
                    </div>
                </div>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <!-- Statistics -->
                <?php if ($stats): ?>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-envelope"></i></div>
                        <div class="stat-content">
                            <h3><?php echo number_format($stats['total']); ?></h3>
                            <p>Total Inquiries</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-star"></i></div>
                        <div class="stat-content">
                            <h3><?php echo number_format($stats['new']); ?></h3>
                            <p>New</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-check"></i></div>
                        <div class="stat-content">
                            <h3><?php echo number_format($stats['read']); ?></h3>
                            <p>Read</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-reply"></i></div>
                        <div class="stat-content">
                            <h3><?php echo number_format($stats['replied']); ?></h3>
                            <p>Replied</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-home"></i></div>
                        <div class="stat-content">
                            <h3><?php echo number_format($stats['property_inquired']); ?></h3>
                            <p>Properties Inquired</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-user"></i></div>
                        <div class="stat-content">
                            <h3><?php echo number_format($stats['unique_emails']); ?></h3>
                            <p>Unique Contacts</p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Filters -->
                <div class="filters-section">
                    <form method="GET" class="filters-form">
                        <div class="filter-row">
                            <div class="filter-group">
                                <input type="text" name="search" placeholder="Search name, email, phone..." 
                                       value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                            
                            <div class="filter-group">
                                <select name="status">
                                    <option value="">All Status</option>
                                    <option value="new" <?php echo $status === 'new' ? 'selected' : ''; ?>>New</option>
                                    <option value="read" <?php echo $status === 'read' ? 'selected' : ''; ?>>Read</option>
                                    <option value="replied" <?php echo $status === 'replied' ? 'selected' : ''; ?>>Replied</option>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <select name="property">
                                    <option value="">All Properties</option>
                                    <?php foreach ($properties as $prop): ?>
                                        <option value="<?php echo $prop['id']; ?>" 
                                                <?php echo $property == $prop['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($prop['title']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <select name="sort">
                                    <option value="newest" <?php echo $sort_by === 'newest' ? 'selected' : ''; ?>>Newest</option>
                                    <option value="oldest" <?php echo $sort_by === 'oldest' ? 'selected' : ''; ?>>Oldest</option>
                                    <option value="status" <?php echo $sort_by === 'status' ? 'selected' : ''; ?>>Status</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn-search">
                                <i class="fas fa-search"></i> Search
                            </button>
                            
                            <a href="inquiries.php" class="btn-reset">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
                
                <!-- Inquiries Table -->
                <div class="table-container">
                    <form method="POST" id="inquiriesForm">
                        <div class="table-toolbar">
                            <div class="bulk-actions">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                    <span class="checkmark"></span>
                                </label>
                                
                                <select name="bulk_action" id="bulkAction" class="form-control">
                                    <option value="">Bulk Actions...</option>
                                    <option value="mark_read">Mark as Read</option>
                                    <option value="mark_replied">Mark as Replied</option>
                                    <option value="delete">Delete</option>
                                </select>
                                
                                <button type="submit" class="btn-primary" onclick="return confirmBulkAction()">
                                    Apply
                                </button>
                            </div>
                        </div>
                        
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th style="width: 40px;"></th>
                                    <th>Name & Email</th>
                                    <th>Phone</th>
                                    <th>Property</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($inquiries)): ?>
                                    <tr>
                                        <td colspan="8" class="no-data">No inquiries found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($inquiries as $inquiry): ?>
                                        <tr class="inquiry-row status-<?php echo $inquiry['status']; ?>">
                                            <td>
                                                <label class="checkbox-label">
                                                    <input type="checkbox" name="selected_inquiries[]" 
                                                           value="<?php echo $inquiry['id']; ?>" class="inquiry-checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="contact-info">
                                                    <strong><?php echo htmlspecialchars($inquiry['name']); ?></strong>
                                                    <br>
                                                    <a href="mailto:<?php echo htmlspecialchars($inquiry['email']); ?>" 
                                                       class="email-link">
                                                        <?php echo htmlspecialchars($inquiry['email']); ?>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if (!empty($inquiry['phone'])): ?>
                                                    <a href="tel:<?php echo htmlspecialchars($inquiry['phone']); ?>" 
                                                       class="phone-link">
                                                        <?php echo htmlspecialchars($inquiry['phone']); ?>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($inquiry['property_title'])): ?>
                                                    <a href="view-property.php?id=<?php echo $inquiry['property_id']; ?>" 
                                                       class="property-link">
                                                        <?php echo htmlspecialchars($inquiry['property_title']); ?>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">General</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="message-preview" onclick="viewInquiry(<?php echo $inquiry['id']; ?>)" 
                                                     style="cursor: pointer;">
                                                    <?php echo htmlspecialchars(substr($inquiry['message'], 0, 60)); ?>
                                                    <?php if (strlen($inquiry['message']) > 60): ?>
                                                        ...
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <form method="POST" class="inline-form" onsubmit="event.stopPropagation();">
                                                    <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['id']; ?>">
                                                    <select name="status" onchange="this.form.submit()" 
                                                            class="status-select status-<?php echo $inquiry['status']; ?>">
                                                        <option value="new" <?php echo $inquiry['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                                                        <option value="read" <?php echo $inquiry['status'] === 'read' ? 'selected' : ''; ?>>Read</option>
                                                        <option value="replied" <?php echo $inquiry['status'] === 'replied' ? 'selected' : ''; ?>>Replied</option>
                                                    </select>
                                                    <input type="hidden" name="update_status" value="1">
                                                </form>
                                            </td>
                                            <td>
                                                <small>
                                                    <div><?php echo date('M d, Y', strtotime($inquiry['created_at'])); ?></div>
                                                    <div><?php echo date('g:i A', strtotime($inquiry['created_at'])); ?></div>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button type="button" class="btn-action btn-view" 
                                                            onclick="viewInquiry(<?php echo $inquiry['id']; ?>)" 
                                                            title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    
                                                    <a href="mailto:<?php echo htmlspecialchars($inquiry['email']); ?>?subject=Re: Property Inquiry&body=Thank you for your inquiry!" 
                                                       class="btn-action btn-reply" title="Reply">
                                                        <i class="fas fa-reply"></i>
                                                    </a>
                                                    
                                                    <a href="?delete=<?php echo $inquiry['id']; ?>" 
                                                       class="btn-action btn-delete" title="Delete"
                                                       onclick="return confirm('Delete this inquiry?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </form>
                </div>
                
                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>&<?php echo http_build_query($_GET); ?>" 
                               class="pagination-btn">
                                <i class="fas fa-chevron-left"></i> Previous
                            </a>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                            <?php if ($i === $page): ?>
                                <span class="pagination-btn active"><?php echo $i; ?></span>
                            <?php else: ?>
                                <a href="?page=<?php echo $i; ?>&<?php echo http_build_query($_GET); ?>" 
                                   class="pagination-btn"><?php echo $i; ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        
                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page + 1; ?>&<?php echo http_build_query($_GET); ?>" 
                               class="pagination-btn">
                                Next <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Detail Modal -->
    <div id="inquiryModal" class="modal">
        <div class="modal-overlay" onclick="closeInquiryModal()"></div>
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h3>Inquiry Details</h3>
                <button class="modal-close" onclick="closeInquiryModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="inquiryDetails">
                <!-- Loaded via JS -->
            </div>
        </div>
    </div>
    
    <script>
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            document.querySelectorAll('.inquiry-checkbox').forEach(cb => {
                cb.checked = selectAll.checked;
            });
        }
        
        function confirmBulkAction() {
            const action = document.getElementById('bulkAction').value;
            const checked = document.querySelectorAll('.inquiry-checkbox:checked').length;
            
            if (!action) {
                alert('Select an action');
                return false;
            }
            if (checked === 0) {
                alert('Select inquiries');
                return false;
            }
            return confirm(`${action} ${checked} inquiries?`);
        }
        
        function viewInquiry(id) {
            const modal = document.getElementById('inquiryModal');
            const details = document.getElementById('inquiryDetails');
            const row = document.querySelector(`[onclick*="viewInquiry(${id})"]`)?.closest('tr');
            
            if (!row) return;
            
            const cells = row.querySelectorAll('td');
            const name = cells[1]?.textContent.split('\n')[0]?.trim() || '';
            const email = cells[1]?.querySelector('.email-link')?.textContent.trim() || '';
            const phone = cells[2]?.textContent.trim() || '-';
            const property = cells[3]?.textContent.trim() || 'General';
            const message = cells[4]?.textContent.trim() || '';
            const status = cells[5]?.querySelector('select')?.value || '';
            const date = cells[6]?.textContent.trim() || '';
            
            details.innerHTML = `
                <div class="inquiry-detail">
                    <div class="detail-row">
                        <div class="detail-field">
                            <label>Name</label>
                            <p>${name}</p>
                        </div>
                        <div class="detail-field">
                            <label>Email</label>
                            <p><a href="mailto:${email}">${email}</a></p>
                        </div>
                    </div>
                    
                    <div class="detail-row">
                        <div class="detail-field">
                            <label>Phone</label>
                            <p>${phone}</p>
                        </div>
                        <div class="detail-field">
                            <label>Property</label>
                            <p>${property}</p>
                        </div>
                    </div>
                    
                    <div class="detail-row">
                        <div class="detail-field">
                            <label>Status</label>
                            <p><span class="status-badge status-${status}">${status}</span></p>
                        </div>
                        <div class="detail-field">
                            <label>Received</label>
                            <p>${date}</p>
                        </div>
                    </div>
                    
                    <div class="detail-row full-width">
                        <div class="detail-field">
                            <label>Message</label>
                            <p style="white-space: pre-wrap; background: #f5f5f5; padding: 10px; border-radius: 4px;">${message}</p>
                        </div>
                    </div>
                    
                    <div class="modal-actions">
                        <a href="mailto:${email}?subject=Re: Property Inquiry" class="btn-primary">
                            <i class="fas fa-reply"></i> Reply
                        </a>
                        <button type="button" class="btn-secondary" onclick="closeInquiryModal()">
                            Close
                        </button>
                    </div>
                </div>
            `;
            modal.style.display = 'flex';
        }
        
        function closeInquiryModal() {
            document.getElementById('inquiryModal').style.display = 'none';
        }
    </script>
    <script src="../assets/js/admin-scripts.js"></script>
</body>
</html>
