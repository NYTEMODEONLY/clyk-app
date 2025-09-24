# Clyk Biolinks App

A powerful biolinks application built with PHP, designed to help users create beautiful, customizable link-in-bio pages. This is a rebuilt and enhanced version of the original Biolinks platform.

## 🚀 Features

- **Multiple Biolink Blocks**: Support for various content types including links, social media, images, and more
- **Custom Themes**: Multiple themes and customization options
- **QR Code Generation**: Built-in QR code creation and management
- **Analytics Dashboard**: Track clicks and engagement
- **Plugin System**: Extensible with various plugins
- **Multi-language Support**: Support for multiple languages
- **Responsive Design**: Mobile-friendly interface

## 🛠️ Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.6 or higher
- Apache/Nginx web server
- Composer (for dependency management)

### Setup Steps

1. **Upload Files**
   - Upload all files to your web server
   - Make sure the `uploads/` directory is writable

2. **Database Setup**
   - Create a new MySQL database
   - Import the `install/dump.sql` file

3. **Configuration**
   - Copy `config.php` and update database credentials
   - Set proper file permissions (755 for directories, 644 for files)

4. **Installation**
   - Visit `/install/` in your browser
   - Follow the installation wizard

## 📁 Project Structure

```
/
├── app/                    # Application core
│   ├── controllers/        # Controller classes
│   ├── core/              # Core application classes
│   ├── helpers/           # Helper functions
│   ├── init.php           # Application bootstrap
│   ├── languages/         # Language files
│   └── models/            # Data models
├── config.php             # Configuration file
├── index.php              # Main entry point
├── install/               # Installation files
├── plugins/               # Plugin directory
├── themes/                # Theme files
├── update/                # Update system
├── uploads/               # User uploads
├── vendor/                # Composer dependencies
└── .htaccess             # Apache configuration
```

## 🔧 Configuration

Edit `config.php` to configure:
- Database connection
- Application settings
- API keys
- File paths

## 🌐 Deployment

### cPanel Deployment
This application is designed to work with cPanel's Git Version Control feature:

1. Create a repository in cPanel Git Version Control
2. Add the clone URL as a remote: `git remote add cpanel YOUR_CPANEL_URL`
3. Push to cPanel: `git push -u cpanel main`
4. Configure deployment settings in cPanel to deploy to your web directory

## 📚 Documentation

Documentation is being developed as part of the rebuild process. Check back soon for comprehensive guides.

## 📄 License

This project is open source. License details to be determined as part of the rebuild process.

## 🤝 Contributing

We welcome contributions! This is an active rebuild project. Please:

- Fork the repository
- Create a feature branch
- Make your changes
- Submit a pull request

For major changes, please open an issue first to discuss what you would like to change.

---

**Clyk Biolinks** - Rebuilt for the modern web
