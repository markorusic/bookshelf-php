<?php require_view('admin/partials/head'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Login</div>

                <div class="card-body">
                    <form method="POST" action="/admin/login">
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control<?= errors()->has('email') ? ' is-invalid' : '' ?>" name="email" value="" required autofocus>

                                <?php if (errors()->has('email')): ?>
                                    <span class="invalid-feedback">
                                        <strong><?= errors()->get('email') ?></strong>
                                    </span>
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control<?= errors()->has('password') ? ' is-invalid' : '' ?>" name="password" required>

                                <?php if (errors()->has('password')): ?>
                                  <span class="invalid-feedback">
                                    <strong><?= errors()->get('password') ?></strong>
                                  </span>
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </div>
                        <?php if (errors()->has('auth_error')): ?>
                          <div class="form-group row flex-center px-5">
                            <div class="alert alert-danger mt-4 full-width text-center">
                              <span><?= errors()->get('auth_error') ?></span>
                            </div>
                          </div>
                        <?php endif ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_view('admin/partials/footer'); ?>
