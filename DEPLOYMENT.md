# 🚀 Deployment Rehberi

Bu PHP uygulamasını çeşitli platformlarda canlı görüntülemek için aşağıdaki seçenekleri kullanabilirsiniz:

## 🌐 1. Render.com (Ücretsiz & Kolay)

### Adımlar:
1. [Render.com](https://render.com) hesabı oluşturun
2. "New +" → "Web Service" seçin
3. GitHub repository'nizi bağlayın: `https://github.com/sporcu28/dilekcepro-groq-ap`
4. Aşağıdaki ayarları yapın:
   - **Name**: `dilekce-app`
   - **Environment**: `PHP`
   - **Build Command**: `composer install --no-dev --optimize-autoloader`
   - **Start Command**: `php -S 0.0.0.0:$PORT -t public`
5. Environment variables ekleyin:
   ```
   APP_ENV=production
   APP_DEBUG=false
   SECRET_KEY=your-random-key-here
   ```
6. Deploy butonuna basın

**Sonuç**: `https://your-app-name.onrender.com` adresinde canlı uygulama

## 🐳 2. Railway (Hızlı Deploy)

### Adımlar:
1. [Railway.app](https://railway.app) hesabı oluşturun
2. "Deploy from GitHub repo" seçin
3. Repository'nizi seçin
4. Otomatik deploy başlayacak
5. Environment variables'ı ayarlayın

## ☁️ 3. Heroku (Klasik Seçenek)

### Adımlar:
1. [Heroku](https://heroku.com) hesabı oluşturun
2. Heroku CLI yükleyin
3. Terminal'de:
   ```bash
   heroku create your-app-name
   heroku config:set APP_ENV=production
   heroku config:set APP_DEBUG=false
   git push heroku main
   ```

## 🐋 4. Docker ile Kendi Sunucunuzda

### Dockerfile ile:
```bash
# Uygulamayı build edin
docker build -t dilekce-app .

# Çalıştırın
docker run -p 80:80 dilekce-app
```

### Docker Compose ile:
```yaml
version: '3.8'
services:
  app:
    build: .
    ports:
      - "80:80"
    environment:
      - APP_ENV=production
      - APP_DEBUG=false
    volumes:
      - ./uploads:/var/www/html/uploads
```

## 🌍 5. Vercel (Serverless - Sınırlı PHP Desteği)

**Not**: Vercel PHP desteği sınırlıdır, önerilmez.

## 🔧 6. Shared Hosting (cPanel/Plesk)

### Adımlar:
1. Hosting sağlayıcınızdan PHP 8.0+ destekli hosting alın
2. Dosyaları public_html'e yükleyin
3. `.env` dosyasını ayarlayın
4. Composer'ı shared hosting'de çalıştırın

## ⚡ 7. VPS/Cloud Server

### Ubuntu/Debian Sunucuda:
```bash
# LAMP stack kurun
sudo apt update
sudo apt install apache2 mysql-server php8.1 php8.1-mysql composer

# Repository'yi klonlayın
git clone https://github.com/sporcu28/dilekcepro-groq-ap.git
cd dilekcepro-groq-ap

# Bağımlılıkları yükleyin
composer install

# Apache'yi yapılandırın
sudo cp docker/apache.conf /etc/apache2/sites-available/dilekce.conf
sudo a2ensite dilekce.conf
sudo systemctl reload apache2
```

## 🔍 Hızlı Test için Önerilen: Render.com

**En kolay ve ücretsiz seçenek Render.com'dur:**

1. GitHub repo linki: https://github.com/sporcu28/dilekcepro-groq-ap
2. Render.com'a gidin
3. "New Web Service" oluşturun
4. GitHub'dan repository'yi seçin
5. Ayarları yukarıdaki gibi yapın
6. Deploy edin

**5-10 dakika içinde canlı link alırsınız!**

## 🚨 Önemli Notlar

### Güvenlik:
- Üretim ortamında mutlaka güçlü `SECRET_KEY` kullanın
- `APP_DEBUG=false` olarak ayarlayın
- HTTPS kullanın
- Dosya upload limitlerini kontrol edin

### Performans:
- `composer install --no-dev --optimize-autoloader`
- PHP OPcache etkinleştirin
- Static dosyalar için CDN kullanın

### Veritabanı:
- SQLite yerine MySQL/PostgreSQL kullanın
- Backup stratejisi oluşturun
- Connection pooling kullanın

---

**En hızlı sonuç için Render.com'u deneyin! 🚀**