<h2>Nuova Richiesta di Acquisto</h2>
<form method="post" action="/?c=purchaseRequest&a=store" class="card" id="pr-form">
    <label>Titolo
        <input type="text" name="title" required>
    </label>
    <label>Descrizione
        <textarea name="description" rows="3"></textarea>
    </label>
    <h3>Items</h3>
    <table id="items-table">
        <thead>
            <tr><th>Nome</th><th>Q.tà</th><th>Prezzo Unitario (€)</th><th></th></tr>
        </thead>
        <tbody></tbody>
    </table>
    <button type="button" id="addItem" class="btn-secondary">Aggiungi Item</button>
    <div style="margin-top:1rem">
        <button type="submit" class="btn-primary">Salva Richiesta</button>
    </div>
</form>
<script src="/assets/js/app.js"></script>
