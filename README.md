# Dilekçe Uygulaması - AI Destekli Dilekçe Yönetim Sistemi

Modern, yapay zeka destekli dilekçe yönetim sistemi. PHP tabanlı, responsive tasarımlı ve kullanıcı dostu bir web uygulaması.

## 🌟 Özellikler

### 🤖 AI Destekli Özellikler
- **Otomatik Dilekçe Oluşturma**: OpenAI GPT modeli ile profesyonel dilekçe oluşturma
- **Akıllı İçerik Önerileri**: Konuya göre otomatik kategori ve öncelik önerileri
- **Dilekçe İyileştirme**: Mevcut dilekçeleri AI ile düzenleme ve iyileştirme
- **Otomatik Yanıt Oluşturma**: Yöneticiler için AI destekli yanıt önerileri

### 👤 Kullanıcı Özellikleri
- **Kolay Kayıt ve Giriş**: Güvenli kullanıcı hesap yönetimi
- **Dilekçe Oluşturma**: Manuel veya AI destekli dilekçe oluşturma
- **Durum Takibi**: Gerçek zamanlı dilekçe durumu izleme
- **Referans Numarası**: Her dilekçe için benzersiz takip numarası
- **Kategori Sistemi**: Organize edilmiş dilekçe kategorileri
- **Öncelik Seviyeleri**: Düşük, Orta, Yüksek, Acil öncelik seçenekleri

### 🛡️ Yönetici Özellikleri
- **Admin Dashboard**: Kapsamlı yönetim paneli
- **Dilekçe Yönetimi**: Tüm dilekçeleri görüntüleme ve yönetme
- **Kullanıcı Yönetimi**: Kullanıcı hesaplarını yönetme
- **İstatistikler**: Detaylı raporlama ve analitik
- **AI Yanıt Sistemi**: Otomatik yanıt oluşturma desteği

### 🎨 Teknik Özellikler
- **Responsive Tasarım**: Tüm cihazlarda uyumlu
- **Modern UI/UX**: Bootstrap 5 ile şık arayüz
- **CSRF Koruması**: Güvenlik önlemleri
- **Session Yönetimi**: Güvenli oturum kontrolü
- **Database Güvenliği**: PDO ile güvenli veritabanı işlemleri
- **Error Handling**: Kapsamlı hata yönetimi

## 🚀 Kurulum

### Gereksinimler
- PHP 8.0 veya üzeri
- MySQL 5.7 veya üzeri
- Composer
- OpenAI API Key (AI özellikleri için)

### 1. Projeyi İndirin
```bash
git clone https://github.com/yourusername/dilekce-uygulamasi.git
cd dilekce-uygulamasi
```

### 2. Bağımlılıkları Yükleyin
```bash
composer install
```

### 3. Ortam Değişkenlerini Ayarlayın
```bash
cp .env.example .env
```

`.env` dosyasını düzenleyin:
```env
# Veritabanı ayarları
DB_HOST=localhost
DB_NAME=dilekce_db
DB_USER=your_username
DB_PASS=your_password

# OpenAI API Anahtarı
OPENAI_API_KEY=your_openai_api_key

# Uygulama ayarları
APP_NAME="Dilekçe Uygulaması"
APP_URL=http://localhost:8000
APP_DEBUG=true
```

### 4. Veritabanını Oluşturun
```bash
# MySQL'e bağlanın ve veritabanını oluşturun
mysql -u root -p < config/database.sql
```

### 5. Web Sunucusunu Başlatın
```bash
# PHP built-in server ile
composer start

# Veya manuel olarak
php -S localhost:8000 -t public
```

## 📁 Proje Yapısı

```
dilekce-uygulamasi/
├── config/
│   └── database.sql          # Veritabanı şeması
├── public/
│   └── index.php            # Ana giriş noktası
├── src/
│   ├── Database.php         # Veritabanı bağlantı sınıfı
│   ├── Models/              # Model sınıfları
│   │   ├── User.php
│   │   └── Petition.php
│   └── Services/            # Servis sınıfları
│       └── AIService.php    # OpenAI entegrasyonu
├── views/                   # View dosyaları
│   ├── layout.php          # Ana layout
│   ├── home.php            # Ana sayfa
│   ├── dashboard.php       # Dashboard
│   ├── auth/               # Kimlik doğrulama sayfaları
│   └── petitions/          # Dilekçe sayfaları
├── .env.example            # Ortam değişkenleri şablonu
├── composer.json           # PHP bağımlılıkları
└── README.md              # Bu dosya
```

## 🎯 Kullanım

### Kullanıcı İşlemleri

1. **Hesap Oluşturma**: `/register` sayfasından yeni hesap oluşturun
2. **Giriş Yapma**: `/login` sayfasından giriş yapın
3. **Dilekçe Oluşturma**: 
   - Manuel: `/petitions/create`
   - AI Destekli: `/petitions/ai-generate`
4. **Dilekçe Takibi**: Dashboard'dan dilekçelerinizi takip edin

### AI Dilekçe Oluşturma

1. Konunuzu net bir şekilde belirtin
2. Detayları ve gerekçelerinizi açıklayın
3. Uygun kategori ve öncelik seçin
4. AI'ın oluşturduğu dilekçeyi inceleyin
5. Gerekirse düzenleyin ve kaydedin

### Admin İşlemleri

1. Admin hesabıyla giriş yapın (varsayılan: admin/admin123)
2. `/admin` panelinden sistem yönetimi
3. Dilekçeleri inceleme ve yanıtlama
4. Kullanıcı ve kategori yönetimi

## 🔧 API Endpoints

### Kimlik Doğrulama
- `POST /api/auth/login` - Giriş yapma
- `POST /api/auth/register` - Kayıt olma

### Dilekçe İşlemleri
- `POST /api/petitions/create` - Dilekçe oluşturma
- `GET /api/petitions/search` - Dilekçe arama
- `PUT /api/petitions/{id}` - Dilekçe güncelleme

### AI İşlemleri
- `POST /api/ai/generate-petition` - AI ile dilekçe oluşturma
- `POST /api/ai/improve-petition` - Dilekçe iyileştirme
- `POST /api/ai/generate-response` - AI yanıt oluşturma

## 🔒 Güvenlik

- **CSRF Token**: Tüm POST istekleri için CSRF koruması
- **Password Hashing**: bcrypt ile şifre hashleme
- **SQL Injection**: PDO prepared statements
- **XSS Protection**: HTML çıktı filtreleme
- **Session Security**: Güvenli session yönetimi

## 🎨 Özelleştirme

### Tema Değişiklikleri
CSS değişkenleri `views/layout.php` dosyasında tanımlanmıştır:
```css
:root {
    --primary-color: #2c3e50;
    --secondary-color: #3498db;
    --success-color: #27ae60;
    /* ... */
}
```

### AI Model Ayarları
`src/Services/AIService.php` dosyasında AI parametrelerini ayarlayabilirsiniz:
- Model seçimi (gpt-3.5-turbo, gpt-4)
- Temperature ayarları
- Max tokens limiti

## 📊 Veritabanı Şeması

### Ana Tablolar
- `users` - Kullanıcı bilgileri
- `petitions` - Dilekçe verileri
- `petition_categories` - Kategori tanımları
- `petition_responses` - Dilekçe yanıtları
- `petition_attachments` - Dosya ekleri
- `activity_logs` - Sistem logları

## 🤝 Katkı Sağlama

1. Bu projeyi fork edin
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Değişikliklerinizi commit edin (`git commit -m 'Add amazing feature'`)
4. Branch'inizi push edin (`git push origin feature/amazing-feature`)
5. Pull Request oluşturun

## 📝 Lisans

Bu proje MIT lisansı altında lisanslanmıştır. Detaylar için `LICENSE` dosyasına bakın.

## 🆘 Destek

Sorunlar veya sorularınız için:
- Issue açın: [GitHub Issues](https://github.com/yourusername/dilekce-uygulamasi/issues)
- E-posta: support@dilekceapp.com

## 🔄 Sürüm Geçmişi

### v1.0.0 (İlk Sürüm)
- ✅ Temel dilekçe yönetimi
- ✅ AI destekli dilekçe oluşturma
- ✅ Kullanıcı ve admin panelleri
- ✅ Responsive tasarım
- ✅ Güvenlik önlemleri

### Planlanan Özellikler
- 📱 Mobil uygulama
- 📧 E-posta bildirimleri
- 📎 Dosya yükleme sistemi
- 🔄 Workflow yönetimi
- 📊 Gelişmiş raporlama

## 🙏 Teşekkürler

- [OpenAI](https://openai.com) - AI API desteği için
- [Bootstrap](https://getbootstrap.com) - UI framework için
- [Font Awesome](https://fontawesome.com) - İkonlar için
- Türk geliştiriciler topluluğu için destekleri

---

**Dilekçe Uygulaması** - Modern dilekçe yönetimi için yapay zeka destekli çözüm 🚀
