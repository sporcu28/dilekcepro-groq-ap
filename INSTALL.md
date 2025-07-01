# Kurulum Rehberi - Dilekçe Uygulaması

Bu rehber, Dilekçe Uygulamasını sisteminizde kurmanız için gereken adımları açıklar.

## 📋 Sistem Gereksinimleri

### Minimum Gereksinimler
- **PHP**: 8.0 veya üzeri
- **MySQL**: 5.7 veya üzeri (MariaDB 10.2+ desteklenir)
- **Web Server**: Apache 2.4+ veya Nginx 1.18+
- **Composer**: PHP paket yöneticisi
- **OpenSSL**: SSL/TLS desteği için

### Önerilen Gereksinimler
- **PHP**: 8.1 veya üzeri
- **MySQL**: 8.0 veya üzeri
- **Memory**: Minimum 512MB RAM
- **Disk**: 100MB boş alan

### PHP Modülleri
Aşağıdaki PHP modüllerinin yüklü olması gerekir:
```bash
# Gerekli modüller
php-pdo
php-pdo-mysql
php-curl
php-json
php-mbstring
php-openssl
php-zip

# İsteğe bağlı (performans için)
php-opcache
php-redis (cache için)
```

## 🚀 Hızlı Kurulum

### 1. Dosyaları İndirin
```bash
# Git ile
git clone https://github.com/yourusername/dilekce-uygulamasi.git
cd dilekce-uygulamasi

# Veya ZIP dosyasını indirip açın
wget https://github.com/yourusername/dilekce-uygulamasi/archive/main.zip
unzip main.zip
cd dilekce-uygulamasi-main
```

### 2. Bağımlılıkları Yükleyin
```bash
# Composer ile PHP bağımlılıklarını yükleyin
composer install --optimize-autoloader --no-dev
```

### 3. Ortam Dosyasını Hazırlayın
```bash
# Örnek dosyayı kopyalayın
cp .env.example .env

# Dosyayı düzenleyin
nano .env
```

### 4. Veritabanını Oluşturun
```bash
# MySQL'e bağlanın
mysql -u root -p

# Veya direkt olarak SQL dosyasını çalıştırın
mysql -u root -p < config/database.sql
```

### 5. Uygulamayı Başlatın
```bash
# Geliştirme ortamı için
composer start

# Veya manuel olarak
php -S localhost:8000 -t public
```

## ⚙️ Detaylı Yapılandırma

### Ortam Değişkenleri (.env)

```env
# Veritabanı Ayarları
DB_HOST=localhost
DB_NAME=dilekce_db
DB_USER=your_db_username
DB_PASS=your_db_password

# OpenAI API (AI özellikleri için)
OPENAI_API_KEY=your_openai_api_key_here

# Uygulama Ayarları
APP_NAME="Dilekçe Uygulaması"
APP_URL=http://localhost:8000
APP_DEBUG=true
APP_ENV=development

# E-posta Ayarları (isteğe bağlı)
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_FROM=noreply@dilekceapp.com

# Güvenlik
SESSION_LIFETIME=7200
CSRF_TOKEN_LIFETIME=3600
```

### Veritabanı Yapılandırması

#### MySQL/MariaDB Kurulumu (Ubuntu/Debian)
```bash
# MySQL kurulumu
sudo apt update
sudo apt install mysql-server

# Güvenlik yapılandırması
sudo mysql_secure_installation

# Veritabanı ve kullanıcı oluşturma
sudo mysql -u root -p
```

MySQL komutları:
```sql
-- Veritabanı oluştur
CREATE DATABASE dilekce_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Kullanıcı oluştur ve yetki ver
CREATE USER 'dilekce_user'@'localhost' IDENTIFIED BY 'güçlü_şifre_buraya';
GRANT ALL PRIVILEGES ON dilekce_db.* TO 'dilekce_user'@'localhost';
FLUSH PRIVILEGES;

-- Tabloları oluştur
USE dilekce_db;
SOURCE config/database.sql;
```

### Web Server Yapılandırması

#### Apache Yapılandırması
`/etc/apache2/sites-available/dilekce.conf`:
```apache
<VirtualHost *:80>
    DocumentRoot /var/www/dilekce/public
    ServerName dilekce.local
    
    <Directory /var/www/dilekce/public>
        AllowOverride All
        Require all granted
        
        # URL Rewriting
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php/$1 [QSA,L]
    </Directory>
    
    # Güvenlik başlıkları
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-XSS-Protection "1; mode=block"
    
    ErrorLog ${APACHE_LOG_DIR}/dilekce_error.log
    CustomLog ${APACHE_LOG_DIR}/dilekce_access.log combined
</VirtualHost>
```

Site'ı etkinleştir:
```bash
sudo a2ensite dilekce
sudo a2enmod rewrite headers
sudo systemctl reload apache2
```

#### Nginx Yapılandırması
`/etc/nginx/sites-available/dilekce`:
```nginx
server {
    listen 80;
    server_name dilekce.local;
    root /var/www/dilekce/public;
    index index.php;
    
    # Güvenlik başlıkları
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";
    
    # PHP dosyalarını işle
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    # URL Rewriting
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    # Statik dosyalar
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
    
    # Güvenlik - hassas dosyaları gizle
    location ~ /\. {
        deny all;
    }
    
    location ~ /(config|src|vendor|\.env) {
        deny all;
    }
}
```

Site'ı etkinleştir:
```bash
sudo ln -s /etc/nginx/sites-available/dilekce /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

## 🔐 Güvenlik Yapılandırması

### Dosya İzinleri
```bash
# Uygulama dosyaları için uygun izinler
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;

# Hassas dosyaları koru
chmod 600 .env
chmod -R 750 config/
```

### SSL/HTTPS Kurulumu (Let's Encrypt)
```bash
# Certbot kurulumu
sudo apt install certbot python3-certbot-apache

# SSL sertifikası al
sudo certbot --apache -d yourdomain.com

# Otomatik yenileme
sudo crontab -e
# Ekle: 0 12 * * * /usr/bin/certbot renew --quiet
```

## 🧪 Test ve Doğrulama

### Sistem Testleri
```bash
# PHP sürümü kontrolü
php -v

# Gerekli modüller kontrolü
php -m | grep -E "(pdo|curl|json|mbstring)"

# Veritabanı bağlantısı testi
php -r "
try {
    \$pdo = new PDO('mysql:host=localhost;dbname=dilekce_db', 'username', 'password');
    echo 'Database connection: OK\n';
} catch(PDOException \$e) {
    echo 'Database connection: FAILED - ' . \$e->getMessage() . '\n';
}
"
```

### Uygulama Testleri
1. Tarayıcıda `http://localhost:8000` adresini açın
2. Ana sayfa yükleniyorsa başarılı
3. Kayıt ol linkine tıklayın ve yeni hesap oluşturun
4. Giriş yapın ve dashboard'ı kontrol edin

## 🔧 Sorun Giderme

### Yaygın Sorunlar

#### 1. Veritabanı Bağlantı Hatası
```
SQLSTATE[HY000] [1045] Access denied for user
```
**Çözüm**: `.env` dosyasındaki veritabanı bilgilerini kontrol edin.

#### 2. Composer Bağımlılık Hatası
```
Class 'Dotenv\Dotenv' not found
```
**Çözüm**: 
```bash
composer install
composer dump-autoload
```

#### 3. PHP Modül Eksik
```
Call to undefined function curl_init()
```
**Çözüm**:
```bash
sudo apt install php-curl
sudo systemctl restart apache2
```

#### 4. İzin Hatası
```
Permission denied
```
**Çözüm**:
```bash
sudo chown -R www-data:www-data /var/www/dilekce
sudo chmod -R 755 /var/www/dilekce
```

### Log Dosyaları
- Apache: `/var/log/apache2/error.log`
- Nginx: `/var/log/nginx/error.log`
- PHP: `/var/log/php/error.log`
- MySQL: `/var/log/mysql/error.log`

### Debug Modu
Geliştirme ortamında `.env` dosyasında:
```env
APP_DEBUG=true
```

Üretim ortamında:
```env
APP_DEBUG=false
```

## 📦 Üretim Ortamı

### Performans Optimizasyonu
```bash
# Composer optimizasyonu
composer install --no-dev --optimize-autoloader

# PHP OPcache etkinleştir
echo "opcache.enable=1" >> /etc/php/8.1/apache2/php.ini
echo "opcache.memory_consumption=128" >> /etc/php/8.1/apache2/php.ini
```

### Backup Stratejisi
```bash
# Veritabanı backup
mysqldump -u username -p dilekce_db > backup_$(date +%Y%m%d).sql

# Dosya backup
tar -czf dilekce_backup_$(date +%Y%m%d).tar.gz /var/www/dilekce
```

### Güncelleme
```bash
# Backup al
cp -r /var/www/dilekce /var/www/dilekce_backup

# Yeni sürümü indır
git pull origin main

# Bağımlılıkları güncelle
composer install --no-dev --optimize-autoloader

# Veritabanını güncelle (eğer gerekiyorsa)
mysql -u username -p dilekce_db < config/migrations/update.sql
```

## 🆘 Destek

Kurulum sırasında sorun yaşarsanız:

1. **Dokümantasyon**: README.md dosyasını inceleyin
2. **GitHub Issues**: https://github.com/yourusername/dilekce-uygulamasi/issues
3. **E-posta**: support@dilekceapp.com

## ✅ Kurulum Kontrol Listesi

- [ ] PHP 8.0+ kurulu
- [ ] MySQL 5.7+ kurulu ve yapılandırılmış
- [ ] Composer yüklü
- [ ] Proje dosyaları indirildi
- [ ] `composer install` çalıştırıldı
- [ ] `.env` dosyası oluşturuldu ve yapılandırıldı
- [ ] Veritabanı oluşturuldu
- [ ] SQL tabloları oluşturuldu
- [ ] Web server yapılandırıldı
- [ ] Dosya izinleri ayarlandı
- [ ] Uygulama çalışıyor ve erişilebilir
- [ ] Test kullanıcısı oluşturuldu
- [ ] AI özelliği test edildi (OpenAI API Key varsa)

---

🎉 **Tebrikler!** Dilekçe Uygulaması başarıyla kuruldu. Artık modern, AI destekli dilekçe yönetiminin keyfini çıkarabilirsiniz!