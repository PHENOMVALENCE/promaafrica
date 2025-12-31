# Proma Africa - Project Structure

This document describes the organized structure of the Proma Africa website project. For detailed path conventions and best practices, see `PROJECT_STRUCTURE.md`.

## Directory Structure

```
promaafrica/
├── assets/                    # Static assets (CSS, JS, images)
│   ├── css/                   # Stylesheets
│   │   ├── admin-styles.css
│   │   ├── article_styles.css
│   │   ├── news_style.css
│   │   ├── properties.css
│   │   ├── sales-styles.css
│   │   ├── styles.css
│   │   ├── stylesss.css
│   │   └── text-justify-updates.css
│   ├── js/                    # JavaScript files
│   │   ├── admin-scripts.js
│   │   └── sales-scripts.js
│   └── images/                # Image assets
│       ├── favicon.ico
│       ├── 1.png, 2.png
│       └── [other images]
│
├── admin/                     # Admin panel
│   ├── includes/              # Admin includes
│   │   ├── header.php
│   │   └── sidebar.php
│   ├── add-property.php
│   ├── analytics.php
│   ├── auth.php
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
├── config/                    # Configuration files
│   └── database.php           # Database connection class
│
├── database/                  # Database schema
│   └── schema.sql
│
├── includes/                  # Reusable PHP components
│   ├── footer.php
│   └── navbar.php
│
├── news/                      # News articles
│   └── article_1.php
│
├── uploads/                   # User-uploaded files
│   └── properties/            # Property images
│
├── about.php                  # About page
├── article.php                # Article page
├── assetmanagement.php        # Asset management page
├── contact.php                # Contact page
├── index.php                  # Homepage
├── landadministration.php     # Land administration page
├── landsurveying.php          # Land surveying page
├── news.php                   # News listing page
├── process.php                # Process handler
├── process_contact.php        # Contact form processor
├── propertyfinancing.php      # Property financing page
├── propertylisting.php        # Property listing page
├── propertymanagement.php     # Property management page
├── resettlement.php           # Resettlement page
├── sales.php                  # Property sales page
├── services.php               # Services page
├── subscribe.php              # Newsletter subscription
└── sitemap.xml                # XML sitemap
```

## File Organization Principles

### Assets
- **CSS files**: All stylesheets are in `assets/css/`
- **JavaScript files**: All scripts are in `assets/js/`
- **Images**: All static images are in `assets/images/`

### Includes
- Reusable components like `navbar.php` and `footer.php` are in `includes/`
- Admin-specific includes are in `admin/includes/`

### Configuration
- Database configuration is centralized in `config/database.php`
- All files should use `require_once 'config/database.php'` or `require_once '../config/database.php'` from admin

### Path References

#### From Root PHP Files
- CSS: `assets/css/filename.css`
- JS: `assets/js/filename.js`
- Images: `assets/images/filename.ext`
- Includes: `includes/filename.php`
- Config: `config/database.php`

#### From Admin PHP Files
- CSS: `../assets/css/filename.css`
- JS: `../assets/js/filename.js`
- Images: `../assets/images/filename.ext`
- Includes: `includes/filename.php` (admin includes) or `../includes/filename.php` (root includes)
- Config: `../config/database.php`

#### From News Subdirectory
- CSS: `../assets/css/filename.css`
- Config: `../config/database.php`

## Database Configuration

The project uses a singleton Database class located in `config/database.php`. All database connections should use:

```php
require_once 'config/database.php'; // From root
// or
require_once '../config/database.php'; // From admin or subdirectories

$db = Database::getInstance()->getConnection();
```

## Removed Files

The following files were removed during reorganization as they were unused or duplicates:
- `connect.php` - Old database connection file (replaced by `config/database.php`)
- `database.php` (root) - Duplicate (using `config/database.php` instead)
- `admin_dashboard.php` - Unused duplicate file
- `sitemap (1).xml` - Duplicate sitemap file

## Notes

- All file paths have been updated to reflect the new structure
- The `uploads/` directory contains user-uploaded content and should not be modified manually
- The `database/` directory contains SQL schema files
- Admin panel files are isolated in the `admin/` directory

