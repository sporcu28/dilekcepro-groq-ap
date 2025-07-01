# 🚀 AI Sports Predictor - Hızlı Kurulum Rehberi

Bu rehber, AI Sports Predictor uygulamasını yerel makinenizde çalıştırmanız için gereken tüm adımları içerir.

## ✅ Gereksinimler

Başlamadan önce sisteminizde aşağıdakilerin yüklü olduğundan emin olun:

- **Node.js v16+** ([nodejs.org](https://nodejs.org/))
- **npm v8+** (Node.js ile birlikte gelir)
- **Git** ([git-scm.com](https://git-scm.com/))
- Modern web tarayıcısı (Chrome, Firefox, Safari, Edge)

## 🔧 Kurulum Adımları

### 1. Projeyi İndirin
```bash
git clone <repository-url>
cd ai-sports-predictor
```

### 2. Otomatik Kurulum (Önerilen)
```bash
# Tek komutla tüm bağımlılıkları yükler
npm run setup
```

### 3. Manuel Kurulum (Alternatif)
```bash
# Backend bağımlılıklarını yükleyin
npm install

# Frontend bağımlılıklarını yükleyin
cd client
npm install
cd ..
```

### 4. Environment Dosyalarını Ayarlayın

#### Backend (.env)
```bash
cp .env.example .env
```

`.env` dosyasını düzenleyin:
```env
PORT=3000
NODE_ENV=development
FOOTBALL_API_KEY=your_api_key_here  # İsteğe bağlı - demo veriler kullanılır
CORS_ORIGIN=http://localhost:3001
AI_MODEL_CONFIDENCE_THRESHOLD=0.7
```

#### Frontend (client/.env)
```bash
cd client
cp .env.example .env
```

`client/.env` dosyasını düzenleyin:
```env
REACT_APP_API_URL=http://localhost:3000
GENERATE_SOURCEMAP=false
```

## 🚀 Uygulamayı Başlatma

### Development Mode (Geliştirme)
```bash
# Hem backend hem frontend'i aynı anda başlatır
npm run dev:full
```

Bu komut aşağıdakileri yapar:
- Backend sunucu: `http://localhost:3000`
- Frontend React app: `http://localhost:3001`
- Otomatik browser açma

### Manuel Başlatma
Terminal 1 - Backend:
```bash
npm run dev
```

Terminal 2 - Frontend:
```bash
npm run dev:client
```

## 🌐 Uygulama Erişimi

Kurulum tamamlandıktan sonra:

1. **Frontend**: [http://localhost:3001](http://localhost:3001)
2. **Backend API**: [http://localhost:3000](http://localhost:3000)
3. **Socket.IO**: Otomatik bağlanır

## ✨ İlk Kullanım

1. Tarayıcınızda [http://localhost:3001](http://localhost:3001) adresini açın
2. Canlı maçlar listesini görüntüleyin
3. Bir maça tıklayarak detaylı AI tahminlerini inceleyin
4. Gerçek zamanlı güncellemeleri takip edin

## 🔧 Geliştirme Komutları

```bash
# Backend'i geliştirme modunda başlat
npm run dev

# Frontend'i geliştirme modunda başlat  
npm run dev:client

# Her ikisini birlikte başlat
npm run dev:full

# Production build oluştur
npm run build

# Production modunda başlat
npm start
```

## 🐛 Sorun Giderme

### Port Çakışması
Eğer portlar kullanımdaysa:

1. `.env` dosyasında `PORT=3002` gibi farklı port kullanın
2. `client/.env` dosyasında `REACT_APP_API_URL=http://localhost:3002` güncelleyin

### Node.js Sürüm Sorunu
```bash
# Node.js sürümünü kontrol edin
node --version

# v16 veya üzeri olmalı
```

### Bağımlılık Hatası
```bash
# Cache'i temizleyin ve yeniden yükleyin
npm cache clean --force
rm -rf node_modules package-lock.json
npm install

# Frontend için aynı işlem
cd client
rm -rf node_modules package-lock.json  
npm install
```

### TensorFlow.js Yükleme Sorunu
```bash
# Python ve build tools gerekebilir (Windows)
npm install --global --production windows-build-tools

# MacOS için
xcode-select --install
```

## 🔑 API Anahtarı (İsteğe Bağlı)

Gerçek maç verisi için Football-Data.org API anahtarı:

1. [Football-Data.org](https://www.football-data.org/) hesabı oluşturun
2. API anahtarınızı alın
3. `.env` dosyasında `FOOTBALL_API_KEY=your_key` güncelleyin

**Not**: API anahtarı olmadan demo veriler kullanılır.

## 📱 Özellikler

✅ Yapay Zeka Tahmin Motoru (TensorFlow.js)  
✅ Gerçek Zamanlı Veri Akışı (Socket.IO)  
✅ Modern React Arayüzü  
✅ Responsive Tasarım  
✅ Canlı Maç Takibi  
✅ Detaylı İstatistikler  
✅ Momentum & Baskı Analizi  

## 🆘 Destek

Sorun yaşıyorsanız:

1. **Console Logları**: Tarayıcı geliştirici araçlarını kontrol edin
2. **Server Logları**: Terminal çıktısını inceleyin  
3. **GitHub Issues**: Yeni issue açın
4. **Documentation**: README.md dosyasını okuyun

## 🔄 Güncelleme

```bash
# Yeni sürümü çekin
git pull origin main

# Bağımlılıkları güncelleyin
npm run setup
```

## 🎯 Sonraki Adımlar

1. Canlı maçları keşfedin 🏈
2. AI tahminlerini test edin 🤖  
3. Gerçek zamanlı güncellemeleri takip edin ⚡
4. İstatistikleri analiz edin 📊

---

**🚀 Kurulum tamamlandı! AI Sports Predictor ile geleceği tahmin etmeye başlayın!**