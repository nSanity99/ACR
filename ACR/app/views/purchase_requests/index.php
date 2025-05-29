<div class="top-bar">
    <h2>Richieste di Acquisto</h2>
    <?php if (\App\Helpers\has_role($db,'Insert') || \App\Helpers\has_role($db,'Admin') || \App\Helpers\has_role($db,'FullAccess')): ?>
        <a class="btn-primary" href="/?c=purchaseRequest&a=create">Nuova Richiesta</a>
    <?php endif; ?>
</div>
<table>
    <thead>
        <tr><th>ID</th><th>Titolo</th><th>Creato da</th><th>Stato</th><th>Totale</th><th>Azioni</th></tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?=$r['id']?></td>
            <td><?=htmlspecialchars($r['title'])?></td>
            <td><?=htmlspecialchars($r['username'])?></td>
            <td><?=$r['status']?></td>
            <td><?=$r['total']?></td>
            <td><a href="/?c=purchaseRequest&a=show&id=<?=$r['id']?>">Apri</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
