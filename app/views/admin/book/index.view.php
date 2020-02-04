<?php

require_view('admin/partials/header');

echo "<div class='container py-2'>";
echo "<a href='export'><i class='fa fa-file-word-o mr-2'></i>Export as excel document</a>";
echo "</div>";

require_view('admin/partials/scripts');
?>
<script src="<?= asset('js/admin/data-table.js') ?>"></script>
<script>
$(function() {
  dataTable.init({
    resource: 'books',
    columns: ['name', 'price'],
    searchBy: 'name',
  })
})
</script>
</body>
</html>
