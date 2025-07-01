<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Database;

// .env dosyasını yükle
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

// Session başlat
session_start();

// CSRF token oluştur
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Basit routing sistemi
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Static dosyalar için
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|ico)$/', $path)) {
    return false;
}

// CORS headers (geliştirme için)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Helper fonksiyonlar
function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function getCurrentUser(): ?array {
    if (!isLoggedIn()) {
        return null;
    }
    
    try {
        $userModel = new \App\Models\User();
        return $userModel->findById($_SESSION['user_id']);
    } catch (Exception $e) {
        return null;
    }
}

function requireAuth(): void {
    if (!isLoggedIn()) {
        if (isAjaxRequest()) {
            http_response_code(401);
            echo json_encode(['error' => 'Oturum açmanız gerekiyor']);
            exit;
        } else {
            header('Location: /login');
            exit;
        }
    }
}

function requireRole(string $role): void {
    requireAuth();
    $user = getCurrentUser();
    if (!$user || $user['role'] !== $role) {
        http_response_code(403);
        if (isAjaxRequest()) {
            echo json_encode(['error' => 'Yetkiniz yok']);
        } else {
            echo '<h1>403 - Yetkiniz Yok</h1>';
        }
        exit;
    }
}

function isAjaxRequest(): bool {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

function validateCsrfToken(): bool {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return true;
    
    $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    return hash_equals($_SESSION['csrf_token'], $token);
}

function redirect(string $url): void {
    header("Location: $url");
    exit;
}

function renderView(string $view, array $data = []): void {
    extract($data);
    $currentUser = getCurrentUser();
    $viewFile = __DIR__ . "/../views/$view.php";
    
    if (!file_exists($viewFile)) {
        echo "View file not found: $viewFile";
        exit;
    }
    
    try {
        include $viewFile;
    } catch (Throwable $e) {
        echo "Error rendering view: " . $e->getMessage();
        echo "<br>File: " . $e->getFile();
        echo "<br>Line: " . $e->getLine();
        exit;
    }
}

function jsonResponse(array $data, int $httpCode = 200): void {
    http_response_code($httpCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}



// Route tanımları
$routes = [
    'GET' => [
        '/' => function() {
            renderView('home');
        },
        '/login' => function() {
            if (isLoggedIn()) {
                redirect('/dashboard');
            }
            renderView('auth/login');
        },
        '/register' => function() {
            if (isLoggedIn()) {
                redirect('/dashboard');
            }
            renderView('auth/register');
        },
        '/dashboard' => function() {
            requireAuth();
            $user = getCurrentUser();
            
            $petitionModel = new \App\Models\Petition();
            $recentPetitions = $petitionModel->getByUserId($user['id'], 5);
            $stats = $petitionModel->getStatistics();
            
            renderView('dashboard', [
                'user' => $user,
                'recentPetitions' => $recentPetitions,
                'stats' => $stats
            ]);
        },
        '/petitions' => function() {
            requireAuth();
            $user = getCurrentUser();
            
            $page = (int)($_GET['page'] ?? 1);
            $limit = 10;
            $offset = ($page - 1) * $limit;
            
            $petitionModel = new \App\Models\Petition();
            $petitions = $petitionModel->getByUserId($user['id'], $limit, $offset);
            
            renderView('petitions/index', [
                'petitions' => $petitions,
                'currentPage' => $page
            ]);
        },
        '/petitions/create' => function() {
            requireAuth();
            renderView('petitions/create');
        },
        '/petitions/ai-generate' => function() {
            requireAuth();
            renderView('petitions/ai-generate');
        },
        '/ai-generate' => function() {
            renderView('petitions/ai-generate');
        },
        '/upload-petition' => function() {
            renderView('petitions/upload-petition');
        },
        '/petition-response' => function() {
            renderView('petitions/petition-response');
        },
        '/admin' => function() {
            requireRole('admin');
            
            $petitionModel = new \App\Models\Petition();
            $userModel = new \App\Models\User();
            
            $stats = $petitionModel->getStatistics();
            $recentPetitions = $petitionModel->getRecentPetitions(10);
            $userCount = $userModel->getTotalCount();
            
            renderView('admin/dashboard', [
                'stats' => $stats,
                'recentPetitions' => $recentPetitions,
                'userCount' => $userCount
            ]);
        },
        '/logout' => function() {
            session_destroy();
            redirect('/');
        }
    ],
    'POST' => [
        '/api/auth/login' => function() {
            if (!validateCsrfToken()) {
                jsonResponse(['error' => 'Geçersiz CSRF token'], 400);
            }
            
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($login) || empty($password)) {
                jsonResponse(['error' => 'Kullanıcı adı/e-posta ve şifre gerekli'], 400);
            }
            
            $userModel = new \App\Models\User();
            $user = $userModel->authenticate($login, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];
                jsonResponse(['success' => true, 'redirect' => '/dashboard']);
            } else {
                jsonResponse(['error' => 'Geçersiz kullanıcı bilgileri'], 401);
            }
        },
        '/api/auth/register' => function() {
            if (!validateCsrfToken()) {
                jsonResponse(['error' => 'Geçersiz CSRF token'], 400);
            }
            
            $data = [
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'full_name' => $_POST['full_name'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'address' => $_POST['address'] ?? ''
            ];
            
            // Basit validasyon
            if (empty($data['username']) || empty($data['email']) || empty($data['password']) || empty($data['full_name'])) {
                jsonResponse(['error' => 'Gerekli alanları doldurun'], 400);
            }
            
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                jsonResponse(['error' => 'Geçerli bir e-posta adresi girin'], 400);
            }
            
            if (strlen($data['password']) < 6) {
                jsonResponse(['error' => 'Şifre en az 6 karakter olmalı'], 400);
            }
            
            try {
                $userModel = new \App\Models\User();
                
                // E-posta kontrolü
                if ($userModel->findByEmail($data['email'])) {
                    jsonResponse(['error' => 'Bu e-posta adresi zaten kullanılıyor'], 400);
                }
                
                // Kullanıcı adı kontrolü
                if ($userModel->findByUsername($data['username'])) {
                    jsonResponse(['error' => 'Bu kullanıcı adı zaten kullanılıyor'], 400);
                }
                
                $userId = $userModel->create($data);
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_role'] = 'user';
                
                jsonResponse(['success' => true, 'redirect' => '/dashboard']);
                
            } catch (Exception $e) {
                jsonResponse(['error' => 'Kayıt hatası: ' . $e->getMessage()], 500);
            }
        },
        '/api/petitions/create' => function() {
            requireAuth();
            
            if (!validateCsrfToken()) {
                jsonResponse(['error' => 'Geçersiz CSRF token'], 400);
            }
            
            $data = [
                'user_id' => $_SESSION['user_id'],
                'category_id' => $_POST['category_id'] ?? null,
                'title' => $_POST['title'] ?? '',
                'content' => $_POST['content'] ?? '',
                'priority' => $_POST['priority'] ?? 'medium',
                'status' => $_POST['save_as_draft'] ? 'draft' : 'submitted',
                'ai_generated' => (bool)($_POST['ai_generated'] ?? false)
            ];
            
            if (empty($data['title']) || empty($data['content'])) {
                jsonResponse(['error' => 'Başlık ve içerik gerekli'], 400);
            }
            
            try {
                $petitionModel = new \App\Models\Petition();
                $petitionId = $petitionModel->create($data);
                
                jsonResponse([
                    'success' => true,
                    'petition_id' => $petitionId,
                    'message' => $data['status'] === 'draft' ? 'Dilekçe taslak olarak kaydedildi' : 'Dilekçe başarıyla gönderildi'
                ]);
                
            } catch (Exception $e) {
                jsonResponse(['error' => 'Dilekçe oluşturma hatası: ' . $e->getMessage()], 500);
            }
        },
        '/api/ai/generate-petition' => function() {
            requireAuth();
            
            if (!validateCsrfToken()) {
                jsonResponse(['error' => 'Geçersiz CSRF token'], 400);
            }
            
            $subject = $_POST['subject'] ?? '';
            $category = $_POST['category'] ?? '';
            
            if (empty($subject)) {
                jsonResponse(['error' => 'Konu belirtilmelidir'], 400);
            }
            
            try {
                $user = getCurrentUser();
                $aiService = new \App\Services\AIService();
                $result = $aiService->generatePetition($subject, $category, $user);
                
                jsonResponse($result);
                
            } catch (Exception $e) {
                jsonResponse(['error' => 'AI servis hatası: ' . $e->getMessage()], 500);
            }
        },
        '/api/download/pdf' => function() {
            $referenceNumber = $_POST['reference_number'] ?? '';
            $category = $_POST['category'] ?? '';
            $priority = $_POST['priority'] ?? '';
            $responseContent = $_POST['response_content'] ?? '';
            
            if (empty($referenceNumber) || empty($responseContent)) {
                jsonResponse(['error' => 'Gerekli bilgiler eksik'], 400);
            }
            
            try {
                require_once __DIR__ . '/../src/Services/PDFService.php';
                
                $petitionData = [
                    'reference_number' => $referenceNumber,
                    'category_name' => $category,
                    'priority_name' => $priority
                ];
                
                $pdfContent = PDFService::generatePetitionResponsePDF($petitionData, $responseContent);
                $filename = "dilekce_cevabi_{$referenceNumber}.html";
                
                // HTML dosyası olarak indir (PDF simülasyonu)
                header('Content-Type: text/html; charset=utf-8');
                header('Content-Disposition: attachment; filename="' . $filename . '"');
                echo $pdfContent;
                exit;
                
            } catch (Exception $e) {
                jsonResponse(['error' => 'PDF oluşturma hatası: ' . $e->getMessage()], 500);
            }
        },
        '/api/download/word' => function() {
            $referenceNumber = $_POST['reference_number'] ?? '';
            $category = $_POST['category'] ?? '';
            $priority = $_POST['priority'] ?? '';
            $responseContent = $_POST['response_content'] ?? '';
            
            if (empty($referenceNumber) || empty($responseContent)) {
                jsonResponse(['error' => 'Gerekli bilgiler eksik'], 400);
            }
            
            try {
                require_once __DIR__ . '/../src/Services/PDFService.php';
                
                $petitionData = [
                    'reference_number' => $referenceNumber,
                    'category_name' => $category,
                    'priority_name' => $priority
                ];
                
                $wordContent = PDFService::generatePetitionResponseWord($petitionData, $responseContent);
                $filename = "dilekce_cevabi_{$referenceNumber}.rtf";
                
                header('Content-Type: application/rtf; charset=utf-8');
                header('Content-Disposition: attachment; filename="' . $filename . '"');
                echo $wordContent;
                exit;
                
            } catch (Exception $e) {
                jsonResponse(['error' => 'Word oluşturma hatası: ' . $e->getMessage()], 500);
            }
        }
    ]
];

// Route matching
$routeFound = false;

if (isset($routes[$method])) {
    foreach ($routes[$method] as $route => $handler) {
        if ($route === $path) {
            $routeFound = true;
            $handler();
            break;
        }
    }
}



// Dinamik route'lar için (örn: /petitions/123)
if (!$routeFound) {
    if (preg_match('/^\/petitions\/(\d+)$/', $path, $matches)) {
        requireAuth();
        $petitionId = (int)$matches[1];
        
        $petitionModel = new \App\Models\Petition();
        $petition = $petitionModel->findById($petitionId);
        
        if (!$petition) {
            http_response_code(404);
            renderView('errors/404');
            exit;
        }
        
        $user = getCurrentUser();
        if ($user['role'] !== 'admin' && $petition['user_id'] !== $user['id']) {
            http_response_code(403);
            renderView('errors/403');
            exit;
        }
        
        renderView('petitions/view', ['petition' => $petition]);
        $routeFound = true;
    }
}

// 404 Not Found
if (!$routeFound) {
    http_response_code(404);
    renderView('errors/404');
}