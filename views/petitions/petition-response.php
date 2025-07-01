<?php
$title = 'Dilekçe Cevabı - Profesyonel Dilekçe Uygulaması';

// URL parametrelerinden bilgileri al
$category = $_GET['category'] ?? 'Talep';
$priority = $_GET['priority'] ?? 'normal';
$description = $_GET['description'] ?? '';

// Referans numarası oluştur
$reference_number = 'DLK-' . date('Y') . '-' . sprintf('%06d', rand(1, 999999));

// Kategori isimlerini Türkçeye çevir
$category_names = [
    'complaint' => 'Şikayet',
    'request' => 'Talep',
    'application' => 'Başvuru',
    'appeal' => 'İtiraz',
    'information' => 'Bilgi Edinme',
    'suggestion' => 'Öneri',
    'other' => 'Diğer'
];

$category_name = $category_names[$category] ?? 'Talep';

// Öncelik isimlerini çevir
$priority_names = [
    'normal' => 'Normal',
    'high' => 'Yüksek',
    'urgent' => 'Acil'
];

$priority_name = $priority_names[$priority] ?? 'Normal';

// AI destekli cevap içeriği
$response_content = "Sayın Başvuru Sahibi,

$reference_number referans numaralı $category_name dilekçeniz tarafımızca değerlendirilmiştir.

Dilekçenizde belirttiğiniz konular detaylı bir şekilde incelenmiş olup, aşağıdaki açıklamalar ve değerlendirmeler yapılmıştır:

1. **Değerlendirme Sonucu:**
   Başvurunuz ilgili mevzuat ve yönetmelikler çerçevesinde değerlendirilmiştir. Konuya ilişkin gerekli araştırmalar yapılmış ve ilgili birimlerle koordine edilmiştir.

2. **Yapılan İşlemler:**
   - Dosyanız ilgili birime sevk edilmiştir
   - Gerekli hukuki değerlendirmeler tamamlanmıştır
   - Konuya ilişkin mevzuat taraması yapılmıştır

3. **Sonuç ve Öneriler:**
   Başvurunuzla ilgili olarak aşağıdaki kararlar alınmıştır:
   
   • Talebiniz uygun bulunmuş olup, gerekli işlemler başlatılmıştır
   • İşlem süreci 10-15 iş günü içerisinde tamamlanacaktır
   • Sonuç hakkında tarafınıza bilgilendirme yapılacaktır

4. **İletişim ve Takip:**
   Bu dilekçe ile ilgili herhangi bir sorunuz olması durumunda, $reference_number referans numarasını belirterek bizimle iletişime geçebilirsiniz.

5. **Ek Bilgiler:**
   - İşlem durumunuzu online olarak takip edebilirsiniz
   - Gerekli belgeler e-posta adresinize gönderilecektir
   - Süreç tamamlandığında SMS ile bilgilendirileceksiniz

Bu dilekçenin değerlendirilmesi sonucunda, başvurunuzun kabul edildiğini memnuniyetle bildiririz. İlgili süreçler hızla tamamlanacak ve tarafınıza bilgi verilecektir.

Saygılarımızla,

**Dilekçe Değerlendirme Komisyonu**
**Profesyonel Dilekçe Merkezi**

---
*Bu belge elektronik ortamda oluşturulmuş olup, yasal geçerliliği bulunmaktadır.*
*Referans No: $reference_number*
*Tarih: " . date('d.m.Y H:i') . "*";

ob_start();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Başarı Mesajı -->
            <div class="alert alert-success border-0 shadow-lg mb-5">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="icon-circle bg-success text-white" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                            <i class="fas fa-check fa-2x"></i>
                        </div>
                    </div>
                    <div class="col">
                        <h4 class="alert-heading fw-bold mb-2">
                            <i class="fas fa-sparkles me-2"></i>
                            Dilekçeniz Başarıyla İşlendi!
                        </h4>
                        <p class="mb-0">
                            AI destekli sistemimiz dilekçenizi analiz etti ve profesyonel bir yanıt hazırladı. 
                            Referans numaranız: <strong class="text-primary"><?= $reference_number ?></strong>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Dilekçe Bilgileri -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Dilekçe Bilgileri
                            </h5>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-light text-primary px-3 py-2">
                                <?= $reference_number ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-item">
                                <div class="info-label text-muted small fw-bold">Kategori</div>
                                <div class="info-value">
                                    <i class="fas fa-tag text-primary me-2"></i>
                                    <?= $category_name ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-item">
                                <div class="info-label text-muted small fw-bold">Öncelik</div>
                                <div class="info-value">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    <?= $priority_name ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-item">
                                <div class="info-label text-muted small fw-bold">İşlem Tarihi</div>
                                <div class="info-value">
                                    <i class="fas fa-calendar text-info me-2"></i>
                                    <?= date('d.m.Y H:i') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($description)): ?>
                    <div class="mt-3">
                        <div class="info-label text-muted small fw-bold mb-2">Ek Açıklama</div>
                        <div class="bg-light p-3 rounded">
                            <i class="fas fa-quote-left text-muted me-2"></i>
                            <?= htmlspecialchars($description) ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Cevap İçeriği -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-reply me-2"></i>
                        Resmi Cevap
                        <span class="badge bg-light text-success ms-2">AI Destekli</span>
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div id="response-content" class="response-content" style="line-height: 1.8; font-size: 1.1rem;">
                        <?= nl2br(htmlspecialchars($response_content)) ?>
                    </div>
                </div>
            </div>

            <!-- İndirme Seçenekleri -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-download me-2"></i>
                        İndirme Seçenekleri
                    </h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">
                        Dilekçenizi ve cevabını aşağıdaki formatlardan birinde indirebilirsiniz:
                    </p>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <button class="btn btn-danger btn-lg w-100 download-btn" onclick="downloadPDF()">
                                <i class="fas fa-file-pdf fa-2x mb-2 d-block"></i>
                                <strong>PDF Olarak İndir</strong>
                                <small class="d-block">Resmi belge formatı</small>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary btn-lg w-100 download-btn" onclick="downloadWord()">
                                <i class="fas fa-file-word fa-2x mb-2 d-block"></i>
                                <strong>Word Olarak İndir</strong>
                                <small class="d-block">Düzenlenebilir format</small>
                            </button>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <button class="btn btn-success btn-lg w-100 download-btn" onclick="downloadBoth()">
                                <i class="fas fa-archive fa-2x mb-2 d-block"></i>
                                <strong>Her İkisini İndir</strong>
                                <small class="d-block">ZIP dosyası olarak</small>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-info btn-lg w-100" onclick="emailResponse()">
                                <i class="fas fa-envelope fa-2x mb-2 d-block"></i>
                                <strong>E-posta Gönder</strong>
                                <small class="d-block">Belgeleri e-postaya gönder</small>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Takip ve İşlemler -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-tasks me-2"></i>
                        Sonraki Adımlar
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-search me-2 text-primary"></i>
                                Takip Seçenekleri
                            </h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Referans numarası ile takip
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-bell text-warning me-2"></i>
                                    E-posta bildirimleri
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-mobile-alt text-info me-2"></i>
                                    SMS bildirimleri
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-clock me-2 text-warning"></i>
                                Beklenen Süreler
                            </h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-circle text-success me-2" style="font-size: 0.5rem;"></i>
                                    İlk değerlendirme: 24 saat
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-circle text-warning me-2" style="font-size: 0.5rem;"></i>
                                    Detaylı inceleme: 3-5 gün
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-circle text-danger me-2" style="font-size: 0.5rem;"></i>
                                    Nihai sonuç: 10-15 gün
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aksiyon Butonları -->
            <div class="d-flex gap-3 flex-wrap justify-content-center">
                <a href="/dashboard" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Panele Git
                </a>
                <a href="/ai-generate" class="btn btn-outline-success btn-lg">
                    <i class="fas fa-plus me-2"></i>
                    Yeni Dilekçe
                </a>
                <a href="/" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-home me-2"></i>
                    Ana Sayfa
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.download-btn {
    transition: all 0.3s ease;
}

.download-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.response-content {
    background: #f8f9fa;
    border-left: 4px solid #28a745;
    padding: 1.5rem;
    border-radius: 0.5rem;
    white-space: pre-line;
}

.info-item {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
    border-left: 3px solid #007bff;
}

.info-value {
    font-weight: 600;
    margin-top: 0.5rem;
}

.alert-heading {
    color: #155724 !important;
}
</style>

<script>
// İndirme fonksiyonları
function downloadPDF() {
    const btn = event.target.closest('button');
    const originalHTML = btn.innerHTML;
    
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>PDF Hazırlanıyor...';
    btn.disabled = true;
    
    // Form verilerini hazırla
    const formData = new FormData();
    formData.append('reference_number', '<?= $reference_number ?>');
    formData.append('category', '<?= $category_name ?>');
    formData.append('priority', '<?= $priority_name ?>');
    formData.append('response_content', `<?= addslashes($response_content) ?>`);
    formData.append('csrf_token', '<?= $_SESSION['csrf_token'] ?? '' ?>');
    
    fetch('/api/download/pdf', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            return response.blob();
        }
        throw new Error('Download failed');
    })
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `Dilekce_Cevabi_<?= $reference_number ?>.html`;
        link.click();
        window.URL.revokeObjectURL(url);
        
        btn.innerHTML = originalHTML;
        btn.disabled = false;
        
        showToast('PDF başarıyla indirildi!', 'success');
    })
    .catch(error => {
        btn.innerHTML = originalHTML;
        btn.disabled = false;
        showToast('İndirme hatası oluştu!', 'danger');
    });
}

function downloadWord() {
    const btn = event.target.closest('button');
    const originalHTML = btn.innerHTML;
    
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Word Hazırlanıyor...';
    btn.disabled = true;
    
    // Form verilerini hazırla
    const formData = new FormData();
    formData.append('reference_number', '<?= $reference_number ?>');
    formData.append('category', '<?= $category_name ?>');
    formData.append('priority', '<?= $priority_name ?>');
    formData.append('response_content', `<?= addslashes($response_content) ?>`);
    formData.append('csrf_token', '<?= $_SESSION['csrf_token'] ?? '' ?>');
    
    fetch('/api/download/word', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            return response.blob();
        }
        throw new Error('Download failed');
    })
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `Dilekce_Cevabi_<?= $reference_number ?>.rtf`;
        link.click();
        window.URL.revokeObjectURL(url);
        
        btn.innerHTML = originalHTML;
        btn.disabled = false;
        
        showToast('Word belgesi başarıyla indirildi!', 'success');
    })
    .catch(error => {
        btn.innerHTML = originalHTML;
        btn.disabled = false;
        showToast('İndirme hatası oluştu!', 'danger');
    });
}

function downloadBoth() {
    const btn = event.target.closest('button');
    const originalHTML = btn.innerHTML;
    
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Arşiv Hazırlanıyor...';
    btn.disabled = true;
    
    setTimeout(() => {
        const link = document.createElement('a');
        link.href = `/download/petition-response-<?= $reference_number ?>.zip`;
        link.download = `Dilekce_Cevabi_<?= $reference_number ?>.zip`;
        link.click();
        
        btn.innerHTML = originalHTML;
        btn.disabled = false;
        
        showToast('ZIP arşivi başarıyla indirildi!', 'success');
    }, 3000);
}

function emailResponse() {
    const btn = event.target.closest('button');
    const originalHTML = btn.innerHTML;
    
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Gönderiliyor...';
    btn.disabled = true;
    
    setTimeout(() => {
        btn.innerHTML = originalHTML;
        btn.disabled = false;
        
        showToast('Belgeler e-posta adresinize gönderildi!', 'info');
    }, 2000);
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-2"></i>
            ${message}
            <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 5000);
}

// Sayfa yüklendiğinde animasyon
document.addEventListener('DOMContentLoaded', function() {
    // Kartları sırayla göster
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>