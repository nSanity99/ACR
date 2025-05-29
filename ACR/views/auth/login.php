<!-- app/views/auth/login.php -->
<?php include __DIR__.'/../layout.php'; ?>
<form method="post" class="p-4">
    <h2>Login</h2>
    <?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>
    <label>Username <input type="text" name="username" required></label><br>
    <label>Password <input type="password" name="password" required></label><br>
    <button type="submit">Entra</button>
</form>
