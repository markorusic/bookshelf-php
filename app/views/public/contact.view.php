<?php
    $page_title = 'Contact';
	$page_description = 'Contact us.';
    include 'partials/header.php';
?>

<!-- Main Container -->
<main class="contact">
    <!-- Page title -->
    <div class="page-title-strip">
        <div class="container">
            <h1 class="text-uppercase">Contact</h1>
            <div class="breadcrumb-top">
                <a href="/" class="breadcrumb-item">
                    <?= config('app.name') ?>
                </a> <span class="mlr">></span> <a
                        href="/contact" class="breadcrumb-item">Contact</a>
            </div>
        </div>
    </div>

    <!-- Contact Form -->

    <div class="container py-3">
        <div class="row">
            <div class="col-md-8">
                <h6>Have a question?</h6>
                <hr>
                <form id="contact-form">
                    <div class="form-group">
                        <label for="senderName">Name</label>
                        <input
                            class="form-control"
                            type="text"
                            name="senderName"
                            id="senderName"
                            data-validate
                            data-required="Name is required"
                            data-pattern="^[a-zA-Z ]+$"
                            data-pattern-message="Invalid name format"
                        />
                    </div>
                    <div class="form-group">
                        <label for="senderEmail">Email</label>
                        <input
                            class="form-control"
                            type="text"
                            name="senderEmail"
                            id="senderEmail"
                            data-validate
                            data-required="Email is required"
                            data-pattern="\S+@\S+\.\S+"
                            data-pattern-message="Invalid email format"
                        />
                    </div>
                    <div class="form-group">
                        <label for="senderSubject">Subject</label>
                        <input
                            type="text"
                            name="senderSubject"
                            id="senderSubject"
                            class="form-control"
                            data-validate
                            data-required="Subject is required"
                            data-pattern="^[a-z]{5,70}$"
                            data-pattern-message="Subject must be between 5 and 70 characters"
                        />
                    </div>
                    <div class="form-group">
                        <label for="senderMessage">Content</label>
                        <textarea
                            class="form-control"
                            name="senderMessage"
                            id="senderMessage"
                            rows="3"
                            data-validate
                            data-required="Content message is required"
                            data-pattern="^[a-z]{10,250}$"
                            data-pattern-message="Content message must be between 10 and 250 characters"
                        ></textarea>
                    </div>

                    <button type="submit" class="btn-add-to-cart-look d-flex justify-content-between">
                        <span>Send</span>
                        <span class="btn-add-to-cart-plus"><img src="<?= asset("img/check.svg") ?>" alt=""></span>
                    </button>
                </form>
            </div>
            <div class="col-md-4 info-box">
                <h6><?= config('app.name') ?></h6>
                <hr>
                <p class="lh2">
                    Adresa 213a<br>
                    11000 Beograd<br>
                    marko.rusic.22.17@ict.edu.rs
                </p>
            </div>
        </div>
    </div>

</main>
<!-- Main Container END -->


<?php include 'partials/footer.php' ?>

