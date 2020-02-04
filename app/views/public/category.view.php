<?php
    $page_title = $category->name;
    $page_description = $category->description;
    include 'partials/header.php';
?>

<!-- Main Container -->
<main>
    <!-- Page title -->
    <div class="page-title-strip">
        <div class="container">
            <h1 class="text-uppercase"><?= $category->name ?></h1>
            <div class="breadcrumb-top">
                <a href="/" class="breadcrumb-item">
                    <?= config('app.name') ?>
                </a>
                <span class="mlr">></span>
                <a href="/category?id=<?= $category->id ?>" class="breadcrumb-item"><?= $category->name ?></a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="book-filter d-flex flex-column justify-content-md-between flex-md-row num-of-showed-books">
            <p>Shown <span class="currently-showing"></span> of total <span class="total"></span> books</p>

            <div>
                <form class="book-ordering">
                    <select name="orderby" class="orderby">
                        <option selected disabled>Select sorting option</option>
                        <option value="page_count">Sort by page count: ascending</option>
                        <option value="page_count-desc">Sort by page count: descending</option>
                        <option value="price">Sort by price: ascending</option>
                        <option value="price-desc">Sort by price: descending</option>
                    </select>
                </form>
            </div>
        </div>
    </div>


    <!-- Book list -->
    <section class="book-section">
        <div class="container">
            <div class="row" id="book-list"></div>
            <div class="heading-wrap text-center lmb-wrap" style="display: none;">
                <h3 class="d-inline-block bg-white"><a id="loadMore" class="load-more-btn">Show more</a></h3>
            </div>
        </div>
    </section>
</main>
<!-- Main Container END -->

<?php include 'partials/footer.php' ?>
