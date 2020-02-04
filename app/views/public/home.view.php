<?php
    $page_title = 'Welcome';
	$page_description = config('app.name') . ' is skin care shop you allways wanted!';
    include 'partials/header.php';
?>

    <!-- Main Container -->
    <main>

        <section class="book-section" id="home-book-group-1">
            <div class="container">
                <div class="heading-wrap text-center">
                    <h1 class="mt-4">Featured books</h1>
                </div>
                <div class="row"></div>
            </div>
        </section>

        <section class="book-section" id="home-book-group-2">
            <div class="container">
                <div class="heading-wrap text-center">
                    <h3 class="d-inline-block bg-white text-uppercase">Best sellers</h3>
                </div>
                <div class="row"></div>
            </div>
        </section>

        </div>
    </main>
    <!-- Main Container END -->



<?php include 'partials/footer.php' ?>