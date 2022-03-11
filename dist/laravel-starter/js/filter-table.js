function filterRowsTable(input, _table) {
    let filter, table, tr, td, cell;
    filter = input.value.toUpperCase().trim();
    table = document.querySelector(_table);
    tr = table.getElementsByTagName("tr");
    for (i = 1; i < tr.length; i++) {
      // Hide the row initially.
      tr[i].style.display = "none";
      td = tr[i].getElementsByTagName("td");
      for (var j = 0; j < td.length; j++) {
        cell = tr[i].getElementsByTagName("td")[j];
        if (cell.hasAttribute('data-row') && cell.getAttribute('data-row') == 'ignore') {
          continue;
        }
        if (cell) {
          if (cell.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
            break;
          } 
        }
      }
    }
}