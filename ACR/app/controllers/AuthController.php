<?php
namespace App\Controllers;

class AuthController {
    public function __construct(private \PDO $db) {}

    public function login(): void {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $u = trim($_POST['username'] ?? '');
            $p = $_POST['password'] ?? '';
            $stmt = $this->db->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
            $stmt->execute([$u]);
            $user = $stmt->fetch();
            if ($user && password_verify($p, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: /?c=purchaseRequest&a=index');
                exit;
            }
            $error = 'Credenziali non valide';
        }
        $pageTitle = 'Login';
        ob_start();
        include __DIR__.'/../views/auth/login.php';
        $content = ob_get_clean();
        include __DIR__.'/../views/layout.php';
    }

    public function logout(): void {
        session_destroy();
        header('Location: /');
    }
}
