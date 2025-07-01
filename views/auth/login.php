<?php
$title = 'Giriş Yap - Dilekçe Uygulaması';
ob_start();
?>

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" 
     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="row w-100 justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg border-0" style="border-radius: 15px;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-file-signature fa-3x text-primary mb-3"></i>
                        <h2 class="fw-bold">Giriş Yap</h2>
                        <p class="text-muted">Hesabınıza giriş yapın</p>
                    </div>

                    <form id="loginForm" action="/api/auth/login" method="POST">
                        <div class="mb-3">
                            <label for="login" class="form-label">
                                <i class="fas fa-user me-2"></i>
                                Kullanıcı Adı / E-posta
                            </label>
                            <input type="text" class="form-control form-control-lg" id="login" name="login" 
                                   placeholder="Kullanıcı adınız veya e-posta adresiniz" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>
                                Şifre
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg" id="password" 
                                       name="password" placeholder="Şifreniz" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe" name="remember_me">
                            <label class="form-check-label" for="rememberMe">
                                Beni hatırla
                            </label>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-lg" id="loginBtn">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Giriş Yap
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-2">
                                <a href="/forgot-password" class="text-decoration-none">
                                    Şifremi unuttum
                                </a>
                            </p>
                            <p class="text-muted">
                                Hesabınız yok mu? 
                                <a href="/register" class="text-primary text-decoration-none fw-bold">
                                    Kayıt olun
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Demo Kullanıcılar -->
            <div class="card mt-4 border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-center mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Demo Hesapları
                    </h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <button class="btn btn-outline-primary btn-sm w-100" onclick="fillDemo('admin')">
                                <i class="fas fa-user-shield me-1"></i>
                                Admin
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-success btn-sm w-100" onclick="fillDemo('user')">
                                <i class="fas fa-user me-1"></i>
                                Kullanıcı
                            </button>
                        </div>
                    </div>
                    <small class="text-muted d-block text-center mt-2">
                        Test için demo hesapları kullanabilirsiniz
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    // Şifre görünürlük toggle
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

    // Form gönderimi
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        loginBtn.disabled = true;
        loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Giriş yapılıyor...';
        
        submitForm(this, function(data) {
            // Başarılı giriş - yönlendirme otomatik olarak yapılacak
        });
        
        // Hata durumunda butonu eski haline getir
        setTimeout(() => {
            loginBtn.disabled = false;
            loginBtn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Giriş Yap';
        }, 3000);
    });

    // Sayfa yüklendiğinde email alanına focus
    document.getElementById('login').focus();
});

// Demo hesap bilgilerini doldur
function fillDemo(type) {
    const loginInput = document.getElementById('login');
    const passwordInput = document.getElementById('password');
    
    if (type === 'admin') {
        loginInput.value = 'admin';
        passwordInput.value = 'admin123';
    } else {
        loginInput.value = 'test@example.com';
        passwordInput.value = 'test123';
    }
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>