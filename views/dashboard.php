<?php
$title = 'Dashboard - Dilekçe Uygulaması';
ob_start();

// Status çevirileri
$statusLabels = [
    'draft' => 'Taslak',
    'submitted' => 'Gönderildi',
    'in_review' => 'İnceleniyor',
    'approved' => 'Onaylandı',
    'rejected' => 'Reddedildi',
    'completed' => 'Tamamlandı'
];

$priorityLabels = [
    'low' => 'Düşük',
    'medium' => 'Orta',
    'high' => 'Yüksek',
    'urgent' => 'Acil'
];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">
            <i class="fas fa-tachometer-alt me-2"></i>
            Dashboard
        </h1>
        <p class="text-muted mb-0">Hoş geldiniz, <?= htmlspecialchars($user['full_name']) ?>!</p>
    </div>
    <div>
        <a href="/petitions/create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Yeni Dilekçe
        </a>
        <a href="/petitions/ai-generate" class="btn btn-success">
            <i class="fas fa-robot me-2"></i>
            AI ile Oluştur
        </a>
    </div>
</div>

<!-- İstatistik Kartları -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-file-alt fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="card-title text-muted mb-1">Toplam Dilekçe</h6>
                        <h3 class="mb-0"><?= $stats['total'] ?? 0 ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="card-title text-muted mb-1">Bekleyen</h6>
                        <h3 class="mb-0"><?= ($stats['submitted'] ?? 0) + ($stats['in_review'] ?? 0) ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="card-title text-muted mb-1">Onaylanan</h6>
                        <h3 class="mb-0"><?= $stats['approved'] ?? 0 ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-robot fa-2x text-info"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="card-title text-muted mb-1">AI Destekli</h6>
                        <h3 class="mb-0"><?= $stats['ai_generated'] ?? 0 ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Son Dilekçeler -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>
                    Son Dilekçelerim
                </h5>
                <a href="/petitions" class="btn btn-sm btn-outline-primary">
                    Tümünü Gör
                    <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body">
                <?php if (empty($recentPetitions)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Henüz dilekçeniz bulunmuyor</h5>
                        <p class="text-muted mb-3">İlk dilekçenizi oluşturarak başlayın</p>
                        <a href="/petitions/create" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Yeni Dilekçe Oluştur
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Başlık</th>
                                    <th>Kategori</th>
                                    <th>Durum</th>
                                    <th>Öncelik</th>
                                    <th>Tarih</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentPetitions as $petition): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if ($petition['ai_generated']): ?>
                                                    <span class="ai-badge me-2">AI</span>
                                                <?php endif; ?>
                                                <div>
                                                    <h6 class="mb-0"><?= htmlspecialchars($petition['title']) ?></h6>
                                                    <small class="text-muted">
                                                        Ref: <?= htmlspecialchars($petition['reference_number']) ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($petition['category_name']): ?>
                                                <span class="badge bg-light text-dark">
                                                    <i class="<?= $petition['category_icon'] ?? 'fas fa-tag' ?> me-1"></i>
                                                    <?= htmlspecialchars($petition['category_name']) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">Kategori yok</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?= $petition['status'] ?>">
                                                <?= $statusLabels[$petition['status']] ?? $petition['status'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="priority-<?= $petition['priority'] ?>">
                                                <i class="fas fa-flag me-1"></i>
                                                <?= $priorityLabels[$petition['priority']] ?? $petition['priority'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= date('d.m.Y H:i', strtotime($petition['created_at'])) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="/petitions/<?= $petition['id'] ?>" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if ($petition['status'] === 'draft'): ?>
                                                    <a href="/petitions/<?= $petition['id'] ?>/edit" 
                                                       class="btn btn-outline-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Hızlı İşlemler -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Hızlı İşlemler
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="/petitions/create" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Yeni Dilekçe Oluştur
                    </a>
                    <a href="/petitions/ai-generate" class="btn btn-success">
                        <i class="fas fa-robot me-2"></i>
                        AI ile Dilekçe Oluştur
                    </a>
                    <a href="/petitions" class="btn btn-outline-secondary">
                        <i class="fas fa-list me-2"></i>
                        Tüm Dilekçelerim
                    </a>
                    <button class="btn btn-outline-info" onclick="checkPetitionStatus()">
                        <i class="fas fa-search me-2"></i>
                        Durum Sorgula
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Durum Dağılımı -->
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Durum Dağılımı
                </h5>
            </div>
            <div class="card-body">
                <?php 
                $statusData = [
                    'draft' => ['label' => 'Taslak', 'color' => 'secondary', 'icon' => 'fas fa-edit'],
                    'submitted' => ['label' => 'Gönderildi', 'color' => 'primary', 'icon' => 'fas fa-paper-plane'],
                    'in_review' => ['label' => 'İnceleniyor', 'color' => 'warning', 'icon' => 'fas fa-eye'],
                    'approved' => ['label' => 'Onaylandı', 'color' => 'success', 'icon' => 'fas fa-check'],
                    'rejected' => ['label' => 'Reddedildi', 'color' => 'danger', 'icon' => 'fas fa-times'],
                    'completed' => ['label' => 'Tamamlandı', 'color' => 'info', 'icon' => 'fas fa-flag-checkered']
                ];
                
                foreach ($statusData as $status => $data):
                    $count = $stats[$status] ?? 0;
                    if ($count > 0):
                ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <i class="<?= $data['icon'] ?> text-<?= $data['color'] ?> me-2"></i>
                            <span><?= $data['label'] ?></span>
                        </div>
                        <span class="badge bg-<?= $data['color'] ?>"><?= $count ?></span>
                    </div>
                <?php 
                    endif;
                endforeach; 
                
                if (empty(array_filter($stats ?? []))): 
                ?>
                    <div class="text-center text-muted">
                        <i class="fas fa-chart-pie fa-2x mb-2"></i>
                        <p class="mb-0">Henüz veri bulunmuyor</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Durum Sorgulama Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-search me-2"></i>
                    Dilekçe Durum Sorgulama
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="statusCheckForm">
                    <div class="mb-3">
                        <label for="referenceNumber" class="form-label">Referans Numarası</label>
                        <input type="text" class="form-control" id="referenceNumber" 
                               placeholder="DLK-202401-0001" required>
                        <div class="form-text">
                            Dilekçenizin referans numarasını girin (örn: DLK-202401-0001)
                        </div>
                    </div>
                </form>
                <div id="statusResult" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary" onclick="searchPetition()">
                    <i class="fas fa-search me-2"></i>
                    Sorgula
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function checkPetitionStatus() {
    const modal = new bootstrap.Modal(document.getElementById('statusModal'));
    modal.show();
}

function searchPetition() {
    const referenceNumber = document.getElementById('referenceNumber').value.trim();
    const resultDiv = document.getElementById('statusResult');
    
    if (!referenceNumber) {
        showToast('Lütfen referans numarası girin', 'warning');
        return;
    }
    
    resultDiv.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Aranıyor...</div>';
    
    fetch(`/api/petitions/search?ref=${encodeURIComponent(referenceNumber)}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.petition) {
            const petition = data.petition;
            const statusLabel = {
                'draft': 'Taslak',
                'submitted': 'Gönderildi', 
                'in_review': 'İnceleniyor',
                'approved': 'Onaylandı',
                'rejected': 'Reddedildi',
                'completed': 'Tamamlandı'
            }[petition.status] || petition.status;
            
            resultDiv.innerHTML = `
                <div class="alert alert-success">
                    <h6 class="alert-heading">Dilekçe Bulundu</h6>
                    <p class="mb-2"><strong>Başlık:</strong> ${petition.title}</p>
                    <p class="mb-2"><strong>Durum:</strong> 
                        <span class="status-badge status-${petition.status}">${statusLabel}</span>
                    </p>
                    <p class="mb-0"><strong>Tarih:</strong> ${new Date(petition.created_at).toLocaleDateString('tr-TR')}</p>
                    <hr>
                    <a href="/petitions/${petition.id}" class="btn btn-sm btn-primary">Detayları Görüntüle</a>
                </div>
            `;
        } else {
            resultDiv.innerHTML = `
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Bu referans numarasına ait dilekçe bulunamadı.
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        resultDiv.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-times me-2"></i>
                Sorgulama sırasında bir hata oluştu.
            </div>
        `;
    });
}

// Sayfa yüklendiğinde animasyonlar
document.addEventListener('DOMContentLoaded', function() {
    // Kartlara hover animasyonu ekle
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>