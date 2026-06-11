# Blog Dashboard

A production-ready blog management system built with Laravel, MySQL, Bootstrap 5, jQuery AJAX, and GSAP animations.

## Features

✨ **Frontend**
- Responsive design (Mobile-first)
- Hero section with animations
- Blog listing with filter/search
- Blog detail page with reading progress bar
- Related blogs section
- Social sharing buttons
- Infinite scrolling ticker section

⚙️ **Admin Panel**
- Secure authentication
- Dashboard with statistics
- Create, read, update, delete blogs
- Image upload with preview
- Rich text editor for content

🔧 **Technical Features**
- AJAX-based filtering (search, category, date)
- GSAP animations with ScrollTrigger
- Smooth page transitions
- Reading time calculator
- SEO-friendly HTML
- CSRF protection
- Responsive Bootstrap 5 design

## Tech Stack

- **Backend**: Laravel 10+
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, Bootstrap 5
- **JavaScript**: jQuery, AJAX, GSAP
- **Authentication**: Laravel Session
- **Image Upload**: Laravel Storage

## Installation

### Prerequisites
- PHP 8.1+
- MySQL 5.7+
- Composer
- Node.js (optional, for frontend build tools)

### Setup Steps

1. **Clone the repository**
```bash
cd blog-dashboard
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure database**
Edit `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_dashboard
DB_USERNAME=root
DB_PASSWORD=
```

5. **Run migrations and seeders**
```bash
php artisan migrate --seed
```

6. **Create storage symlink**
```bash
php artisan storage:link
```

7. **Start the development server**
```bash
php artisan serve
```

8. **Access the application**
- Frontend: http://localhost:8000
- Admin: http://localhost:8000/admin/login
- Demo Credentials:
  - Email: admin@example.com
  - Password: admin123

## Project Structure

```
blog-dashboard/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── BlogController.php
│   │   │   └── AuthController.php
│   │   └── Requests/
│   └── Models/
│       ├── User.php
│       ├── Blog.php
│       └── Category.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── admin/
│       ├── frontend/
│       └── layouts/
├── routes/
│   └── web.php
├── public/
│   ├── css/
│   ├── js/
│   └── images/
└── storage/
    └── app/public/
```

## Database Schema

### Users Table
```sql
- id (Primary Key)
- name
- email (Unique)
- password
- timestamps
```

### Categories Table
```sql
- id (Primary Key)
- name (Unique)
- timestamps
```

### Blogs Table
```sql
- id (Primary Key)
- title
- short_description
- content
- image
- category_id (Foreign Key)
- timestamps
```

## Routes

### Public Routes
- `GET /` - Home page
- `GET /blogs/{id}` - Blog detail page
- `POST /blogs/filter` - AJAX filter endpoint

### Admin Routes (Protected by auth middleware)
- `GET /admin/login` - Login page
- `POST /admin/login` - Handle login
- `POST /admin/logout` - Handle logout
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/blogs` - Blog list
- `GET /admin/blogs/create` - Create blog form
- `POST /admin/blogs` - Store new blog
- `GET /admin/blogs/{id}/edit` - Edit blog form
- `PUT /admin/blogs/{id}` - Update blog
- `DELETE /admin/blogs/{id}` - Delete blog

## Features in Detail

### AJAX Filtering
The homepage allows users to filter blogs in real-time:
- Search by title or description
- Filter by category
- Filter by date range
- Reset all filters

All filtering is done via AJAX without page reload.

### GSAP Animations
- Hero section entrance animations
- Section reveal on scroll
- Blog card stagger animations
- Hover effects with elevation
- Reading progress bar
- Smooth page transitions
- Infinite scrolling ticker

---

Note: Minor UI tweaks and featured-card enhancements were applied for a more premium hero experience.

### Image Upload
- Support for JPEG, PNG, GIF
- Max file size: 2MB
- Automatic preview in admin panel
- Stored in `storage/app/public/blogs/`

### Responsive Design
- Desktop: 3-column blog grid
- Tablet: 2-column blog grid
- Mobile: 1-column blog grid
- Navigation collapses to hamburger menu on mobile

## Performance Optimization

- Lazy loading for images
- Optimized CSS and JavaScript
- Database query optimization with relationships
- Caching strategies for repeated queries
- Minified assets

## Security Features

- CSRF token protection
- SQL injection prevention (Eloquent ORM)
- XSS protection
- Password hashing (bcrypt)
- Session authentication
- HTTPS ready

## Deployment

### On Render.com
1. Connect GitHub repository
2. Set environment variables in Render dashboard
3. Add build command: `composer install && php artisan migrate --force`
4. Add start command: `php artisan serve --host=0.0.0.0 --port=$PORT`

### On InfinityFree
1. Upload files via FTP
2. Create MySQL database
3. Configure `.env` with database details
4. Run migrations via SSH or custom commands
5. Set file permissions for storage folder

### On Traditional Hosting
1. Upload files to public_html
2. Create MySQL database
3. Import migrations
4. Run seeders if needed
5. Configure `.env` file
6. Ensure storage folder is writable

## Development Tips

### Adding New Blog Categories
Edit `database/seeders/DatabaseSeeder.php` and modify the `$categories` array.

### Customizing Styling
- Main CSS: `public/css/style.css`
- Bootstrap customization available in the same file
- Color scheme: Dark red (#8B0000), Light red (#C41E3A)

### Extending the Blog Model
Add new fields in:
1. Create a new migration
2. Update the Blog model fillable array
3. Update the create/edit views

## Troubleshooting

### Database Connection Error
- Verify MySQL is running
- Check DB credentials in `.env`
- Ensure database exists

### Storage Link Not Working
```bash
php artisan storage:link
```

### Permission Issues
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### Migrations Not Running
```bash
php artisan migrate:refresh --seed
```

## License

This project is open source and available under the MIT License.

## Support

For issues and questions:
1. Check the documentation
2. Review Laravel documentation
3. Check Bootstrap documentation
4. Consult GSAP documentation

## Credits

Built with:
- Laravel Framework
- Bootstrap 5
- jQuery
- GSAP
- CKEditor

## Changelog

### v1.0.0
- Initial release
- Full blog management system
- Admin panel
- AJAX filtering
- GSAP animations
- Responsive design
