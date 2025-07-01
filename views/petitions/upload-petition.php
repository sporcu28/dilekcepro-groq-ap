<?php
$title = 'Dilekçe Yükle & Cevap Al - Profesyonel Dilekçe Uygulaması';
ob_start();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Başlık -->
            <div class="text-center mb-5">
                <div class="icon-circle bg-primary text-white mx-auto mb-4" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                    <i class="fas fa-cloud-upload-alt fa-2x"></i>
                </div>
                <h1 class="display-5 fw-bold mb-3">Dilekçe Yükle & Cevap Al</h1>
                <p class="lead text-muted">
                    Hazır dilekçenizi yükleyin, profesyonel bir yanıt hazırlayalım
                </p>
            </div>

            <!-- Ana Form -->
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <form id="upload-form" method="POST" enctype="multipart/form-data">
                        <!-- Dosya Yükleme Alanı -->
                        <div class="mb-4">
                            <label class="form-label fw-bold mb-3">
                                <i class="fas fa-paperclip me-2"></i>
                                Dilekçe Dosyası
                            </label>
                            
                            <div class="upload-zone border-3 border-dashed border-primary rounded p-5 text-center position-relative" 
                                 id="upload-zone"
                                 ondrop="dropHandler(event);" 
                                 ondragover="dragOverHandler(event);" 
                                 ondragenter="dragEnterHandler(event);" 
                                 ondragleave="dragLeaveHandler(event);">
                                
                                <div id="upload-placeholder">
                                    <i class="fas fa-cloud-upload-alt fa-4x text-primary mb-3"></i>
                                    <h5 class="fw-bold">Dosyanızı Buraya Sürükleyin</h5>
                                    <p class="text-muted mb-3">veya dosya seçmek için tıklayın</p>
                                    <p class="small text-muted">
                                        Desteklenen formatlar: PDF, Word (.doc, .docx), Resim (.jpg, .jpeg, .png)
                                        <br>Maksimum dosya boyutu: 10 MB
                                    </p>
                                </div>
                                
                                <div id="file-preview" class="d-none">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="file-icon me-3">
                                            <i class="fas fa-file fa-3x text-success"></i>
                                        </div>
                                        <div class="file-info text-start">
                                            <h6 class="fw-bold mb-1" id="file-name-display"></h6>
                                            <p class="text-muted small mb-0" id="file-size-display"></p>
                                        </div>
                                        <button type="button" class="btn btn-outline-danger btn-sm ms-3" onclick="removeFile()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <input type="file" 
                                       class="form-control position-absolute w-100 h-100 opacity-0" 
                                       style="top: 0; left: 0; cursor: pointer;"
                                       id="petition-file" 
                                       name="petition_file"
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" 
                                       onchange="handleFileSelect(event)"
                                       required>
                            </div>
                        </div>

                        <!-- Dilekçe Kategorisi -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-tags me-2"></i>
                                    Kategori
                                </label>
                                <select class="form-select form-select-lg" name="category" required>
                                    <option value="">Kategori seçin...</option>
                                    <option value="complaint">Şikayet</option>
                                    <option value="request">Talep</option>
                                    <option value="application">Başvuru</option>
                                    <option value="appeal">İtiraz</option>
                                    <option value="information">Bilgi Edinme</option>
                                    <option value="suggestion">Öneri</option>
                                    <option value="other">Diğer</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Öncelik
                                </label>
                                <select class="form-select form-select-lg" name="priority">
                                    <option value="normal">Normal</option>
                                    <option value="high">Yüksek</option>
                                    <option value="urgent">Acil</option>
                                </select>
                            </div>
                        </div>

                        <!-- Ek Açıklama -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-comment-alt me-2"></i>
                                Ek Açıklama (Opsiyonel)
                            </label>
                            <textarea class="form-control form-control-lg" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Dilekçeniz hakkında ek bilgi, beklentileriniz veya özel notlarınızı yazabilirsiniz..."></textarea>
                        </div>

                        <!-- Cevap Tercihleri -->
                        <div class="mb-4">
                            <label class="form-label fw-bold mb-3">
                                <i class="fas fa-reply me-2"></i>
                                Cevap Tercihleri
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="response_email" value="1" id="response_email" checked>
                                        <label class="form-check-label" for="response_email">
                                            <i class="fas fa-envelope me-2"></i>
                                            E-posta ile bilgilendirme
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="response_sms" value="1" id="response_sms">
                                        <label class="form-check-label" for="response_sms">
                                            <i class="fas fa-sms me-2"></i>
                                            SMS ile bilgilendirme
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gizlilik Onayı -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privacy_consent" value="1" id="privacy_consent" required>
                                <label class="form-check-label" for="privacy_consent">
                                    <strong>Gizlilik sözleşmesini kabul ediyorum.</strong> 
                                    Yüklediğim dosyaların işlenmesine ve AI destekli analiz için kullanılmasına izin veriyorum.
                                    <a href="#" class="text-primary ms-1">Detayları görüntüle</a>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-3 flex-wrap">
                            <button type="submit" class="btn btn-primary btn-lg px-4 flex-fill" id="submit-btn">
                                <i class="fas fa-paper-plane me-2"></i>
                                Yükle & Cevap İste
                            </button>
                            <a href="/" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-arrow-left me-2"></i>
                                Ana Sayfaya Dön
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- İşlem Süreci Bilgisi -->
            <div class="row mt-5">
                <div class="col-12">
                    <h4 class="fw-bold mb-4 text-center">
                        <i class="fas fa-info-circle me-2"></i>
                        İşlem Süreci
                    </h4>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <div class="process-step">
                        <div class="step-number bg-primary text-white mx-auto mb-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold;">1</div>
                        <h6 class="fw-bold">Dosya Yükleme</h6>
                        <p class="text-muted small">Dilekçenizi güvenli bir şekilde sisteme yükleyin</p>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <div class="process-step">
                        <div class="step-number bg-warning text-white mx-auto mb-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold;">2</div>
                        <h6 class="fw-bold">AI Analizi</h6>
                        <p class="text-muted small">Yapay zeka dilekçenizi analiz eder ve değerlendirir</p>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <div class="process-step">
                        <div class="step-number bg-success text-white mx-auto mb-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold;">3</div>
                        <h6 class="fw-bold">Profesyonel Cevap</h6>
                        <p class="text-muted small">Yaklaşık 2-5 dakika içinde detaylı yanıt hazırlanır</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.upload-zone {
    transition: all 0.3s ease;
    cursor: pointer;
    background: #f8f9fa;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.upload-zone:hover {
    background: #e9ecef;
    border-color: #007bff !important;
    transform: translateY(-2px);
}

.upload-zone.dragover {
    background: #e3f2fd;
    border-color: #2196f3 !important;
    transform: scale(1.02);
}

.process-step:hover .step-number {
    transform: scale(1.1);
    transition: all 0.3s ease;
}

#submit-btn:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}
</style>

<script>
// Drag & Drop İşlemleri
function dragOverHandler(ev) {
    ev.preventDefault();
}

function dragEnterHandler(ev) {
    ev.preventDefault();
    ev.target.closest('.upload-zone').classList.add('dragover');
}

function dragLeaveHandler(ev) {
    ev.target.closest('.upload-zone').classList.remove('dragover');
}

function dropHandler(ev) {
    ev.preventDefault();
    ev.target.closest('.upload-zone').classList.remove('dragover');
    
    const files = ev.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('petition-file').files = files;
        handleFileSelect({ target: { files: files } });
    }
}

function handleFileSelect(event) {
    const file = event.target.files[0];
    if (file) {
        // Dosya boyutu kontrolü (10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert('Dosya boyutu 10MB\'dan büyük olamaz.');
            removeFile();
            return;
        }

        // Dosya türü kontrolü
        const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            alert('Geçersiz dosya türü. Lütfen PDF, Word veya resim dosyası seçin.');
            removeFile();
            return;
        }

        // Önizleme göster
        showFilePreview(file);
    }
}

function showFilePreview(file) {
    const placeholder = document.getElementById('upload-placeholder');
    const preview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name-display');
    const fileSize = document.getElementById('file-size-display');
    const fileIcon = preview.querySelector('.file-icon i');

    // Dosya tipine göre ikon
    if (file.type.includes('pdf')) {
        fileIcon.className = 'fas fa-file-pdf fa-3x text-danger';
    } else if (file.type.includes('word')) {
        fileIcon.className = 'fas fa-file-word fa-3x text-primary';
    } else if (file.type.includes('image')) {
        fileIcon.className = 'fas fa-file-image fa-3x text-success';
    }

    fileName.textContent = file.name;
    fileSize.textContent = formatFileSize(file.size);

    placeholder.classList.add('d-none');
    preview.classList.remove('d-none');
}

function removeFile() {
    document.getElementById('petition-file').value = '';
    document.getElementById('upload-placeholder').classList.remove('d-none');
    document.getElementById('file-preview').classList.add('d-none');
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Form Submit
document.getElementById('upload-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submit-btn');
    const originalText = submitBtn.innerHTML;
    
    // Loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Yükleniyor...';
    submitBtn.disabled = true;
    
    // Simülasyon - gerçek uygulamada form data'yı sunucuya gönderin
    setTimeout(function() {
        // Demo response için redirect
        const formData = new FormData(document.getElementById('upload-form'));
        const category = formData.get('category');
        const priority = formData.get('priority');
        const description = formData.get('description') || '';
        
        window.location.href = `/petition-response?category=${encodeURIComponent(category)}&priority=${priority}&description=${encodeURIComponent(description)}`;
    }, 3000);
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>