<?php
$title = 'AI ile Dilekçe Oluştur - Dilekçe Uygulaması';
ob_start();

// Kategorileri al
try {
    $db = \App\Database::getInstance();
    $categories = $db->query("SELECT * FROM petition_categories ORDER BY name");
} catch (Exception $e) {
    $categories = [];
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">
            <i class="fas fa-robot me-2"></i>
            AI ile Dilekçe Oluştur
        </h1>
        <p class="text-muted mb-0">Yapay zeka desteği ile profesyonel dilekçe oluşturun</p>
    </div>
    <a href="/petitions" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        Geri Dön
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-magic me-2"></i>
                    AI Dilekçe Oluşturucu
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>İpucu:</strong> Ne kadar detaylı açıklarsanız, AI o kadar iyi bir dilekçe oluşturabilir. 
                    Konunuzu, talebinizi ve gerekçelerinizi net bir şekilde belirtin.
                </div>

                <form id="aiGenerateForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">
                                    <i class="fas fa-tag me-2"></i>
                                    Kategori
                                </label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">Kategori seçin (isteğe bağlı)</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= htmlspecialchars($category['name']) ?>">
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="priority" class="form-label">
                                    <i class="fas fa-flag me-2"></i>
                                    Öncelik Durumu
                                </label>
                                <select class="form-select" id="priority" name="priority">
                                    <option value="medium">Orta</option>
                                    <option value="low">Düşük</option>
                                    <option value="high">Yüksek</option>
                                    <option value="urgent">Acil</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">
                            <i class="fas fa-heading me-2"></i>
                            Dilekçe Konusu *
                        </label>
                        <input type="text" class="form-control form-control-lg" id="subject" name="subject" 
                               placeholder="Dilekçenizin konusunu kısaca belirtin" required maxlength="200">
                        <div class="form-text">
                            Örnek: "İzin talebi", "Maaş artışı talebi", "İş değişikliği başvurusu"
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="details" class="form-label">
                            <i class="fas fa-align-left me-2"></i>
                            Detaylar ve Açıklamalar
                        </label>
                        <textarea class="form-control" id="details" name="details" rows="6" 
                                  placeholder="Dilekçenizle ilgili detayları buraya yazın..."></textarea>
                        <div class="form-text">
                            • Neyi talep ediyorsunuz?<br>
                            • Neden bu talepte bulunuyorsunuz?<br>
                            • Hangi tarihler/süreler söz konusu?<br>
                            • Varsa ek bilgiler
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tone" class="form-label">
                                    <i class="fas fa-user-tie me-2"></i>
                                    Dilekçe Tonu
                                </label>
                                <select class="form-select" id="tone" name="tone">
                                    <option value="formal">Resmi ve Profesyonel</option>
                                    <option value="respectful">Saygılı ve Mütevazı</option>
                                    <option value="assertive">Kararlı ve Net</option>
                                    <option value="urgent">Acil ve Önemli</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="length" class="form-label">
                                    <i class="fas fa-ruler me-2"></i>
                                    Dilekçe Uzunluğu
                                </label>
                                <select class="form-select" id="length" name="length">
                                    <option value="medium">Orta (Önerilen)</option>
                                    <option value="short">Kısa ve Öz</option>
                                    <option value="long">Detaylı ve Uzun</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="includePersonalInfo" name="include_personal_info" checked>
                            <label class="form-check-label" for="includePersonalInfo">
                                Kişisel bilgilerimi (ad, soyad) dilekçeye dahil et
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex">
                        <button type="submit" class="btn btn-success btn-lg flex-fill" id="generateBtn">
                            <i class="fas fa-magic me-2"></i>
                            AI ile Dilekçe Oluştur
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="clearForm()">
                            <i class="fas fa-eraser me-2"></i>
                            Temizle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- AI İpuçları -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    AI Dilekçe İpuçları
                </h6>
            </div>
            <div class="card-body">
                <div class="tips">
                    <div class="tip-item mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <small>
                            <strong>Spesifik olun:</strong> "İzin istiyorum" yerine "15-20 Mart tarihleri arasında yıllık izin kullanmak istiyorum" deyin.
                        </small>
                    </div>
                    
                    <div class="tip-item mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <small>
                            <strong>Gerekçe belirtin:</strong> Talebinizin nedenini açıklayın. Bu, dilekçenizi daha güçlü kılar.
                        </small>
                    </div>
                    
                    <div class="tip-item mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <small>
                            <strong>Tarih bilgisi:</strong> Eğer tarihle ilgili bir talep ise, başlangıç ve bitiş tarihlerini belirtin.
                        </small>
                    </div>
                    
                    <div class="tip-item mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <small>
                            <strong>Kısa ve öz:</strong> Gereksiz detaylardan kaçının, sadece önemli bilgileri verin.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Örnek Konular -->
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-examples me-2"></i>
                    Örnek Konular
                </h6>
            </div>
            <div class="card-body">
                <div class="example-subjects">
                    <button class="btn btn-sm btn-outline-primary mb-2 w-100 text-start" 
                            onclick="fillExample('İzin Talebi', '15-20 Mart tarihleri arasında yıllık izin kullanmak istiyorum. Aile ziyareti için bu tarihlerde izin alabilir miyim?')">
                        <i class="fas fa-calendar me-2"></i>İzin Talebi
                    </button>
                    
                    <button class="btn btn-sm btn-outline-primary mb-2 w-100 text-start" 
                            onclick="fillExample('Uzaktan Çalışma Talebi', 'Sağlık sorunları nedeniyle haftada 2 gün uzaktan çalışma imkanı talep ediyorum.')">
                        <i class="fas fa-home me-2"></i>Uzaktan Çalışma
                    </button>
                    
                    <button class="btn btn-sm btn-outline-primary mb-2 w-100 text-start" 
                            onclick="fillExample('Eğitim Desteği Talebi', 'Mesleki gelişimim için XYZ sertifika programına katılmak istiyorum. Eğitim desteği alabilir miyim?')">
                        <i class="fas fa-graduation-cap me-2"></i>Eğitim Desteği
                    </button>
                    
                    <button class="btn btn-sm btn-outline-primary mb-2 w-100 text-start" 
                            onclick="fillExample('Şikayet', 'Ofis ortamındaki gürültü problemi nedeniyle çalışma verimliliğim etkileniyor. Bu konuda çözüm bulunmasını talep ediyorum.')">
                        <i class="fas fa-exclamation-triangle me-2"></i>Şikayet
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AI Sonuç Modal -->
<div class="modal fade" id="aiResultModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-robot me-2"></i>
                    AI Tarafından Oluşturulan Dilekçe
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="aiResult"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Kapat
                </button>
                <button type="button" class="btn btn-warning" onclick="regeneratePetition()">
                    <i class="fas fa-redo me-2"></i>
                    Yeniden Oluştur
                </button>
                <button type="button" class="btn btn-success" onclick="savePetition()">
                    <i class="fas fa-save me-2"></i>
                    Dilekçeyi Kaydet
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let generatedPetition = null;

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('aiGenerateForm');
    const generateBtn = document.getElementById('generateBtn');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const subject = document.getElementById('subject').value.trim();
        if (!subject) {
            showToast('Lütfen dilekçe konusunu belirtin', 'warning');
            return;
        }

        generateBtn.disabled = true;
        generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>AI dilekçe oluşturuyor...';

        const formData = new FormData(this);
        formData.append('csrf_token', csrfToken);

        fetch('/api/ai/generate-petition', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                generatedPetition = data;
                showAIResult(data);
            } else {
                showToast(data.error || 'AI dilekçe oluşturma hatası', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Bağlantı hatası oluştu', 'danger');
        })
        .finally(() => {
            generateBtn.disabled = false;
            generateBtn.innerHTML = '<i class="fas fa-magic me-2"></i>AI ile Dilekçe Oluştur';
        });
    });
});

function showAIResult(data) {
    const resultDiv = document.getElementById('aiResult');
    
    resultDiv.innerHTML = `
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Harika!</strong> AI tarafından dilekçeniz başarıyla oluşturuldu.
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"><strong>Dilekçe Başlığı:</strong></label>
                    <input type="text" class="form-control" id="generatedTitle" value="${data.title}" maxlength="200">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label"><strong>Kategori:</strong></label>
                    <select class="form-select" id="generatedCategory">
                        <option value="">Seçin</option>
                        ${document.getElementById('category').innerHTML}
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label"><strong>Öncelik:</strong></label>
                    <select class="form-select" id="generatedPriority">
                        <option value="low">Düşük</option>
                        <option value="medium" selected>Orta</option>
                        <option value="high">Yüksek</option>
                        <option value="urgent">Acil</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="mb-3">
            <label class="form-label"><strong>Dilekçe İçeriği:</strong></label>
            <textarea class="form-control" id="generatedContent" rows="15">${data.content}</textarea>
        </div>
        
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Dilekçenizi kaydetmeden önce istediğiniz gibi düzenleyebilirsiniz.
        </div>
    `;
    
    // Kategori seçimini ayarla
    const categorySelect = document.getElementById('generatedCategory');
    const originalCategory = document.getElementById('category').value;
    if (originalCategory) {
        categorySelect.value = originalCategory;
    }
    
    // Öncelik seçimini ayarla
    const prioritySelect = document.getElementById('generatedPriority');
    const originalPriority = document.getElementById('priority').value;
    if (originalPriority) {
        prioritySelect.value = originalPriority;
    }
    
    // Modal'ı göster
    const modal = new bootstrap.Modal(document.getElementById('aiResultModal'));
    modal.show();
}

function regeneratePetition() {
    // Form verilerini tekrar gönder
    document.getElementById('aiGenerateForm').dispatchEvent(new Event('submit'));
}

function savePetition() {
    const title = document.getElementById('generatedTitle').value.trim();
    const content = document.getElementById('generatedContent').value.trim();
    const category = document.getElementById('generatedCategory').value;
    const priority = document.getElementById('generatedPriority').value;

    if (!title || !content) {
        showToast('Başlık ve içerik boş olamaz', 'warning');
        return;
    }

    const saveBtn = document.querySelector('#aiResultModal .btn-success');
    const originalText = saveBtn.innerHTML;
    saveBtn.disabled = true;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Kaydediliyor...';

    const formData = new FormData();
    formData.append('title', title);
    formData.append('content', content);
    formData.append('category_id', category);
    formData.append('priority', priority);
    formData.append('ai_generated', '1');
    formData.append('csrf_token', csrfToken);

    fetch('/api/petitions/create', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message || 'Dilekçe başarıyla kaydedildi', 'success');
            
            // Modal'ı kapat
            bootstrap.Modal.getInstance(document.getElementById('aiResultModal')).hide();
            
            // Formu temizle
            clearForm();
            
            // 2 saniye sonra dilekçelere yönlendir
            setTimeout(() => {
                window.location.href = '/petitions';
            }, 2000);
        } else {
            showToast(data.error || 'Kaydetme hatası', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Bağlantı hatası oluştu', 'danger');
    })
    .finally(() => {
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalText;
    });
}

function fillExample(subject, details) {
    document.getElementById('subject').value = subject;
    document.getElementById('details').value = details;
    
    // Konuya göre kategori seç
    const categoryMap = {
        'İzin Talebi': 'İzin Talebi',
        'Uzaktan Çalışma Talebi': 'İnsan Kaynakları',
        'Eğitim Desteği Talebi': 'İnsan Kaynakları',
        'Şikayet': 'Şikayet'
    };
    
    const categorySelect = document.getElementById('category');
    const categoryName = categoryMap[subject];
    if (categoryName) {
        for (let option of categorySelect.options) {
            if (option.text === categoryName) {
                option.selected = true;
                break;
            }
        }
    }
    
    // Subject alanına odaklan
    document.getElementById('subject').focus();
    showToast('Örnek konu dolduruldu. İstediğiniz gibi düzenleyebilirsiniz.', 'info');
}

function clearForm() {
    document.getElementById('aiGenerateForm').reset();
    document.getElementById('priority').value = 'medium';
    document.getElementById('tone').value = 'formal';
    document.getElementById('length').value = 'medium';
    document.getElementById('includePersonalInfo').checked = true;
}

// Karakter sayacı
document.getElementById('subject').addEventListener('input', function() {
    const current = this.value.length;
    const max = this.getAttribute('maxlength');
    
    // Karakter sayacı ekle/güncelle
    let counter = this.parentElement.querySelector('.char-counter');
    if (!counter) {
        counter = document.createElement('small');
        counter.className = 'char-counter text-muted float-end';
        this.parentElement.appendChild(counter);
    }
    
    counter.textContent = `${current}/${max}`;
    counter.className = current > max * 0.9 ? 'char-counter text-warning float-end' : 'char-counter text-muted float-end';
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>