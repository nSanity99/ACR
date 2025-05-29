<?php
use function App\Helpers\current_user;
if (!isset($pageTitle)) $pageTitle = 'Gruppo Vitolo';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=htmlspecialchars($pageTitle)?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header class="main-header">
    <div class="container flex">
        <img src="/assets/images/logo.png" class="logo" alt="Logo Gruppo Vitolo" height="60">
        <h1 class="site-title">Gruppo Vitolo</h1>
        <?php
        $user = current_user($db);
        ?>
        <?php if ($user): ?>
        <nav class="nav">
            <a href="/?c=purchaseRequest&a=index">Richieste</a>
            <?php if (\App\Helpers\has_role($db,'Admin')): ?>
                <a href="/?c=user&a=index">Utenti</a>
            <?php endif; ?>
            <a href="/?c=auth&a=logout">Logout</a>
        </nav>
        <?php endif; ?>
    </div>
</header>
<main class="container">
    <?=$content?>
</main>
<footer class="main-footer">
    &copy; <?=date('Y')?> Gruppo Vitolo
</footer>
</body>
</html>
