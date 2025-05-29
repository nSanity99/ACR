document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('addItem');
  if (!btn) return;
  const tableBody = document.querySelector('#items-table tbody');

  function addRow(data = {name:'', qty:1, price:0}) {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td><input type="text" name="items[][name]" value="${data.name}" required></td>
        <td><input type="number" name="items[][qty]" value="${data.qty}" min="1" required></td>
        <td><input type="number" name="items[][price]" value="${data.price}" step="0.01" min="0" required></td>
        <td><button type="button" class="remove-item">&times;</button></td>
      `;
      tableBody.appendChild(tr);
  }

  btn.addEventListener('click', () => addRow());

  tableBody.addEventListener('click', e => {
      if (e.target.classList.contains('remove-item')) {
          e.target.closest('tr').remove();
      }
  });

  // add first row by default
  addRow();
});
