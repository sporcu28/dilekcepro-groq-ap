# 📄 AI Destekli Profesyonel Dilekçe Uygulaması

## 🚀 Canlı Demo
Uygulama şu anda çalışıyor: `http://localhost:8000`

## ✨ Özellikler

### 🤖 AI Destekli Özellikler
- **Otomatik Dilekçe Oluşturma**: Konuyu belirtin, AI size profesyonel dilekçe hazırlasın
- **Akıllı Cevap Sistemi**: Yüklenen dilekçelere otomatik profesyonel yanıtlar
- **Ton Seçenekleri**: Resmi, saygılı, acil, samimi tonlarda dilekçe oluşturma
- **İçerik İyileştirme**: AI destekli metin düzeltme ve iyileştirme önerileri

### 📁 Dosya Yönetimi
- **Drag & Drop Yükleme**: Sürükle-bırak ile kolay dosya yükleme
- **Çoklu Format Desteği**: PDF, Word (.doc, .docx), Resim (.jpg, .png) desteği
- **Dosya Boyutu Kontrolü**: Maksimum 10MB dosya desteği
- **Güvenli Yükleme**: Dosya türü ve boyut doğrulaması

### 📥 İndirme Seçenekleri
- **PDF İndirme**: Profesyonel PDF formatında belge indirme
- **Word İndirme**: Düzenlenebilir RTF formatında indirme
- **ZIP Arşivi**: Her iki formatı birden içeren arşiv
- **E-posta Gönderimi**: Belgeleri e-posta adresinize gönderme

### 🔒 Güvenlik
- **CSRF Koruması**: Cross-Site Request Forgery saldırılarına karşı koruma
- **Şifre Şifreleme**: BCrypt ile güvenli şifre depolama
- **Session Güvenliği**: Güvenli oturum yönetimi
- **XSS Koruması**: Cross-Site Scripting saldırılarına karşı koruma
- **SQL Injection Koruması**: PDO prepared statements kullanımı

### � Kullanıcı Deneyimi
- **Responsive Tasarım**: Mobil, tablet ve desktop uyumlu
- **Modern Arayüz**: Bootstrap 5 ve Font Awesome ile modern tasarım
- **Animasyonlar**: Kullanıcı etkileşimini artıran smooth animasyonlar
- **Gerçek Zamanlı Takip**: Dilekçe durumu canlı takibi
- **Toast Bildirimleri**: Kullanıcı dostu bildirim sistemi

## 🛠 Teknolojiler

### Backend
- **PHP 8.4+**: Modern PHP özellikleri
- **MySQL**: Veritabanı yönetimi
- **Composer**: Bağımlılık yönetimi
- **PSR-4 Autoloading**: Modern PHP standartları

### Frontend  
- **Bootstrap 5**: Responsive CSS framework
- **Font Awesome 6**: İkon kütüphanesi
- **JavaScript ES6+**: Modern JavaScript özellikleri
- **CSS Grid & Flexbox**: Modern layout teknikleri

### Kütüphaneler
- **Dotenv**: Environment değişken yönetimi
- **Twig**: Template engine (opsiyonel)
- **Guzzle**: HTTP client için hazır

## � Kurulum

### Gereksinimler
- PHP 8.0 veya üzeri
- MySQL 5.7 veya üzeri  
- Composer
- Web sunucusu (Apache/Nginx) veya PHP built-in server

### Adım Adım Kurulum

1. **Projeyi klonlayın**
```bash
git clone https://github.com/sporcu28/dilekcepro-groq-ap.git
cd dilekcepro-groq-ap
```

2. **Bağımlılıkları yükleyin**
```bash
composer install
```

3. **Environment dosyasını oluşturun**
```bash
cp .env.example .env
```

4. **Ortam değişkenlerini düzenleyin**
```env
# Database Configuration
DB_HOST=localhost
DB_NAME=petition_app
DB_USER=root
DB_PASS=your_password

# OpenAI API (Opsiyonel)
OPENAI_API_KEY=your_openai_api_key
```

5. **Veritabanını oluşturun**
```bash
mysql -u root -p < config/database.sql
```

6. **Upload klasörlerini oluşturun**
```bash
mkdir -p uploads/petitions public/downloads
chmod 755 uploads public/downloads
```

7. **Sunucuyu başlatın**
```bash
cd public
php -S localhost:8000
```

8. **Tarayıcıda açın**
```
http://localhost:8000
```

## 🎯 Kullanım

### Dilekçe Oluşturma (AI Destekli)
1. Ana sayfada "Hemen Dilekçe Oluştur" butonuna tıklayın
2. Konunuzu ve tonunu seçin
3. "Dilekçe Oluştur" butonuna tıklayın
4. AI tarafından oluşturulan dilekçeyi gözden geçirin
5. PDF veya Word formatında indirin

### Dosya Yükleme ve Cevap Alma
1. "Dilekçe Yükle & Cevap Al" seçeneğini kullanın
2. Dosyanızı sürükle-bırak ile yükleyin
3. Kategori ve öncelik seçin
4. Ek açıklama ekleyin (opsiyonel)
5. "Yükle & Cevap İste" butonuna tıklayın
6. AI tarafından hazırlanan cevabı görüntüleyin
7. Cevabı çeşitli formatlarda indirin

### Yönetici Paneli
- `/admin` adresinden yönetici paneline erişim
- Dilekçe yönetimi ve istatistikler
- Kullanıcı yönetimi
- Sistem raporları

## 📊 Veritabanı Yapısı

### Ana Tablolar
- `users`: Kullanıcı bilgileri
- `petitions`: Dilekçe verisi
- `petition_categories`: Dilekçe kategorileri
- `petition_responses`: Yanıt sistemi
- `petition_attachments`: Dosya ekleri
- `activity_logs`: Sistem logları

## 🔧 API Endpoints

### Kimlik Doğrulama
- `POST /api/auth/login`: Kullanıcı girişi
- `POST /api/auth/register`: Kullanıcı kaydı

### Dilekçe İşlemleri
- `POST /api/petitions/create`: Yeni dilekçe oluşturma
- `POST /api/ai/generate-petition`: AI ile dilekçe oluşturma
- `POST /api/download/pdf`: PDF indirme
- `POST /api/download/word`: Word indirme

## � Ekran Görüntüleri

### Ana Sayfa
- Modern ve kullanıcı dostu arayüz
- Hızlı erişim butonları
- Özellik showcası

### Dilekçe Oluşturma
- AI destekli form
- Gerçek zamanlı önizleme
- İndirme seçenekleri

### Dosya Yükleme
- Drag & drop interface
- Dosya önizleme
- İlerleme göstergesi

## 🚀 Gelecek Planları

### v2.0 Özellikleri
- [ ] E-imza entegrasyonu
- [ ] SMS bildirimleri
- [ ] Çoklu dil desteği
- [ ] API genişletmesi
- [ ] Mobil uygulama

### AI Geliştirmeleri
- [ ] Daha gelişmiş dil modelleri
- [ ] Özel prompt'lar
- [ ] Dilekçe analizi
- [ ] Sentiment analysis

## 🤝 Katkıda Bulunma

1. Fork edin
2. Feature branch oluşturun (`git checkout -b feature/yeni-ozellik`)
3. Değişikliklerinizi commit edin (`git commit -am 'Yeni özellik eklendi'`)
4. Branch'inizi push edin (`git push origin feature/yeni-ozellik`)
5. Pull Request oluşturun

## 📝 Lisans

Bu proje MIT lisansı altında lisanslanmıştır. Detaylar için `LICENSE` dosyasını inceleyin.

## 👥 Ekip

- **Ana Geliştirici**: AI Assisted Development
- **UI/UX**: Bootstrap 5 + Custom CSS
- **Backend**: PHP 8+ Modern Architecture

## 📞 İletişim

- **GitHub**: [sporcu28/dilekcepro-groq-ap](https://github.com/sporcu28/dilekcepro-groq-ap)
- **E-posta**: developer@petitionapp.com

## 🏆 Başarılar

- ✅ Modern PHP 8+ mimarisi
- ✅ AI entegrasyonu
- ✅ Güvenli dosya yükleme
- ✅ PDF/Word indirme
- ✅ Responsive tasarım
- ✅ CSRF koruması
- ✅ Session güvenliği

---

**Not**: Bu uygulama demo amaçlı geliştirilmiştir. Üretim ortamında kullanım için ek güvenlik önlemleri alınması önerilir.
