<div class="container py-4">
  <?php if (!isset($hide_header) || $hide_header === false): ?>
    <div class="card-header">
      <div class="flex-sp-between">
        <h4 class="bold"><?= ucfirst($resource) ?></h4>
        <span>
          <a class="btn btn-success" href="<?= url("admin/{$resource}/create") ?>">
            <i class="fa fa-plus" aria-hidden="true"></i> 
            Create
          </a>
        </span>
      </div>
      <?php if (isset($search_by)): ?>
        <div class="mt-2">
          <input
            type="text"
            class="resource-table-search form-control"
            placeholder="Search"
            data-prop="<?= $search_by ?>"
          >
        </div>
      <?php endif ?>
    </div>
  <?php endif ?>

  <table class="table resource-table">
    <thead>
      <tr>
        <th>#</th>
        <?php foreach($cols as $i => $col): ?>
          <th class="uc-first"><?= _col($col) ?></th>
          <?php endforeach ?>
        <?php if (!isset($hide_actions) || $hide_actions === false): ?>
          <th>Actions</th>
        <?php endif ?>
      </tr>
    </thead>
    <tbody>
    <?php foreach($data as $index => $item): ?>
        <?php $id = $item->id; ?>
        <tr data-id="<?= $item->id ?>">
          <td><?= $index + 1 ?></td>
          <?php foreach($cols as $col): ?>
            <?php switch ($col):
                case "content":
            ?>
              <td><?= _limit($item->{$col}) ?></td>
              <?php break; ?>
              <?php case "main_photo": ?>
                <td data-name="main_photo">
                  <img src="<?= $item->{$col} ?>" alt="Photo not found" class="table-img">
                </td>
              <?php break; ?>
              <?php default: ?>
                  <td data-name="<?= $col ?>"><?= $item->{$col} ?></td>
              <?php endswitch ?>
          <?php endforeach ?>
          <?php if (!isset($hide_actions) || $hide_actions === false): ?>
            <td class="flex resource-actions">
              <a class="btn btn-primary white-txt mr-2"
                href="<?= url("admin/{$resource}/edit?id={$id}") ?>" 
              >
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </a>
              <!-- Handle Models visibility -->
              <?php
                $visibility = isset($visibility) ? $visibility : null;
                $visibilityendpoint = '';
                if ($visibility) {
                  $visibilityendpoint = url("/admin/{$resource}/visibility/toggle?id={$id}");
                }
              ?>
              <?php if (!is_null($visibility)): ?>
                <?php if ($item->visibility): ?>
                  <a href="<?= $visibilityendpoint ?>" class="btn btn-success mr-2">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </a>
                <?php else: ?>
                  <a href="<?= $visibilityendpoint ?>" class="btn btn-danger mr-2">
                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                  </a>
                <?php endif ?>
              <?php endif ?>
              <a class="btn btn-danger white-txt"
                data-delete="<?= "/admin/{$resource}/delete?id={$id}" ?>"
              >
                <i class="fa fa-trash-o" aria-hidden="true"></i>
              </a>
            </td>
          <?php endif ?>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
  <div data-resource-pagination></div>
</div>