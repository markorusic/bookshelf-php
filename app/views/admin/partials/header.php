<?php require('head.php') ?>

<body>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
      <div class="container">
        <a class="navbar-brand uc-first" href="/admin">
          <?= config('app.name') ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto">
            <li>
              <a class="nav-link" href="/admin/books/showAll">Books</a>
            </li>
            <li>
              <a class="nav-link" href="/admin/categories/showAll">Categories</a>
            </li>
          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            <?php if (auth()->check()): ?>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <?= auth()->user()->name ?> <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#"
                          onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        >
                          Logout
                        </a>
                        <form id="logout-form" action="/admin/logout" method="POST" style="display: none;">
                        </form>
                    </div>
                </li>
            <?php endif ?>
          </ul>
        </div>
      </div>
    </nav>