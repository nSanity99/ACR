<?php
namespace App\Controllers;

use App\Helpers;

class PurchaseRequestController {
    public function __construct(private \PDO $db) {}

    private function userId(): int {
        return $_SESSION['user_id'] ?? 0;
    }

    private function guardInsert(): void {
        if (!Helpers\has_role($this->db,'Insert') && !Helpers\has_role($this->db,'FullAccess') && !Helpers\has_role($this->db,'Admin')) {
            http_response_code(403);
            exit('Accesso negato');
        }
    }

    public function index(): void {
        // Everyone logged-in sees their own, plus FullAccess/Admin see all
        $baseSql = 'SELECT pr.*, u.username FROM purchase_requests pr JOIN users u ON u.id = pr.user_id';
        if (Helpers\has_role($this->db,'FullAccess') || Helpers\has_role($this->db,'Admin')) {
            $stmt = $this->db->query($baseSql.' ORDER BY created_at DESC');
            $rows = $stmt->fetchAll();
        } else {
            $stmt = $this->db->prepare($baseSql.' WHERE pr.user_id = ? ORDER BY created_at DESC');
            $stmt->execute([$this->userId()]);
            $rows = $stmt->fetchAll();
        }
        $pageTitle = 'Richieste di Acquisto';
        ob_start();
        include __DIR__.'/../views/purchase_requests/index.php';
        $content = ob_get_clean();
        include __DIR__.'/../views/layout.php';
    }

    public function create(): void {
        $this->guardInsert();
        $pageTitle = 'Nuova Richiesta di Acquisto';
        ob_start();
        include __DIR__.'/../views/purchase_requests/create.php';
        $content = ob_get_clean();
        include __DIR__.'/../views/layout.php';
    }

    public function store(): void {
        $this->guardInsert();
        $title = trim($_POST['title'] ?? '');
        $desc  = trim($_POST['description'] ?? '');
        $items = $_POST['items'] ?? [];
        if ($title && $items) {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare('INSERT INTO purchase_requests (user_id, title, description) VALUES (?,?,?)');
            $stmt->execute([$this->userId(), $title, $desc]);
            $prId = (int)$this->db->lastInsertId();
            $itemStmt = $this->db->prepare('INSERT INTO purchase_request_items (purchase_request_id, item_name, quantity, unit_price) VALUES (?,?,?,?)');
            foreach ($items as $it) {
                if (!empty($it['name'])) {
                    $itemStmt->execute([$prId, $it['name'], (int)$it['qty'], (float)$it['price']]);
                }
            }
            $this->db->commit();
        }
        header('Location: /?c=purchaseRequest&a=index');
    }

    public function show(): void {
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) {
            http_response_code(404); exit('Not found');
        }
        $stmt = $this->db->prepare('SELECT pr.*, u.username FROM purchase_requests pr JOIN users u ON u.id = pr.user_id WHERE pr.id = ?');
        $stmt->execute([$id]);
        $pr = $stmt->fetch();
        if (!$pr) { http_response_code(404); exit('Not found'); }

        // Authorization: owner or fullaccess/admin
        if ($pr['user_id'] != $this->userId() && !Helpers\has_role($this->db,'FullAccess') && !Helpers\has_role($this->db,'Admin')) {
            http_response_code(403); exit('Accesso negato');
        }

        $items = $this->db->prepare('SELECT * FROM purchase_request_items WHERE purchase_request_id = ?');
        $items->execute([$id]);
        $items = $items->fetchAll();
        $pageTitle = 'Dettaglio Richiesta';
        ob_start();
        include __DIR__.'/../views/purchase_requests/show.php';
        $content = ob_get_clean();
        include __DIR__.'/../views/layout.php';
    }

    public function approve(): void {
        if (!Helpers\has_role($this->db,'FullAccess') && !Helpers\has_role($this->db,'Admin')) {
            http_response_code(403); exit('Accesso negato');
        }
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            $stmt = $this->db->prepare('UPDATE purchase_requests SET status = "Approved" WHERE id = ?');
            $stmt->execute([$id]);
        }
        header('Location: /?c=purchaseRequest&a=show&id='.$id);
    }

    public function reject(): void {
        if (!Helpers\has_role($this->db,'FullAccess') && !Helpers\has_role($this->db,'Admin')) {
            http_response_code(403); exit('Accesso negato');
        }
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            $stmt = $this->db->prepare('UPDATE purchase_requests SET status = "Rejected" WHERE id = ?');
            $stmt->execute([$id]);
        }
        header('Location: /?c=purchaseRequest&a=show&id='.$id);
    }
}
