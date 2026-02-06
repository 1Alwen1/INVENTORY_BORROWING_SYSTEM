# Simple Laboratory Management System (LMS - PHP)

## Download

[Download ZIP File](https://github.com/1Alwen1/INVENTORY_BORROWING_SYSTEM/archive/refs/heads/ZIP-FILES.zip)

This ZIP file contains the entire source code and assets for the Inventory Borrowing System. You can download it to set up the system locally or for backup purposes.

## Project Description

The Simple Laboratory Management System (LMS) is a web-based inventory management application designed specifically for laboratory environments. This system allows efficient tracking and management of laboratory items, accessories, borrowing records, damages, and reservations. It supports multiple user roles including administrators, faculty members, and students, providing a comprehensive solution for laboratory resource management.

Version: 1.6

## Features

- **User Management**: Support for multiple user types (Admin, Faculty, Students)
- **Category Management**: Organize items into categories (e.g., Mouse, Projector)
- **Item Management**: Track laboratory items with details like batch, brand, model, serial ID, and availability
- **Accessory Management**: Manage laboratory accessories with category association
- **Borrowing System**: Record and track item borrowing with borrower details and return dates
- **Damage Tracking**: Log and monitor damaged items with repair status
- **Reservation System**: Allow users to reserve items for future use
- **Dashboard**: Administrative panel for system overview and management
- **Reporting**: Generate reports on inventory status, borrowing history, and damages
- **File Uploads**: Support for image uploads (logos, covers, category images, user avatars)

## Technologies Used

- **Backend**: PHP 8.2+
- **Database**: MySQL/MariaDB 10.4+
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework**: Bootstrap 4 (AdminLTE theme)
- **Libraries**:
  - jQuery
  - DataTables
  - Summernote (Rich Text Editor)
  - Chart.js
  - Font Awesome
  - Various Bootstrap plugins

## Installation

1. **Prerequisites**:
   - PHP 8.2 or higher
   - MySQL/MariaDB 10.4 or higher
   - Apache/Nginx web server
   - XAMPP/WAMP or similar local server environment

2. **Clone/Download**:
   - Place the project files in your web server's document root (e.g., `htdocs` for XAMPP)

3. **Configuration**:
   - Update `config.php` with your database connection details
   - Ensure proper file permissions for `uploads/` directory

## Database Setup

1. Create a new MySQL database (e.g., `lms_db`)
2. Import the `database/lms_db.sql` file to set up tables and initial data
3. Update database connection settings in `classes/DBConnection.php` if necessary

### Default Admin Credentials
- Username: admin
- Password: admin123 (hashed in database)

## Usage

### Accessing the System
- **Admin Panel**: Navigate to `admin/` directory
- **Faculty Portal**: Navigate to `faculty/` directory
- **Student Portal**: Navigate to `student/` directory

### Key Functions
- **Admin**: Full system management including user management, system settings, and reports
- **Faculty**: View and manage reservations, borrowing records
- **Students**: Make reservations, view borrowing history

## User Roles

### Administrator
- Manage system settings and information
- User management (add/edit faculty and students)
- Category and item management
- View all records and generate reports
- System maintenance

### Faculty
- View available items and accessories
- Manage reservations
- Track borrowing records
- Report damages

### Students
- Browse available items
- Make reservations
- View personal borrowing history

## File Structure

```
INVENTORY_1.6/
├── admin/                 # Admin panel files
├── faculty/               # Faculty portal
├── student/               # Student portal
├── assets/                # CSS, JS, images
├── classes/               # PHP classes (DBConnection, Master, etc.)
├── database/              # Database schema
├── inc/                   # Include files (headers, footers, navigation)
├── libs/                  # Additional libraries
├── plugins/               # Third-party plugins
├── uploads/               # User uploaded files
├── config.php             # Configuration file
├── index.php              # Main entry point
└── README.md              # This file
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support or questions, please contact the development team or create an issue in the repository.

## Changelog

### Version 1.6
- Added accessory management
- Improved reservation system
- Enhanced user interface
- Bug fixes and performance improvements

---

**Note**: This system is designed for educational and laboratory use. Ensure proper backup of data and regular maintenance for optimal performance.
