<div class="container py-4">
  <?php if (isset($meta['title'])): ?>
    <h3><?= $meta['title'] ?></h3>
    <hr class="mb-4">
  <?php endif ?>
  <form data-ajax-form action="<?= $meta['endpoint'] ?>">

    <input class="config" type="hidden" 
      <?php foreach($meta as $key => $value): ?>
        data-<?= $key ?>="<?= $value ?>"
      <?php endforeach ?>>
    <div class="row">
      <?php foreach($fields as $field): ?>
      <?php
        $type = isset($field['type']) ? $field['type'] : 'text';
        $value = isset($field['value']) ? $field['value'] : '';
        $placeholder = isset($field['placeholder']) ? $field['placeholder'] : '';
        $required = isset($field['required']) ? 'required' : '';
        $name = $field['name'];
        $id = preg_replace('/[^a-z0-9]/i', '_', $name);
        $col = isset($field['col']) ? $field['col'] : '12';
        $class = isset($field['class']) ? $field['class'] : '';
      ?>
      <div class="form-group mb-4 col-12 col-md-<?= $col ?> <?= $class ?>">
        <?php if (isset($field['label'])): ?>
          <label for="<?= $id ?>">
            <strong><?= $field['label'] ?></strong>
          </label>
        <?php endif ?>

        <?php switch ($type):
          case "text": ?>
          <?php case "number": ?>
          <?php case "email": ?>
            <input
              class="form-control"
              id="<?= $id ?>"
              type="<?= $type ?>"
              name="<?= $name ?>"
              value="<?= $value ?>"
              placeholder="<?= $placeholder ?>"
              <?= $required ?>
            />
          <?php break; ?>

          <?php case "textarea": ?>
            <?php
              $summernote = isset($field['summernote']) && $field['summernote'] ? ' summernote hidden' : '';
            ?>
              <textarea
                rows="4"
                cols="50"
                class="form-control<?= $summernote ?>"
                id="<?= $id ?>"
                type="<?= $type ?>"
                name="<?= $name ?>" placeholder="<?= $placeholder ?>" <?= $required ?>
              />
                <?= $value ?>
              </textarea>
          <?php break; ?>

          <?php case "checkbox": ?>
            <input id="<?= $id ?>" type="<?= $type ?>" name="<?= $name ?>" <?= $value ? 'checked' : '' ?> value="true" />
          <?php break; ?>

          <?php case "select": ?>
            <?php
              $options = $field['options'];
            ?>
              <select class="form-control" name="<?= $name ?>" <?= $required ?>>
                <?php foreach($options as $option): ?>
                  <?php $selected = $option['value'] == $value ? 'selected' : ''; ?>
                  <option value="<?= $option['value'] ?>" <?= $selected ?>>
                    <?= $option['display'] ?>
                  </option>
                <?php endforeach ?>
              </select>
          <?php break; ?>

          <?php case "photo": ?>
            <?php $hasPhoto = $value != ''; ?>
            <div class="form-control flex-center mp-0 dz-form-control">
              <input type="hidden" name="<?= $name ?>" value="<?= $value ?>">
              <div id="<?= $id ?>_photo_input" class="dz full-width full-height">
                <div class="my-preview">
                  <img src="<?= $value ?>" alt="Upload photo" style="height: 190px; max-width: 100%;" />
                </div>
              </div>
            </div>
          <?php break; ?>
          <?php case "gallery": ?>
            <div class="row">
              <?php foreach($value as $photo): ?>
                <div class="col-3 mb-4">
                  <div class="gallery-item" style="background-image: url('<?= $photo->url ?>')">
                    <a class="btn btn-danger delete-gallery-item" href="#"
                      data-endpoint="<?= $field['delete-endpoint'] . $photo->id ?>"
                    >
                      <i class="fa fa-trash"></i>
                    </a>
                  </div>
                </div>
              <?php endforeach ?>
            </div>
            <div
              class="dz-gallery dropzone"
              id="<?= $id ?>_gallery_input"
              data-name="<?= $name ?>"
            />
          <? break; ?>
        <?php endswitch ?>
        <?php if (errors()->has($type)): ?>
          <div class="form-group row flex-center px-5">
            <div class="alert alert-danger mt-4 full-width text-center">
              <span><?= errors()->get($type) ?></span>
            </div>
          </div>
        <?php endif ?>
      </div>
      <?php endforeach ?>


      <div class="form-group mb-1 col-12 col-md-12 ">
        <button class="btn btn-success mt-4" type="submit">
          <span class="content">
            <i class="fa fa-check mr-1"></i>
            Submit
          </span>
        </button>
      </div>

      <div class="flex-center hidden">
        <div class="alert alert-danger full-width">
          <span class="error-message"></span>
        </div>
      </div>
      
      <div class="form-group mb-5 col-12 col-md-12 ">
        <div class="mt-4 response-alert alert-success">
          <strong class="message"></strong>
          <div class="mt-3 options"></div>
        </div>
      </div>
    </div>
    
  </form>
</div>