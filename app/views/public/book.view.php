<?php
    $page_title = $book->name;
    $page_description = $book->description;
    include 'partials/header.php';
?>

<!-- Main Container -->
<main>
    <!-- Page title -->
    <div class="page-title-strip">
        <div class="container">
            <h1 class="text-uppercase"><?= $book->name ?></h1>
            <div class="breadcrumb-top">
                <a href="/" class="breadcrumb-item">
                    <?= config('app.name') ?>
                </a> 
                <span class="mlr">></span>
                <?php if ($book->category): ?>
                    <a href="/category?id=<?= $book->category->id ?>" class="breadcrumb-item"><?= $book->category->name ?></a>
                    <span class="mlr">></span>
                <?php endif ?>
                <a href="/book?id=<?= $book->slug ?>" class="breadcrumb-item"><?= $book->name ?></a>
            </div>
        </div>
    </div>

    <!-- Single book -->
    <div class="container">
        <div class="single-book">
            <div class="row">
                <div class="col-md-6">
                    <div class="book-image-preview">
                        <div class="position-relative">
                            <img class="img-fluid gallery-active-photo" src="<?= $book->main_photo ?>" alt="<?= $book->name ?>" class="img-fluid">
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between">
                        <h2 class="book-price"><?= $book->price ?> <span class="currency"></span> </h2>
                    </div>

                    <div>
                        <span><b>Author:</b> <?= $book->author ?></span>
                    </div>

                    <div>
                        <span><b>Page count:</b> <?= $book->page_count ?></span>
                    </div>

                    <hr>

                    <div class="add-to-cart-block">
                        <form action="">
                            <input
                                id="add-to-cart-quantity"
                                class="input-number"
                                type="number"
                                step="1"
                                min="1"
                                name="quantity"
                                value="1"
                            >
                            <div class="d-inline-block">
                                <button data-book-id="<?= $book->id ?>" type="submit" class="btn-add-to-cart d-flex justify-content-between">
                                    <span>Add to cart</span>
                                    <span class="btn-add-to-cart-plus"><img src="<?= asset("img/plus.svg") ?>" alt="Dodaj u korpu"></span>
                                </button>
                            </div>

                        </form>
                    </div>

                    <hr>

                    <div class="book-description">
                        <h4 class="mt-4 mb-4">Book description</h4>
                        <p><?= $book->description ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<!-- Main Container END -->

<?php include 'partials/footer.php' ?>
