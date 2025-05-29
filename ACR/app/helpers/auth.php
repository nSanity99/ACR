<?php
namespace App\Helpers;

function current_user(\PDO $db): ?array {
    if (empty($_SESSION['user_id'])) return null;
    static $cache = null;
    if (!$cache) {
        $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$_SESSION['user_id']]);
        $cache = $stmt->fetch();
    }
    return $cache ?: null;
}

function has_role(\PDO $db, string $role): bool {
    $user = current_user($db);
    if (!$user) return false;
    $sql = 'SELECT 1 FROM user_roles ur JOIN roles r ON r.id = ur.role_id
            WHERE ur.user_id = ? AND r.name = ? LIMIT 1';
    $stmt = $db->prepare($sql);
    $stmt->execute([$user['id'], $role]);
    return (bool) $stmt->fetchColumn();
}

function require_role(\PDO $db, string $role): void {
    if (!has_role($db, $role)) {
        http_response_code(403);
        exit('Accesso negato');
    }
}
function has_permission(\PDO $db, string $perm): bool {
    $user = current_user($db);
    if (!$user) return false;
    $sql = 'SELECT 1
            FROM user_roles ur
            JOIN role_permissions rp ON rp.role_id = ur.role_id
            JOIN permissions p ON p.id = rp.permission_id
            WHERE ur.user_id = ? AND p.code = ? LIMIT 1';
    $stmt = $db->prepare($sql);
    $stmt->execute([$user['id'], $perm]);
    return (bool) $stmt->fetchColumn();
}

function require_permission(\PDO $db, string $perm): void {
    if (!has_permission($db, $perm)) {
        http_response_code(403);
        exit('Accesso negato');
    }
}

?>