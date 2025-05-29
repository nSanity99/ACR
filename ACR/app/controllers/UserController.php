<?php
namespace App\Controllers;

use App\Helpers;

class UserController {
    public function __construct(private \PDO $db) {}

    private function guard(): void {
        Helpers\require_role($this->db, 'Admin');
    }

    public function index(): void {
        $this->guard();
        $stmt = $this->db->query('SELECT id, username, email FROM users');
        $users = $stmt->fetchAll();
        $pageTitle = 'Gestione Utenti';
        ob_start();
        include __DIR__.'/../views/users/index.php';
        $content = ob_get_clean();
        include __DIR__.'/../views/layout.php';
    }

    public function create(): void {
        $this->guard();
        $pageTitle = 'Nuovo Utente';
        ob_start();
        include __DIR__.'/../views/users/create.php';
        $content = ob_get_clean();
        include __DIR__.'/../views/layout.php';
    }

    public function store(): void {
        $this->guard();
        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if ($username && $password) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare('INSERT INTO users (username, email, password) VALUES (?,?,?)');
            $stmt->execute([$username, $email, $hash]);
        }
        header('Location: /?c=user&a=index');
    }

    public function delete(): void {
        $this->guard();
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            $stmt = $this->db->prepare('DELETE FROM users WHERE id = ?');
            $stmt->execute([$id]);
        }
        header('Location: /?c=user&a=index');
    }
}
