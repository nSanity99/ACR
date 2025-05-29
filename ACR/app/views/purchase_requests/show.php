<a href="/?c=purchaseRequest&a=index">&laquo; Indietro</a>
<h2>Richiesta #<?=$pr['id']?> - <?=htmlspecialchars($pr['title'])?></h2>
<p><strong>Creato da:</strong> <?=htmlspecialchars($pr['username'])?><br>
<strong>Stato:</strong> <?=$pr['status']?><br>
<strong>Totale:</strong> € <?=$pr['total']?></p>
<h3>Items</h3>
<table>
    <thead><tr><th>Nome</th><th>Q.tà</th><th>Unit €</th><th>Totale €</th></tr></thead>
    <tbody>
    <?php foreach ($items as $it): ?>
        <tr>
            <td><?=htmlspecialchars($it['item_name'])?></td>
            <td><?=$it['quantity']?></td>
            <td><?=$it['unit_price']?></td>
            <td><?=number_format($it['quantity']*$it['unit_price'],2)?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php if (\App\Helpers\has_role($db,'FullAccess') || \App\Helpers\has_role($db,'Admin')): ?>
    <?php if ($pr['status'] === 'Submitted' || $pr['status'] === 'UnderReview'): ?>
        <a class="btn-primary" href="/?c=purchaseRequest&a=approve&id=<?=$pr['id']?>">Approva</a>
        <a class="btn-secondary" href="/?c=purchaseRequest&a=reject&id=<?=$pr['id']?>" onclick="return confirm('Sei sicuro di voler rifiutare?')">Rifiuta</a>
    <?php endif; ?>
<?php endif; ?>
