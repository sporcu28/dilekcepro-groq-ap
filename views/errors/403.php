<?php
$title = '403 - Erişim Reddedildi';
ob_start();
?>

<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-8 col-lg-6 text-center">
            <div class="error-page">
                <div class="error-number mb-4">
                    <h1 style="font-size: 8rem; font-weight: bold; color: #f39c12; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
                        403
                    </h1>
                </div>
                
                <div class="error-icon mb-4">
                    <i class="fas fa-lock fa-4x text-warning"></i>
                </div>
                
                <h2 class="h3 mb-3">Erişim Reddedildi</h2>
                <p class="lead text-muted mb-4">
                    Bu sayfaya erişim yetkiniz bulunmamaktadır.
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
                        Yetki ile ilgili sorunlarınız için sistem yöneticisine başvurun.
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
    animation: shake 0.5s ease-in-out infinite alternate;
}

@keyframes shake {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(5px);
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