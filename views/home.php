<?php
$title = 'Ana Sayfa - Dilekçe Uygulaması';
ob_start();
?>

<div class="hero-section" style="background: linear-gradient(135deg, #2c3e50, #3498db); color: white; padding: 4rem 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">
                    <i class="fas fa-file-signature me-3"></i>
                    Dilekçe Uygulaması
                </h1>
                <p class="lead mb-4">
                    Yapay zeka destekli modern dilekçe yönetim sistemi. Dilekçelerinizi kolayca oluşturun, 
                    takip edin ve profesyonel yanıtlar alın.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="/register" class="btn btn-light btn-lg">
                        <i class="fas fa-user-plus me-2"></i>
                        Hemen Başlayın
                    </a>
                    <a href="/login" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Giriş Yapın
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="hero-image">
                    <i class="fas fa-laptop-code" style="font-size: 12rem; opacity: 0.1;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Özellikler -->
    <section class="features-section">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold mb-3">Özellikler</h2>
                <p class="lead text-muted">Modern dilekçe yönetimi için ihtiyacınız olan her şey</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-robot fa-3x" style="color: #8e44ad;"></i>
                        </div>
                        <h5 class="card-title fw-bold">AI Destekli Oluşturma</h5>
                        <p class="card-text text-muted">
                            Yapay zeka teknolojisi ile konunuzu belirtin, 
                            profesyonel dilekçeniz otomatik olarak oluşturulsun.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-search fa-3x" style="color: #3498db;"></i>
                        </div>
                        <h5 class="card-title fw-bold">Akıllı Takip</h5>
                        <p class="card-text text-muted">
                            Dilekçelerinizin durumunu gerçek zamanlı olarak takip edin, 
                            bildirimleri kaçırmayın.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shield-alt fa-3x" style="color: #27ae60;"></i>
                        </div>
                        <h5 class="card-title fw-bold">Güvenli Sistem</h5>
                        <p class="card-text text-muted">
                            Verileriniz şifrelenerek korunur, 
                            kişisel bilgileriniz güvende kalır.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-clock fa-3x" style="color: #f39c12;"></i>
                        </div>
                        <h5 class="card-title fw-bold">Hızlı İşlem</h5>
                        <p class="card-text text-muted">
                            Dilekçeleriniz hızlı bir şekilde değerlendirilir, 
                            bekleme süreniz minimize edilir.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-mobile-alt fa-3x" style="color: #e74c3c;"></i>
                        </div>
                        <h5 class="card-title fw-bold">Mobil Uyumlu</h5>
                        <p class="card-text text-muted">
                            Her cihazdan erişilebilir responsive tasarım, 
                            istediğiniz yerden dilekçe yönetimi.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-chart-line fa-3x" style="color: #9b59b6;"></i>
                        </div>
                        <h5 class="card-title fw-bold">Detaylı Raporlar</h5>
                        <p class="card-text text-muted">
                            Dilekçe istatistiklerinizi görüntüleyin, 
                            süreçleri analiz edin ve iyileştirin.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nasıl Çalışır -->
    <section class="how-it-works py-5 mt-5">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold mb-3">Nasıl Çalışır?</h2>
                <p class="lead text-muted">3 basit adımda dilekçe sürecinizi tamamlayın</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4 text-center">
                <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: bold;">
                    1
                </div>
                <h5 class="fw-bold">Hesap Oluşturun</h5>
                <p class="text-muted">
                    Hızlı kayıt işlemi ile hesabınızı oluşturun ve 
                    sistem özelliklerinden faydalanmaya başlayın.
                </p>
            </div>
            
            <div class="col-md-4 text-center">
                <div class="step-number bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: bold;">
                    2
                </div>
                <h5 class="fw-bold">Dilekçe Oluşturun</h5>
                <p class="text-muted">
                    Manuel olarak yazın ya da AI desteği ile 
                    konunuzu belirterek otomatik oluşturun.
                </p>
            </div>
            
            <div class="col-md-4 text-center">
                <div class="step-number bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: bold;">
                    3
                </div>
                <h5 class="fw-bold">Takip Edin</h5>
                <p class="text-muted">
                    Dilekçenizin durumunu takip edin, 
                    yanıtları görüntüleyin ve süreci yönetin.
                </p>
            </div>
        </div>
    </section>

    <!-- İstatistikler -->
    <section class="stats-section py-5 mt-5">
        <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
            <div class="card-body p-5">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="stat-item">
                            <h3 class="display-4 fw-bold text-primary mb-0">100+</h3>
                            <p class="text-muted mb-0">Aktif Kullanıcı</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-item">
                            <h3 class="display-4 fw-bold text-success mb-0">500+</h3>
                            <p class="text-muted mb-0">İşlenen Dilekçe</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-item">
                            <h3 class="display-4 fw-bold text-warning mb-0">95%</h3>
                            <p class="text-muted mb-0">Memnuniyet Oranı</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-item">
                            <h3 class="display-4 fw-bold text-danger mb-0">24/7</h3>
                            <p class="text-muted mb-0">Sistem Erişimi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section text-center py-5 mt-5">
        <div class="card border-0 shadow-lg">
            <div class="card-body p-5" style="background: linear-gradient(135deg, #3498db, #2c3e50); color: white;">
                <h2 class="display-5 fw-bold mb-4">Hemen Başlayın!</h2>
                <p class="lead mb-4">
                    Dilekçe süreçlerinizi modernize edin. Ücretsiz hesap oluşturun ve 
                    yapay zeka destekli dilekçe yönetiminin avantajlarını keşfedin.
                </p>
                <a href="/register" class="btn btn-light btn-lg">
                    <i class="fas fa-rocket me-2"></i>
                    Ücretsiz Başlayın
                </a>
            </div>
        </div>
    </section>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>