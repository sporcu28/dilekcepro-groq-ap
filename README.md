# 🤖 AI Sports Predictor - Yapay Zeka Destekli Canlı Maç Tahmin Sistemi

Modern teknolojilerle geliştirilmiş, yapay zeka destekli canlı maç analiz ve tahmin sistemi. Gerçek zamanlı maç verilerini analiz ederek gelişmiş AI algoritmaları ile %100 doğruluk hedefli tahminler yapan kapsamlı bir uygulama.

## ✨ Özellikler

### � AI Tahmin Motoru
- **TensorFlow.js** ile gelişmiş neural network modeli
- Gerçek zamanlı maç verilerini analiz eden machine learning algoritmaları
- Çoklu olay tipi tahminleri (Gol, Korner, Kart, Değişiklik vb.)
- Dinamik güven skorları ve olasılık hesaplamaları

### ⚡ Gerçek Zamanlı Veriler
- **Socket.IO** ile canlı veri akışı
- 30 saniyede bir güncellenen maç bilgileri
- Anlık olay bildirimleri
- Otomatik yeniden bağlantı sistemi

### � Detaylı Analiz
- Momentum ve baskı analizleri
- Kritik faktör belirlemeleri
- Oyun durumu değerlendirmeleri
- İstatistiksel karşılaştırmalar

### 🎨 Modern Arayüz
- **React 18** ile gelişmiş component yapısı
- **Framer Motion** animasyonları
- Responsive ve mobil uyumlu tasarım
- Glass morphism ve gradient efektleri

## 🚀 Kurulum

### Gereksinimler
- Node.js (v16+)
- npm veya yarn
- Modern web tarayıcısı

### 1. Projeyi İndirin
```bash
git clone <repository-url>
cd ai-sports-predictor
```

### 2. Backend Kurulumu
```bash
# Dependencies'leri yükleyin
npm install

# Environment variables'ları ayarlayın
cp .env.example .env

# Serveri başlatın
npm start
```

### 3. Frontend Kurulumu
```bash
# Client dizinine geçin
cd client

# Dependencies'leri yükleyin
npm install

# Environment variables'ları ayarlayın
cp .env.example .env

# Development server'ı başlatın
npm start
```

### 4. Production Build
```bash
# Ana dizinde
npm run build

# Tek komutla hem backend hem frontend başlatma
npm run dev
```

## 🏗️ Proje Yapısı

```
ai-sports-predictor/
├── 📁 src/
│   ├── 📁 services/
│   │   ├── sportsDataAPI.js      # Maç verisi API servisi
│   │   ├── aiPredictor.js        # AI tahmin motoru
│   │   └── matchAnalyzer.js      # Maç analiz servisi
│   └── index.js                  # Ana server dosyası
├── 📁 client/
│   ├── 📁 src/
│   │   ├── 📁 components/        # React bileşenleri
│   │   ├── 📁 services/          # Frontend servisler
│   │   └── 📁 styles/            # CSS ve stil dosyaları
│   └── package.json
├── package.json
└── README.md
```

## 🔧 Teknik Detaylar

### Backend Teknolojileri
- **Node.js & Express** - Server framework
- **Socket.IO** - Gerçek zamanlı iletişim
- **TensorFlow.js** - AI/ML işlemler
- **Axios** - HTTP client
- **CORS** - Cross-origin resource sharing

### Frontend Teknolojileri
- **React 18** - Modern UI library
- **Framer Motion** - Animasyon library
- **Recharts** - Grafik ve chart library
- **Lucide React** - İkon library
- **React Hot Toast** - Bildirim sistemi

### AI/ML Özellikleri
- **Neural Network**: 15 input, 3 hidden layer, 7 output
- **Training Data**: 1000+ sentetik maç verisi
- **Features**: Dakika, skor, istatistikler, momentum, baskı
- **Predictions**: Gol, korner, kart, değişiklik, ofsayt, faul

## � API Endpoints

### GET /api/live-matches
Canlı maçların listesini döner
```json
{
  "id": "match_id",
  "homeTeam": "Team A",
  "awayTeam": "Team B",
  "score": { "fullTime": { "home": 2, "away": 1 } },
  "minute": 67,
  "status": "IN_PLAY"
}
```

### GET /api/match/:id
Detaylı maç bilgileri ve AI tahminleri
```json
{
  "match": { /* maç verisi */ },
  "predictions": { /* AI tahminleri */ },
  "analysis": { /* detaylı analiz */ }
}
```

### POST /api/predict
Belirli olay tipi için tahmin
```json
{
  "matchId": "match_id",
  "eventType": "goal"
}
```

## 🔮 AI Tahmin Sistemi

### Tahmin Edilen Olaylar
1. **⚽ Gol** - Skor değişikliği olasılığı
2. **📐 Korner** - Sabit top durumu
3. **🟨 Sarı Kart** - Disiplin cezası
4. **🟥 Kırmızı Kart** - Oyuncu ihracı
5. **🔄 Oyuncu Değişikliği** - Taktik hamle
6. **🚩 Ofsayt** - Pozisyon hatası
7. **⚠️ Faul** - Oyun içi temas

### Analiz Faktörleri
- **Zaman Analizi**: Dakika bazlı olay olasılıkları
- **Momentum**: Takım performans trendi
- **Baskı**: Oyun baskısı ve gerginlik seviyesi
- **İstatistikler**: Şut, korner, faul sayıları
- **Takım Gücü**: Historical performans
- **Yorgunluk**: Maç süresi etkisi

## 🛠️ Geliştirme

### Development Mode
```bash
# Backend
npm run dev

# Frontend
cd client && npm start
```

### Environment Variables

#### Backend (.env)
```env
PORT=3000
FOOTBALL_API_KEY=your_api_key
AI_MODEL_CONFIDENCE_THRESHOLD=0.7
```

#### Frontend (client/.env)
```env
REACT_APP_API_URL=http://localhost:3000
```

### Debug Mode
Debug modunu aktifleştirmek için:
```bash
DEBUG=ai-sports-predictor:* npm start
```

## 📱 Kullanım

1. **Ana Sayfa**: Canlı maçları görüntüleyin
2. **Maç Seçimi**: İlgilendiğiniz maça tıklayın
3. **AI Tahminler**: Gerçek zamanlı tahminleri takip edin
4. **Analiz**: Detaylı maç analizini inceleyin
5. **İstatistikler**: Grafik ve tablolarla verileri görüntüleyin

## 🎯 Gelecek Özellikler

- [ ] Kullanıcı hesapları ve favoriler
- [ ] Tarihi maç veritabanı
- [ ] Gelişmiş AI modelleri
- [ ] Push notifications
- [ ] Bahis önerileri
- [ ] Sosyal paylaşım
- [ ] Dark/Light theme
- [ ] Multi-language support

## 🤝 Katkıda Bulunma

1. Fork edin
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Commit yapın (`git commit -m 'Add amazing feature'`)
4. Push edin (`git push origin feature/amazing-feature`)
5. Pull Request oluşturun

## � Lisans

Bu proje MIT lisansı altında lisanslanmıştır. Detaylar için `LICENSE` dosyasını inceleyin.

## � Teşekkürler

- **TensorFlow.js** ekibine AI/ML desteği için
- **React** ve **Node.js** topluluklarına
- **Football-Data.org** API sağlayıcısına
- Tüm açık kaynak katkıda bulunanlara

## 📧 İletişim

- 🌐 Website: [AI Sports Predictor](your-website.com)
- 📱 Email: contact@aisportspredictor.com
- 🐦 Twitter: [@aisportspred](https://twitter.com/aisportspred)

---

**⚡ Yapay Zeka ile Geleceği Tahmin Edin! ⚡**
