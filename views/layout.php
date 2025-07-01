<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dilekçe Uygulaması' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --dark-color: #34495e;
            --light-bg: #ecf0f1;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
        }

        .navbar-brand {
            font-weight: bold;
            color: var(--primary-color) !important;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--primary-color), var(--dark-color));
            min-height: calc(100vh - 76px);
            padding-top: 1rem;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 0.5rem;
        }

        .main-content {
            padding: 2rem;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--secondary-color), #5dade2);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--secondary-color), #5dade2);
            border: none;
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color), #58d68d);
            border: none;
            border-radius: 25px;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color), #f7dc6f);
            border: none;
            border-radius: 25px;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), #ec7063);
            border: none;
            border-radius: 25px;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-draft {
            background-color: #6c757d;
            color: white;
        }

        .status-submitted {
            background-color: var(--secondary-color);
            color: white;
        }

        .status-in_review {
            background-color: var(--warning-color);
            color: white;
        }

        .status-approved {
            background-color: var(--success-color);
            color: white;
        }

        .status-rejected {
            background-color: var(--danger-color);
            color: white;
        }

        .status-completed {
            background-color: #17a2b8;
            color: white;
        }

        .priority-urgent {
            color: var(--danger-color);
            font-weight: bold;
        }

        .priority-high {
            color: var(--warning-color);
            font-weight: bold;
        }

        .priority-medium {
            color: var(--secondary-color);
        }

        .priority-low {
            color: #6c757d;
        }

        .ai-badge {
            background: linear-gradient(135deg, #8e44ad, #9b59b6);
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1055;
        }

        .footer {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
            
            .main-content {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="fas fa-file-signature"></i>
                Dilekçe Uygulaması
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($currentUser)): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i>
                                <?= htmlspecialchars($currentUser['full_name']) ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/profile"><i class="fas fa-user"></i> Profil</a></li>
                                <li><a class="dropdown-item" href="/settings"><i class="fas fa-cog"></i> Ayarlar</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Giriş Yap</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register">Kayıt Ol</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <?php if (isset($currentUser)): ?>
                <!-- Sidebar -->
                <div class="col-md-3 col-lg-2 px-0">
                    <div class="sidebar">
                        <nav class="nav flex-column px-3">
                            <a class="nav-link" href="/dashboard">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                            <a class="nav-link" href="/petitions">
                                <i class="fas fa-file-alt"></i>
                                Dilekçelerim
                            </a>
                            <a class="nav-link" href="/petitions/create">
                                <i class="fas fa-plus-circle"></i>
                                Yeni Dilekçe
                            </a>
                            <a class="nav-link" href="/petitions/ai-generate">
                                <i class="fas fa-robot"></i>
                                AI ile Oluştur
                            </a>
                            <?php if ($currentUser['role'] === 'admin'): ?>
                                <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">
                                <a class="nav-link" href="/admin">
                                    <i class="fas fa-users-cog"></i>
                                    Yönetim Paneli
                                </a>
                                <a class="nav-link" href="/admin/petitions">
                                    <i class="fas fa-list"></i>
                                    Tüm Dilekçeler
                                </a>
                                <a class="nav-link" href="/admin/users">
                                    <i class="fas fa-users"></i>
                                    Kullanıcılar
                                </a>
                                <a class="nav-link" href="/admin/categories">
                                    <i class="fas fa-tags"></i>
                                    Kategoriler
                                </a>
                            <?php endif; ?>
                        </nav>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="col-md-9 col-lg-10">
                    <div class="main-content">
                        <?= $content ?>
                    </div>
                </div>
            <?php else: ?>
                <!-- Guest Content -->
                <div class="col-12">
                    <?= $content ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container"></div>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2024 Dilekçe Uygulaması. Tüm hakları saklıdır.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // CSRF Token
        const csrfToken = '<?= $_SESSION['csrf_token'] ?? '' ?>';
        
        // Toast gösterme fonksiyonu
        function showToast(message, type = 'info') {
            const toastContainer = document.querySelector('.toast-container');
            const toastId = 'toast-' + Date.now();
            
            const toastHtml = `
                <div class="toast" id="${toastId}" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-${type} text-white">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong class="me-auto">Bildirim</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;
            
            toastContainer.insertAdjacentHTML('beforeend', toastHtml);
            
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
            
            // Toast kapandığında DOM'dan kaldır
            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }
        
        // Form gönderme fonksiyonu
        function submitForm(formElement, successCallback) {
            const formData = new FormData(formElement);
            formData.append('csrf_token', csrfToken);
            
            fetch(formElement.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.message) {
                        showToast(data.message, 'success');
                    }
                    if (successCallback) {
                        successCallback(data);
                    } else if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                } else {
                    showToast(data.error || 'Bir hata oluştu', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Bağlantı hatası oluştu', 'danger');
            });
        }
        
        // Aktif menü öğesini işaretle
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>