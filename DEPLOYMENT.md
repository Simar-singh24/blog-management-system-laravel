# Deployment Guide - Blog Dashboard

## 🚀 Deployment on Render.com

### Prerequisites
- GitHub account with the repository
- Render.com account

### Steps

1. **Connect Repository**
   - Go to Render.com dashboard
   - Click "New +" → "Web Service"
   - Connect your GitHub repository
   - Select the blog-dashboard repo

2. **Configure Service**
   - Name: `blog-dashboard`
   - Environment: `PHP 8.1+`
   - Region: Choose closest to your users
   - Plan: Free or Starter

3. **Build Command**
   ```bash
   composer install && php artisan migrate --force --seed
   ```

4. **Start Command**
   ```bash
   php artisan serve --host=0.0.0.0 --port=$PORT
   ```

5. **Environment Variables**
   Add in Render dashboard:
   ```
   APP_NAME=Blog Dashboard
   APP_ENV=production
   APP_KEY=base64:YOUR_APP_KEY_HERE
   APP_DEBUG=false
   APP_URL=https://your-app.render.com
   
   DB_CONNECTION=mysql
   DB_HOST=your-mysql-host
   DB_PORT=3306
   DB_DATABASE=blog_dashboard
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   
   FILESYSTEM_DISK=public
   ```

6. **Deploy**
   - Click "Deploy"
   - Wait for build to complete
   - Visit your app URL

---

## 🚀 Deployment on InfinityFree

### Prerequisites
- InfinityFree account
- FTP client (FileZilla recommended)
- MySQL database

### Steps

1. **Setup Database**
   - Login to InfinityFree control panel
   - Create MySQL database
   - Note: database name, username, password

2. **Upload Files via FTP**
   - Connect using FTP credentials
   - Upload all files to `public_html/`
   - Ensure storage folder has 755 permissions
   - Set bootstrap/cache to 755 permissions

3. **Configure .env**
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-domain.infinityfree.com
   
   DB_HOST=your_db_host
   DB_DATABASE=your_db_name
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_pass
   
   FILESYSTEM_DISK=public
   ```

4. **Run Migrations**
   - Use SSH (if available) or cPanel terminal
   - Execute: `php artisan migrate --force`
   - Seed data: `php artisan db:seed`

5. **Set Permissions**
   ```bash
   chmod -R 755 storage/
   chmod -R 755 bootstrap/cache/
   ```

---

## 🚀 Deployment on DigitalOcean / VPS

### Prerequisites
- VPS with PHP 8.1+, MySQL, Nginx
- SSH access
- Domain configured

### Steps

1. **SSH into Server**
   ```bash
   ssh root@your_server_ip
   ```

2. **Install Dependencies**
   ```bash
   apt-get update
   apt-get install php php-mysql php-mbstring php-xml php-curl php-gd php-zip
   apt-get install mysql-server nginx composer
   ```

3. **Clone Repository**
   ```bash
   cd /var/www
   git clone https://github.com/yourusername/blog-dashboard.git
   cd blog-dashboard
   ```

4. **Install Composer**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

5. **Setup Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

6. **Configure Database**
   ```bash
   mysql -u root -p
   CREATE DATABASE blog_dashboard;
   CREATE USER 'blog_user'@'localhost' IDENTIFIED BY 'strong_password';
   GRANT ALL PRIVILEGES ON blog_dashboard.* TO 'blog_user'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

   Update .env:
   ```
   DB_USERNAME=blog_user
   DB_PASSWORD=strong_password
   ```

7. **Run Migrations**
   ```bash
   php artisan migrate --force
   php artisan db:seed
   ```

8. **Set Permissions**
   ```bash
   chown -R www-data:www-data /var/www/blog-dashboard
   chmod -R 755 storage/
   chmod -R 755 bootstrap/cache/
   ```

9. **Configure Nginx**
   Create `/etc/nginx/sites-available/blog-dashboard`:
   ```nginx
   server {
       listen 80;
       server_name your-domain.com www.your-domain.com;
       root /var/www/blog-dashboard/public;

       index index.html index.htm index.php;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location ~ \.php$ {
           fastcgi_pass unix:/run/php/php8.1-fpm.sock;
           fastcgi_index index.php;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }

       error_page 404 /index.php;

       location ~ /\.ht {
           deny all;
       }
   }
   ```

   Enable site:
   ```bash
   ln -s /etc/nginx/sites-available/blog-dashboard /etc/nginx/sites-enabled/
   nginx -t
   systemctl restart nginx
   ```

10. **Setup SSL with Let's Encrypt**
    ```bash
    apt-get install certbot python3-certbot-nginx
    certbot --nginx -d your-domain.com -d www.your-domain.com
    ```

11. **Create Storage Link**
    ```bash
    php artisan storage:link
    ```

---

## 📊 Post-Deployment Checklist

- [ ] APP_DEBUG is set to false
- [ ] APP_KEY is generated and set
- [ ] Database is properly configured
- [ ] Storage link is created
- [ ] File permissions are correct (755 for storage)
- [ ] SSL certificate is installed (HTTPS)
- [ ] Backup strategy is in place
- [ ] Logs are monitored
- [ ] Admin panel is accessible
- [ ] Frontend pages load correctly

---

## 🔒 Security Recommendations

1. **Regular Backups**
   ```bash
   # Database backup
   mysqldump -u user -p database_name > backup.sql
   
   # Full backup
   tar -czf backup.tar.gz /var/www/blog-dashboard
   ```

2. **Update Dependencies**
   ```bash
   composer update
   php artisan vendor:publish
   ```

3. **Monitor Logs**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Configure Firewall**
   - Block unnecessary ports
   - Only allow 80 (HTTP) and 443 (HTTPS)

5. **Setup Email Notifications**
   - Configure MAIL_* variables in .env
   - Monitor errors and issues

---

## 🆘 Deployment Troubleshooting

### White Blank Page
- Check `storage/logs/laravel.log` for errors
- Ensure .env file is present
- Verify database connection
- Clear cache: `php artisan cache:clear`

### 500 Internal Server Error
- Check file permissions
- Verify PHP version compatibility
- Review error logs
- Test database connection

### Images Not Loading
- Verify storage link exists
- Check file permissions: `chmod -R 755 storage/`
- Ensure APP_URL matches domain

### Database Connection Failed
- Verify credentials in .env
- Check MySQL is running
- Ensure database exists
- Test connectivity from server

### Slow Performance
- Enable caching: `php artisan cache:clear`
- Optimize database indexes
- Use CDN for static assets
- Enable gzip compression

---

## 📞 Support

For deployment issues:
1. Check Laravel documentation
2. Review server logs
3. Verify all prerequisites
4. Check database permissions
5. Ensure file permissions are correct

## Success! 🎉

Your Blog Dashboard is now live and ready for production!
