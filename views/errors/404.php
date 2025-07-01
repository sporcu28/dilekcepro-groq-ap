<?php
$title = '404 - Sayfa Bulunamadı';
ob_start();
?>

<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-8 col-lg-6 text-center">
            <div class="error-page">
                <div class="error-number mb-4">
                    <h1 style="font-size: 8rem; font-weight: bold; color: #e74c3c; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
                        404
                    </h1>
                </div>
                
                <div class="error-icon mb-4">
                    <i class="fas fa-search fa-4x text-muted"></i>
                </div>
                
                <h2 class="h3 mb-3">Sayfa Bulunamadı</h2>
                <p class="lead text-muted mb-4">
                    Aradığınız sayfa mevcut değil veya taşınmış olabilir.
                </p>
                
                <div class="error-actions">
                    <a href="/" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-home me-2"></i>
                        Ana Sayfaya Dön
                    </a>
                    
                    <?php if (isset($currentUser)): ?>
                        <a href="/dashboard" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                    <?php else: ?>
                        <a href="/login" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Giriş Yap
                        </a>
                    <?php endif; ?>
                </div>
                
                <div class="mt-5">
                    <p class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        Eğer bu sayfanın var olması gerektiğini düşünüyorsanız, 
                        lütfen sistem yöneticisine başvurun.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-page {
    padding: 2rem;
}

.error-number h1 {
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

.error-icon i {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>