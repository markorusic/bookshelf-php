<?php
    $page_title = 'Categories';
	$page_description = config('app.name') . 'book categories.';
    include 'partials/header.php';
?>

<!-- Main Container -->
<main>
    <!-- Page title -->
    <div class="page-title-strip">
        <div class="container">
            <h1 class="text-uppercase">Categories</h1>
            <div class="breadcrumb-top">
                <a href="/" class="breadcrumb-item">
                    <?= config('app.name') ?>
                </a> <span class="mlr">></span> <a
                    href="/categories" class="breadcrumb-item">Categories</a>
            </div>
        </div>
    </div>

    <!-- Book categories -->
    <section class="book-section category-section">
        <div class="container">
            <div id="category-row" class="row"></div>
        </div>
    </section>
</main>
<!-- Main Container END -->

<?php include 'partials/footer.php' ?>
