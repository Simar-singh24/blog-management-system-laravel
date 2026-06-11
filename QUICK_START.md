# Quick Start Guide - Blog Dashboard

## 🚀 Getting Started (5 Minutes)

### Step 1: Install Dependencies
```bash
composer install
```

### Step 2: Setup Environment
```bash
# Generate app key
php artisan key:generate

# The .env file is already configured with defaults
# If you need to change MySQL credentials, edit .env
```

### Step 3: Setup Database
```bash
# Create blog_dashboard database (MySQL)
mysql -u root -e "CREATE DATABASE blog_dashboard;"

# Run migrations
php artisan migrate

# Seed sample data
php artisan seed --class=DatabaseSeeder
```

### Step 4: Create Storage Link
```bash
php artisan storage:link
```

### Step 5: Run Server
```bash
php artisan serve
```

Visit: http://localhost:8000

## 📝 Demo Credentials

**Admin Login:**
- Email: admin@example.com
- Password: admin123

## 📂 Key Directories

```
app/Http/Controllers/     # Application logic
resources/views/          # Blade templates
database/migrations/      # Database schema
public/css/              # Stylesheets
public/js/               # JavaScript files
storage/app/public/      # User uploaded files
```

## 🎨 Customization

### Change Brand Color
Edit `public/css/style.css`:
```css
:root {
    --primary-color: #8B0000;  /* Change this */
    --primary-dark: #C41E3A;   /* And this */
}
```

### Add New Blog Category
1. Go to Admin Panel
2. Add category via database seeder in `database/seeders/DatabaseSeeder.php`
3. Re-seed: `php artisan migrate:refresh --seed`

### Customize Logo
Replace in `resources/views/layouts/app.blade.php`:
```blade
<a class="navbar-brand fw-bold" href="/">
    <i class="fas fa-feather"></i> Blog Dashboard
</a>
```

## 🔧 Common Commands

```bash
# Create new migration
php artisan make:migration create_table_name

# Create new model
php artisan make:model ModelName

# Create new controller
php artisan make:controller ControllerName

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Refresh database
php artisan migrate:refresh --seed

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Storage link
php artisan storage:link
```

## 🌐 Deployment Checklist

- [ ] Set `APP_DEBUG=false` in .env
- [ ] Set proper `APP_URL` in .env
- [ ] Generate new `APP_KEY`
- [ ] Configure database credentials
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Set proper file permissions: `chmod -R 775 storage bootstrap/cache`
- [ ] Create storage symlink: `php artisan storage:link`
- [ ] Setup HTTPS
- [ ] Configure email for notifications (if needed)

## 📱 Responsive Breakpoints

- Mobile: < 576px
- Tablet: 576px - 992px
- Desktop: > 992px

## 🐛 Troubleshooting

### Blank Page After Setup
- Check if .env file is properly configured
- Run: `php artisan config:clear`
- Check Laravel logs in `storage/logs/`

### Storage Link Not Working
```bash
# Remove the symlink and recreate
rm public/storage
php artisan storage:link
```

### Images Not Showing in Admin
- Ensure `storage/app/public/blogs/` directory exists
- Check file permissions: `chmod -R 755 storage/`

### Database Connection Error
- Verify MySQL is running
- Check credentials in .env
- Create database: `mysql -u root -e "CREATE DATABASE blog_dashboard;"`

## 📚 Documentation Links

- [Laravel Documentation](https://laravel.com/docs)
- [Bootstrap Documentation](https://getbootstrap.com/docs)
- [GSAP Documentation](https://greensock.com/gsap/)
- [CKEditor Documentation](https://ckeditor.com/docs/)

## 🎉 You're Ready!

Your blog management system is now ready to use. Start creating amazing content!

Need help? Check the README.md for detailed information.
