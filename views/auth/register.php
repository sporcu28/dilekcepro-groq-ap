<?php
$title = 'Kayıt Ol - Dilekçe Uygulaması';
ob_start();
?>

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-4" 
     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="row w-100 justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0" style="border-radius: 15px;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                        <h2 class="fw-bold">Kayıt Ol</h2>
                        <p class="text-muted">Yeni hesap oluşturun</p>
                    </div>

                    <form id="registerForm" action="/api/auth/register" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label">
                                        <i class="fas fa-user me-2"></i>
                                        Ad Soyad *
                                    </label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" 
                                           placeholder="Adınız ve soyadınız" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">
                                        <i class="fas fa-at me-2"></i>
                                        Kullanıcı Adı *
                                    </label>
                                    <input type="text" class="form-control" id="username" name="username" 
                                           placeholder="Benzersiz kullanıcı adı" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-2"></i>
                                        E-posta *
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           placeholder="ornek@email.com" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">
                                        <i class="fas fa-phone me-2"></i>
                                        Telefon
                                    </label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           placeholder="05XX XXX XX XX">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Adres
                            </label>
                            <textarea class="form-control" id="address" name="address" rows="2" 
                                      placeholder="Adres bilginiz (isteğe bağlı)"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>
                                        Şifre *
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" 
                                               name="password" placeholder="En az 6 karakter" required 
                                               minlength="6">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">En az 6 karakter uzunluğunda olmalıdır</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>
                                        Şifre Tekrar *
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password" 
                                               name="confirm_password" placeholder="Şifreyi tekrar girin" required>
                                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Şifre Güvenlik Göstergesi -->
                        <div class="mb-3">
                            <div class="password-strength">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 0%" id="passwordStrength"></div>
                                </div>
                                <small id="passwordStrengthText" class="text-muted">Şifre gücü</small>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                <a href="/terms" target="_blank" class="text-decoration-none">Kullanım şartlarını</a> 
                                ve 
                                <a href="/privacy" target="_blank" class="text-decoration-none">gizlilik politikasını</a> 
                                okudum, kabul ediyorum. *
                            </label>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="newsletter" name="newsletter">
                            <label class="form-check-label" for="newsletter">
                                E-posta ile güncellemeler almak istiyorum
                            </label>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-lg" id="registerBtn">
                                <i class="fas fa-user-plus me-2"></i>
                                Hesap Oluştur
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted">
                                Zaten hesabınız var mı? 
                                <a href="/login" class="text-primary text-decoration-none fw-bold">
                                    Giriş yapın
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    const registerBtn = document.getElementById('registerBtn');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');

    // Şifre görünürlük toggle
    togglePassword.addEventListener('click', function() {
        togglePasswordVisibility(passwordInput, this);
    });

    toggleConfirmPassword.addEventListener('click', function() {
        togglePasswordVisibility(confirmPasswordInput, this);
    });

    function togglePasswordVisibility(input, button) {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        
        const icon = button.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }

    // Şifre gücü kontrolü
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = calculatePasswordStrength(password);
        updatePasswordStrength(strength);
    });

    function calculatePasswordStrength(password) {
        let score = 0;
        if (password.length >= 6) score += 1;
        if (password.length >= 8) score += 1;
        if (/[a-z]/.test(password)) score += 1;
        if (/[A-Z]/.test(password)) score += 1;
        if (/[0-9]/.test(password)) score += 1;
        if (/[^A-Za-z0-9]/.test(password)) score += 1;
        return score;
    }

    function updatePasswordStrength(strength) {
        const progressBar = document.getElementById('passwordStrength');
        const strengthText = document.getElementById('passwordStrengthText');
        
        const strengthLevels = [
            { text: 'Çok Zayıf', color: 'bg-danger', width: '16%' },
            { text: 'Zayıf', color: 'bg-warning', width: '33%' },
            { text: 'Orta', color: 'bg-info', width: '50%' },
            { text: 'İyi', color: 'bg-primary', width: '66%' },
            { text: 'Güçlü', color: 'bg-success', width: '83%' },
            { text: 'Çok Güçlü', color: 'bg-success', width: '100%' }
        ];

        if (strength > 0 && strength <= 6) {
            const level = strengthLevels[strength - 1];
            progressBar.className = `progress-bar ${level.color}`;
            progressBar.style.width = level.width;
            strengthText.textContent = level.text;
            strengthText.className = level.color.replace('bg-', 'text-');
        } else {
            progressBar.style.width = '0%';
            strengthText.textContent = 'Şifre gücü';
            strengthText.className = 'text-muted';
        }
    }

    // Şifre eşleşme kontrolü
    confirmPasswordInput.addEventListener('input', function() {
        if (this.value && passwordInput.value !== this.value) {
            this.setCustomValidity('Şifreler eşleşmiyor');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
        }
    });

    // Kullanıcı adı kontrolü
    const usernameInput = document.getElementById('username');
    usernameInput.addEventListener('input', function() {
        // Sadece harf, rakam ve alt çizgi izin ver
        this.value = this.value.replace(/[^a-zA-Z0-9_]/g, '');
    });

    // Telefon formatı
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function() {
        // Türkiye telefon numarası formatı
        let value = this.value.replace(/\D/g, '');
        if (value.length > 0) {
            if (value.startsWith('90')) {
                value = value.substring(2);
            }
            if (value.startsWith('0')) {
                value = '0' + value.substring(1);
            }
            
            if (value.length <= 11) {
                if (value.length > 7) {
                    value = value.replace(/(\d{4})(\d{3})(\d{2})(\d{2})/, '$1 $2 $3 $4');
                } else if (value.length > 3) {
                    value = value.replace(/(\d{4})(\d{3})/, '$1 $2');
                }
            }
        }
        this.value = value;
    });

    // Form gönderimi
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Şifre eşleşme kontrolü
        if (passwordInput.value !== confirmPasswordInput.value) {
            showToast('Şifreler eşleşmiyor', 'danger');
            return;
        }

        registerBtn.disabled = true;
        registerBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Hesap oluşturuluyor...';
        
        submitForm(this, function(data) {
            // Başarılı kayıt - yönlendirme otomatik olarak yapılacak
        });
        
        // Hata durumunda butonu eski haline getir
        setTimeout(() => {
            registerBtn.disabled = false;
            registerBtn.innerHTML = '<i class="fas fa-user-plus me-2"></i>Hesap Oluştur';
        }, 3000);
    });

    // İlk alana focus
    document.getElementById('full_name').focus();
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>