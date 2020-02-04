<?php
    $page_title = 'Login';
	  $page_description = config('app.name') . ' login page';
    include 'partials/header.php';
?>

<main>
    <!-- Page title -->
    <div class="page-title-strip">
        <div class="container">
            <h1 class="text-uppercase">Login</h1>
            <div class="breadcrumb-top">
                <a href="/" class="breadcrumb-item">
                  <?= config('app.name') ?>
                </a> <span class="mlr">></span> <a
                    href="/login" class="breadcrumb-item">Login</a>
            </div>
        </div>
    </div>

  <div class="container mt-5">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Login</div>

                  <div class="card-body">
                      <form id="login-form" method="POST" action="/login" data-validate-form>
                          <div class="form-group row">
                              <label for="email" class="col-sm-4 col-form-label text-md-right">Email</label>

                              <div class="col-md-6">
                                  <input
                                    id="email"
                                    class="form-control<?= errors()->has('email') ? ' is-invalid' : '' ?>"
                                    type="text"
                                    name="email"
                                    autofocus
                                    data-validate
                                    data-required="Email is required"
                                    data-pattern="\S+@\S+\.\S+"
                                    data-pattern-message="Invalid email format"
                                  />

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
                                  <input
                                    id="password"
                                    class="form-control<?= errors()->has('password') ? ' is-invalid' : '' ?>"
                                    type="password"
                                    name="password"
                                    data-validate
                                    data-required="Password is required"
                                    data-pattern="^.{6,}$"
                                    data-pattern-message="Invalid password format, at least 6 characters is required"
                                  />

                                  <?php if (errors()->has('password')): ?>
                                    <span class="invalid-feedback">
                                      <strong><?= errors()->get('password') ?></strong>
                                    </span>
                                  <?php endif ?>
                              </div>
                          </div>

                          <div class="form-group row my-2">
                            <div class="col-md-8 offset-md-4">
                              Don't have account? <a href="/register">Register</a>
                            </div>
                          </div>

                          <div class="form-group row mb-0">
                              <div class="col-md-8 offset-md-4">
                                  <button type="submit" class="btn-add-to-cart-look p-0">Login</button>
                              </div>
                          </div>
                          <?php if (errors()->has('auth_error')): ?>
                            <div class="form-group row flex-center px-5">
                              <div class="alert alert-danger mt-4 full-width text-center rounded-0">
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
</main>

<?php include 'partials/footer.php' ?>
