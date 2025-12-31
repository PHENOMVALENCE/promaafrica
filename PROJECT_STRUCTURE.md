# Proma Africa - Final Project Structure

## Directory Organization

```
promaafrica/
├── assets/                          # Static assets
│   ├── css/                         # Stylesheets
│   │   ├── admin-styles.css
│   │   ├── article_styles.css
│   │   ├── news_style.css
│   │   ├── properties.css
│   │   ├── sales-styles.css
│   │   ├── styles.css
│   │   ├── stylesss.css
│   │   └── text-justify-updates.css
│   ├── js/                          # JavaScript files
│   │   ├── admin-scripts.js
│   │   └── sales-scripts.js
│   └── images/                      # Image assets
│       ├── favicon.ico
│       ├── 1.png, 2.png
│       └── [other images]
│
├── admin/                           # Admin panel
│   ├── includes/                    # Admin includes
│   │   ├── header.php
│   │   └── sidebar.php
│   ├── add-property.php
│   ├── analytics.php
│   ├── auth.php                     # Authentication class
│   ├── dashboard.php
│   ├── delete-image.php
│   ├── edit-property.php
│   ├── index.php
│   ├── inquiries.php
│   ├── login.php
│   ├── logout.php
│   ├── profile.php
│   ├── properties.php
│   ├── settings.php
│   ├── submit-inquiry.php
│   └── view-property.php
│
├── config/                          # Configuration files
│   └── database.php                 # Database connection class (singleton)
│
├── database/                        # Database schema
│   └── schema.sql
│
├── handlers/                        # Form handlers (optional, for future use)
│
├── includes/                        # Reusable PHP components
│   ├── footer.php
│   └── navbar.php
│
├── news/                           # News articles
│   └── article_1.php
│
├── uploads/                        # User-uploaded files
│   └── properties/                 # Property images
│
├── about.php                       # About page
├── article.php                     # Article page
├── assetmanagement.php             # Asset management service page
├── contact.php                     # Contact page
├── index.php                       # Homepage
├── landadministration.php          # Land administration service page
├── landsurveying.php               # Land surveying service page
├── news.php                        # News listing page
├── process.php                     # Article management handler
├── process_contact.php             # Contact form handler
├── propertyfinancing.php           # Property financing service page
├── propertylisting.php             # Property listing service page
├── propertymanagement.php          # Property management service page
├── resettlement.php                # Resettlement service page
├── sales.php                       # Property sales page
├── services.php                    # Services overview page
├── subscribe.php                   # Newsletter subscription handler
└── sitemap.xml                     # XML sitemap
```

## File Path Conventions

### From Root PHP Files
- **CSS**: `assets/css/filename.css`
- **JS**: `assets/js/filename.js`
- **Images**: `assets/images/filename.ext`
- **Config**: `config/database.php`
- **Includes**: `includes/filename.php`
- **Other Pages**: `pagename.php`

### From Admin PHP Files
- **CSS**: `../assets/css/filename.css`
- **JS**: `../assets/js/filename.js`
- **Images**: `../assets/images/filename.ext`
- **Config**: `../config/database.php`
- **Admin Includes**: `includes/filename.php`
- **Root Includes**: `../includes/filename.php`
- **Other Admin Pages**: `pagename.php`

### From News Subdirectory
- **CSS**: `../assets/css/filename.css`
- **Config**: `../config/database.php`
- **Root Pages**: `../pagename.php`

## Database Connection

All files should use the centralized Database class:

```php
// From root files
require_once 'config/database.php';

// From admin files
require_once '../config/database.php';

// Usage
$db = Database::getInstance();
$pdo = $db->getConnection();

// Or use helper function
$pdo = getConnection();
```

## Form Handlers

Form handlers remain in root directory for direct access:

- `subscribe.php` - Newsletter subscription (POST from forms)
- `process_contact.php` - Contact form processing (POST from contact.php)
- `process.php` - Article management (AJAX requests)

## Admin Authentication

Admin files use the Auth class:

```php
require_once 'auth.php';
$auth = new Auth();
if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit;
}
```

## Image Uploads

- **Property Images**: `uploads/properties/`
- **Article Images**: `uploads/articles/` (created dynamically)

## Link Verification

All internal links have been verified:
- ✅ All CSS files correctly linked
- ✅ All JavaScript files correctly linked
- ✅ All image paths corrected
- ✅ All PHP includes working
- ✅ All form actions pointing to correct handlers
- ✅ All navigation links functional

## Best Practices

1. **Always use relative paths** - Never use absolute paths
2. **Use the Database class** - Don't create new connections
3. **Keep handlers in root** - For direct form access
4. **Organize by type** - CSS, JS, images in assets/
5. **Use includes** - For reusable components
6. **Admin isolation** - Admin files in admin/ directory

## Notes

- The `handlers/` directory is created for future organization if needed
- All file paths have been verified and corrected
- The structure follows PHP best practices
- All service pages have consistent structure and navigation

