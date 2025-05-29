<form class="card narrow" method="post">
    <h2>Accesso area riservata</h2>
    <?php if (!empty($error)): ?>
        <div class="alert error"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>
    <label>Username
        <input type="text" name="username" required>
    </label>
    <label>Password
        <input type="password" name="password" required>
    </label>
    <button type="submit" class="btn-primary">Entra</button>
</form>
