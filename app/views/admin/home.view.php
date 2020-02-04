<?php require_view('admin/partials/header'); ?>

<div class="container mt-3 mb-5">
  <h4 class="text-center">Wellcome, <?= auth()->user()->name ?></h4>
</div>

<div class="px-5 mt-5">
  <div class="row">
    <div class="col-3 offset-2">
      <div id="active-users" class="mt-3"></div>
    </div>
    <div class="col-6">
      <h6 class="text-center mb-4">Page visits in last 24 hours (in %): </h6>
      <div>
       <canvas id="tracking-chart" width="400" height="600"></canvas>
      </div>
    </div>
  </div>
</div>

<?php require_view('admin/partials/scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.5.4/randomColor.min.js"></script>
<script src="<?= asset('js/admin/data-dashboard.js') ?>"></script>
<script>
$(function() {
  dashboard.initPageViews({
    container: '#tracking-chart'
  })
  dashboard.initActiveUsers({
    container: '#active-users'
  })
})
</script>
</body>
</html>