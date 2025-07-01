<?php
$title = 'Ana Sayfa - Profesyonel Dilekçe Uygulaması';
ob_start();
?>

<div class="hero-section" style="background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; padding: 5rem 0; position: relative; overflow: hidden;">
    <div class="hero-particles" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1;">
        <i class="fas fa-file-contract" style="position: absolute; top: 10%; left: 10%; font-size: 3rem; animation: float 6s ease-in-out infinite;"></i>
        <i class="fas fa-stamp" style="position: absolute; top: 20%; right: 15%; font-size: 2rem; animation: float 8s ease-in-out infinite;"></i>
        <i class="fas fa-signature" style="position: absolute; bottom: 20%; left: 20%; font-size: 2.5rem; animation: float 7s ease-in-out infinite;"></i>
    </div>
    
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-3 fw-bold mb-4">
                    <i class="fas fa-file-signature me-3" style="color: #f39c12;"></i>
                    Profesyonel Dilekçe Merkezi
                </h1>
                <p class="lead mb-4" style="font-size: 1.3rem; line-height: 1.6;">
                    Yapay zeka destekli, tamamen dijital dilekçe yönetim sistemi. 
                    Dilekçelerinizi oluşturun, yükleyin, takip edin ve profesyonel yanıtlar alın.
                </p>
                
                <div class="feature-highlights mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-2" style="color: #2ecc71;"></i>
                        <span>AI destekli otomatik dilekçe oluşturma</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-2" style="color: #2ecc71;"></i>
                        <span>PDF/Word formatında indirme</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-2" style="color: #2ecc71;"></i>
                        <span>Resim ve PDF yükleme desteği</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2" style="color: #2ecc71;"></i>
                        <span>Hızlı cevap ve takip sistemi</span>
                    </div>
                </div>
                
                <div class="d-flex flex-wrap gap-3">
                    <a href="#quick-actions" class="btn btn-warning btn-lg px-4 py-3 shadow">
                        <i class="fas fa-plus-circle me-2"></i>
                        Hemen Dilekçe Oluştur
                    </a>
                    <a href="#upload-petition" class="btn btn-outline-light btn-lg px-4 py-3">
                        <i class="fas fa-upload me-2"></i>
                        Dilekçe Yükle & Cevap Al
                    </a>
                    <a href="/login" class="btn btn-light btn-lg px-4 py-3">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Giriş Yap
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="hero-animation" style="position: relative;">
                    <div class="main-icon" style="font-size: 8rem; color: rgba(255,255,255,0.2); animation: pulse 2s infinite;">
                        <i class="fas fa-laptop-file"></i>
                    </div>
                    <div class="floating-icons" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                        <i class="fas fa-file-pdf" style="position: absolute; top: 20%; left: 20%; font-size: 2rem; color: #e74c3c; animation: bounce 3s infinite;"></i>
                        <i class="fas fa-file-word" style="position: absolute; top: 30%; right: 20%; font-size: 2rem; color: #3498db; animation: bounce 3s infinite 0.5s;"></i>
                        <i class="fas fa-robot" style="position: absolute; bottom: 30%; left: 30%; font-size: 2rem; color: #9b59b6; animation: bounce 3s infinite 1s;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hızlı İşlem Bölümü -->
<section id="quick-actions" class="py-5" style="background: linear-gradient(45deg, #f8f9fa, #ffffff);">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold mb-3">
                    <i class="fas fa-rocket me-3" style="color: #e74c3c;"></i>
                    Hızlı İşlemler
                </h2>
                <p class="lead text-muted">Dilekçe sürecinizi hızlandıracak akıllı çözümler</p>
            </div>
        </div>
        
        <div class="row g-4">
            <!-- AI Dilekçe Oluşturma -->
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-lg hover-card" style="transition: all 0.3s ease;">
                    <div class="card-header bg-gradient text-white text-center py-4" style="background: linear-gradient(135deg, #8e44ad, #9b59b6);">
                        <i class="fas fa-robot fa-3x mb-3"></i>
                        <h4 class="fw-bold mb-0">AI Dilekçe Oluştur</h4>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted mb-4">Konunuzu belirtin, yapay zeka size profesyonel bir dilekçe hazırlasın. PDF ve Word formatında indirebilirsiniz.</p>
                        
                        <div class="quick-form">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Dilekçe Konusu</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Örn: İzin talebi, şikayet, başvuru..." id="petition-topic">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Ton</label>
                                <select class="form-select form-select-lg" id="petition-tone">
                                    <option value="formal">Resmi</option>
                                    <option value="respectful">Saygılı</option>
                                    <option value="urgent">Acil</option>
                                    <option value="friendly">Samimi</option>
                                </select>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-purple btn-lg" onclick="generatePetition()">
                                    <i class="fas fa-magic me-2"></i>
                                    Dilekçe Oluştur
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Dosya Yükleme ve Cevap Alma -->
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-lg hover-card" style="transition: all 0.3s ease;">
                    <div class="card-header bg-gradient text-white text-center py-4" style="background: linear-gradient(135deg, #3498db, #2980b9);">
                        <i class="fas fa-cloud-upload-alt fa-3x mb-3"></i>
                        <h4 class="fw-bold mb-0">Dilekçe Yükle & Cevap Al</h4>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted mb-4">Hazır dilekçenizi yükleyin (PDF, Word, JPG, PNG). Sisteme girdikten sonra size profesyonel bir cevap hazırlayalım.</p>
                        
                        <div class="upload-area border-3 border-dashed border-primary rounded p-4 text-center mb-3" style="transition: all 0.3s ease;" 
                             ondrop="dropHandler(event);" ondragover="dragOverHandler(event);" ondragenter="dragEnterHandler(event);" ondragleave="dragLeaveHandler(event);">
                            <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                            <p class="mb-2"><strong>Dosyanızı buraya sürükleyin</strong></p>
                            <p class="text-muted small">veya</p>
                            <input type="file" class="form-control" id="petition-file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" onchange="handleFileSelect(event)">
                        </div>
                        
                        <div id="file-info" class="alert alert-info d-none">
                            <i class="fas fa-file me-2"></i>
                            <span id="file-name"></span>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ek Açıklama (Opsiyonel)</label>
                            <textarea class="form-control" rows="3" placeholder="Dilekçeniz hakkında ek bilgi verebilirsiniz..."></textarea>
                        </div>
                        
                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg" onclick="uploadPetition()">
                                <i class="fas fa-paper-plane me-2"></i>
                                Yükle & Cevap İste
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Özellikler -->
<section class="features-section py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold mb-3">
                    <i class="fas fa-star me-3" style="color: #f39c12;"></i>
                    Gelişmiş Özellikler
                </h2>
                <p class="lead text-muted">Dilekçe yönetiminde yeni nesil teknoloji</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm feature-card">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-download fa-3x" style="color: #e74c3c;"></i>
                        </div>
                        <h5 class="card-title fw-bold">PDF & Word İndir</h5>
                        <p class="card-text text-muted">
                            Oluşturduğunuz dilekçeleri PDF veya Word formatında 
                            anında indirin ve yazdırın.
                        </p>
                        <div class="download-formats">
                            <span class="badge bg-danger me-2"><i class="fas fa-file-pdf me-1"></i>PDF</span>
                            <span class="badge bg-primary"><i class="fas fa-file-word me-1"></i>Word</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm feature-card">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-camera fa-3x" style="color: #27ae60;"></i>
                        </div>
                        <h5 class="card-title fw-bold">Görsel & Belge Desteği</h5>
                        <p class="card-text text-muted">
                            JPG, PNG resimler ve PDF belgelerini yükleyerek 
                            dilekçenizi destekleyin.
                        </p>
                        <div class="file-types">
                            <span class="badge bg-success me-1"><i class="fas fa-image me-1"></i>JPG</span>
                            <span class="badge bg-info me-1"><i class="fas fa-image me-1"></i>PNG</span>
                            <span class="badge bg-danger"><i class="fas fa-file-pdf me-1"></i>PDF</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm feature-card">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-reply fa-3x" style="color: #3498db;"></i>
                        </div>
                        <h5 class="card-title fw-bold">Otomatik Cevap</h5>
                        <p class="card-text text-muted">
                            Yüklediğiniz dilekçelere AI destekli profesyonel 
                            cevaplar otomatik olarak hazırlanır.
                        </p>
                        <div class="response-time">
                            <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>~2 dk</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm feature-card">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shield-alt fa-3x" style="color: #8e44ad;"></i>
                        </div>
                        <h5 class="card-title fw-bold">Güvenli & Gizli</h5>
                        <p class="card-text text-muted">
                            Tüm verileriniz şifrelenir, kişisel bilgileriniz 
                            korunur ve üçüncü taraflarla paylaşılmaz.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm feature-card">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-mobile-alt fa-3x" style="color: #e67e22;"></i>
                        </div>
                        <h5 class="card-title fw-bold">Mobil Uyumlu</h5>
                        <p class="card-text text-muted">
                            Telefon, tablet ve bilgisayardan sorunsuz erişim. 
                            Responsive tasarım ile her cihazda mükemmel deneyim.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm feature-card">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-chart-line fa-3x" style="color: #f39c12;"></i>
                        </div>
                        <h5 class="card-title fw-bold">Analitik & Takip</h5>
                        <p class="card-text text-muted">
                            Dilekçe durumunuzu gerçek zamanlı takip edin, 
                            detaylı istatistikler ve raporlar görüntüleyin.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- İstatistikler -->
<section class="stats-section py-5" style="background: linear-gradient(135deg, #2c3e50, #34495e);">
    <div class="container">
        <div class="row text-center text-white">
            <div class="col-md-3 mb-4">
                <div class="stat-item">
                    <i class="fas fa-users fa-2x mb-3" style="color: #3498db;"></i>
                    <h3 class="display-4 fw-bold mb-0 counter" data-target="1250">0</h3>
                    <p class="mb-0">Aktif Kullanıcı</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-item">
                    <i class="fas fa-file-alt fa-2x mb-3" style="color: #2ecc71;"></i>
                    <h3 class="display-4 fw-bold mb-0 counter" data-target="5430">0</h3>
                    <p class="mb-0">İşlenen Dilekçe</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-item">
                    <i class="fas fa-smile fa-2x mb-3" style="color: #f39c12;"></i>
                    <h3 class="display-4 fw-bold mb-0"><span class="counter" data-target="98">0</span>%</h3>
                    <p class="mb-0">Memnuniyet Oranı</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-item">
                    <i class="fas fa-clock fa-2x mb-3" style="color: #e74c3c;"></i>
                    <h3 class="display-4 fw-bold mb-0"><span class="counter" data-target="2">0</span> dk</h3>
                    <p class="mb-0">Ortalama Yanıt Süresi</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section text-center py-5">
    <div class="container">
        <div class="card border-0 shadow-lg">
            <div class="card-body p-5" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
                <h2 class="display-5 fw-bold mb-4">
                    <i class="fas fa-rocket me-3"></i>
                    Profesyonel Dilekçe Deneyimi
                </h2>
                <p class="lead mb-4">
                    Artık dilekçe yazmak ve cevap almak çok kolay! AI destekli sistemimizle 
                    dakikalar içinde profesyonel sonuçlar elde edin.
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="/register" class="btn btn-light btn-lg px-4 py-3">
                        <i class="fas fa-user-plus me-2"></i>
                        Ücretsiz Hesap Aç
                    </a>
                    <a href="#quick-actions" class="btn btn-outline-light btn-lg px-4 py-3">
                        <i class="fas fa-play me-2"></i>
                        Hemen Dene
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.2; }
    50% { transform: scale(1.05); opacity: 0.3; }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    60% { transform: translateY(-5px); }
}

.hover-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}

.feature-card:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
}

.btn-purple {
    background: linear-gradient(135deg, #8e44ad, #9b59b6);
    border: none;
    color: white;
}

.btn-purple:hover {
    background: linear-gradient(135deg, #9b59b6, #8e44ad);
    color: white;
    transform: translateY(-2px);
}

.upload-area {
    cursor: pointer;
    background: #f8f9fa;
}

.upload-area:hover {
    background: #e9ecef;
    border-color: #007bff !important;
}

.upload-area.dragover {
    background: #e3f2fd;
    border-color: #2196f3 !important;
    transform: scale(1.02);
}

.counter {
    transition: all 2s ease;
}
</style>

<script>
// AI Dilekçe Oluşturma
function generatePetition() {
    const topic = document.getElementById('petition-topic').value;
    const tone = document.getElementById('petition-tone').value;
    
    if (!topic.trim()) {
        alert('Lütfen dilekçe konusunu belirtin.');
        return;
    }
    
    // Loading göster
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Oluşturuluyor...';
    btn.disabled = true;
    
    // Simülasyon için setTimeout
    setTimeout(() => {
        window.location.href = `/ai-generate?topic=${encodeURIComponent(topic)}&tone=${tone}`;
    }, 1500);
}

// Dosya Yükleme
function uploadPetition() {
    const fileInput = document.getElementById('petition-file');
    if (!fileInput.files[0]) {
        alert('Lütfen bir dosya seçin.');
        return;
    }
    
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Yükleniyor...';
    btn.disabled = true;
    
    // Simülasyon için setTimeout
    setTimeout(() => {
        window.location.href = '/upload-petition';
    }, 2000);
}

// Drag & Drop İşlemleri
function dragOverHandler(ev) {
    ev.preventDefault();
}

function dragEnterHandler(ev) {
    ev.preventDefault();
    ev.target.closest('.upload-area').classList.add('dragover');
}

function dragLeaveHandler(ev) {
    ev.target.closest('.upload-area').classList.remove('dragover');
}

function dropHandler(ev) {
    ev.preventDefault();
    ev.target.closest('.upload-area').classList.remove('dragover');
    
    const files = ev.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('petition-file').files = files;
        handleFileSelect({ target: { files: files } });
    }
}

function handleFileSelect(event) {
    const file = event.target.files[0];
    if (file) {
        const fileInfo = document.getElementById('file-info');
        const fileName = document.getElementById('file-name');
        fileName.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
        fileInfo.classList.remove('d-none');
    }
}

// Sayaç Animasyonu
function animateCounters() {
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const increment = target / 100;
        let current = 0;
        
        const updateCounter = () => {
            if (current < target) {
                current += increment;
                counter.textContent = Math.ceil(current);
                setTimeout(updateCounter, 30);
            } else {
                counter.textContent = target;
            }
        };
        
        updateCounter();
    });
}

// Sayfa yüklendiğinde sayaçları başlat
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer ile sayaçları görünür olduğunda başlat
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.disconnect();
            }
        });
    });
    
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        observer.observe(statsSection);
    }
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>