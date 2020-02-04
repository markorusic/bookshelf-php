<!doctype html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="<?= $page_description ?>"/>
    <meta property="og:description" content="<?= $page_description ?>"/>
    <title><?= config('app.name') ?> | <?= $page_title ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
</head>
<body>

<!-- Main Header -->
<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="/">
                <h1><?= config('app.name') ?></h1>
            </a>
            <div class="d-flex justify-content-center align-items-center flex-row">
                <div class="shopping-cart-icon d-lg-none d-inline-block mr-3">
                <a href="/cart" class="shopping-cart-icon d-lg-none d-inline-block mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 28.98">
                        <defs>
                            <style>.cls-1 {
                                    fill: #231f20;
                                }

                                .cls-2 {
                                    font-size: 13px;
                                    fill: #2f4d54;
                                    display: inline-block;
                                    text-align: center;
                                }</style>
                        </defs>
                        <title>Cart</title>
                        <g id="Layer_2" data-name="Layer 2">
                            <g id="Layer_1-2" data-name="Layer 1">
                                <path
                                    class="cls-1"
                                    d="M23.78,3.95a.57.57,0,0,0-.57-.54H18.4a6.8,6.8,0,0,0-11.79,0H1.79a.57.57,0,0,0-.57.54L0,28.38a.57.57,0,0,0,.57.6H24.43a.57.57,0,0,0,.57-.6ZM18.18,6.82a.57.57,0,1,1-.57-.57.57.57,0,0,1,.57.57ZM12.5,1.14A5.67,5.67,0,0,1,17,3.41H8A5.67,5.67,0,0,1,12.5,1.14ZM7.39,6.25a.57.57,0,1,1-.57.57.57.57,0,0,1,.57-.57ZM1.16,27.84,2.33,4.55H6.08a6.77,6.77,0,0,0-.4,2.27A1.72,1.72,0,1,0,7.07,5.15a5.54,5.54,0,0,1,.23-.6H17.7a5.58,5.58,0,0,1,.23.6,1.7,1.7,0,1,0,1.39,1.67,6.78,6.78,0,0,0-.4-2.27h3.75l1.17,23.3Zm0,0"
                                />
                                <text
                                    class="cart-items-count cls-2 text-center"
                                    x="40%"
                                    y ="0" 
                                    text-anchor="middle"
                                    transform="translate(1.82 21.99)"
                                ></text>
                            </g>
                        </g>
                    </svg>
                </a>
                </div>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categories-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Categories
                        </a>
                        <div class="categories-dropdown dropdown-menu" aria-labelledby="categories-dropdown">
                            <a class="dropdown-item" href="/categories">All</a>
                            <div class="dropdown-divider"></div>
                            <?php
                                $_categories = App\Models\Category::findAll();
                                foreach ($_categories as $_category):
                            ?>
                                <a class="dropdown-item" href="/category?id=<?= $_category->id ?>">
                                    <?= $_category->name ?>
                                </a>
                            <?php endforeach ?>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact</a>
                    </li>
                    <?php if (auth()->check('customer')): ?>
                        <li class="nav-item dropdown">
                            <a id="auth-dropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <?= auth()->user()->name ?> <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="auth-dropdown">
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                >Logout</a>
                                <form id="logout-form" action="/logout" method="POST" style="display: none;"></form>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Login</a>
                        </li>
                    <?php endif ?>
                </ul>
                <a href="/cart" class="shopping-cart-icon d-none d-lg-block">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 28.98">
                        <defs>
                            <style>.cls-1 {
                                    fill: #231f20;
                                }

                                .cls-2 {
                                    font-size: 13px;
                                    fill: #2f4d54;
                                    display: inline-block;
                                    text-align: center;
                                }</style>
                        </defs>
                        <title>Cart</title>
                        <g id="Layer_2" data-name="Layer 2">
                            <g id="Layer_1-2" data-name="Layer 1">
                                <path
                                    class="cls-1"
                                    d="M23.78,3.95a.57.57,0,0,0-.57-.54H18.4a6.8,6.8,0,0,0-11.79,0H1.79a.57.57,0,0,0-.57.54L0,28.38a.57.57,0,0,0,.57.6H24.43a.57.57,0,0,0,.57-.6ZM18.18,6.82a.57.57,0,1,1-.57-.57.57.57,0,0,1,.57.57ZM12.5,1.14A5.67,5.67,0,0,1,17,3.41H8A5.67,5.67,0,0,1,12.5,1.14ZM7.39,6.25a.57.57,0,1,1-.57.57.57.57,0,0,1,.57-.57ZM1.16,27.84,2.33,4.55H6.08a6.77,6.77,0,0,0-.4,2.27A1.72,1.72,0,1,0,7.07,5.15a5.54,5.54,0,0,1,.23-.6H17.7a5.58,5.58,0,0,1,.23.6,1.7,1.7,0,1,0,1.39,1.67,6.78,6.78,0,0,0-.4-2.27h3.75l1.17,23.3Zm0,0"
                                />
                                <text
                                    class="cart-items-count cls-2 text-center"
                                    x="40%"
                                    y="0" 
                                    text-anchor="middle"
                                    transform="translate(1.82 21.99)"
                                ></text>
                            </g>
                        </g>
                    </svg>
                </a>
            </div>
        </nav>
    </div>

</header>
<!-- Main Header END -->