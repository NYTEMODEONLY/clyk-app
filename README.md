# Clyk Biolinks App

A powerful biolinks application built with PHP, designed to help users create beautiful, customizable link-in-bio pages.

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

- [Installation Guide](https://altumco.de/66biolinks-docs)
- [API Documentation](https://altumco.de/66biolinks-docs/api)
- [Plugin Development](https://altumco.de/66biolinks-docs/plugins)

## 🆘 Support

- Website: https://altumco.de/66biolinks
- Documentation: https://altumco.de/66biolinks-docs
- Changelog: https://altumco.de/66biolinks-changelog

## 📄 License

This project is proprietary software. See the included license files for details.

## 🤝 Contributing

This is a proprietary application. For contributions or custom development, please contact the developers.

---

**Built by AltumCode** | **Version: 66 Biolinks**
