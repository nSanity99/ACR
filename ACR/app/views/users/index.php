<div class="top-bar">
    <h2>Utenti</h2>
    <a class="btn-primary" href="/?c=user&a=create">Nuovo Utente</a>
</div>
<table>
    <thead>
        <tr><th>ID</th><th>Username</th><th>Email</th><th>Azioni</th></tr>
    </thead>
    <tbody>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?=$u['id']?></td>
            <td><?=htmlspecialchars($u['username'])?></td>
            <td><?=htmlspecialchars($u['email'])?></td>
            <td>
                <!-- Aggiungi azioni edit/del -->
                <a href="/?c=user&a=delete&id=<?=$u['id']?>" onclick="return confirm('Eliminare?')">Elimina</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
