<?php
    $page_title = 'Cart';
	$page_description = 'Cart page.';
    include 'partials/header.php';
?>
    <!-- Main Container -->
    <main class="contact">
            <!-- Page title -->
        <div class="page-title-strip">
            <div class="container">
                <h1 class="text-uppercase">Cart</h1>
                <div class="breadcrumb-top">
                  <a href="index.php" class="breadcrumb-item">
                    <?= config('app.name') ?>
                  </a> <span class="mlr">></span> <a href="cart" class="breadcrumb-item">Cart</a>
                </div>
            </div>
        </div>

        <div id="cart-wrapper" class="container mt-4">
            <div class="row"></div>
        </div>

    </main>
    <!-- Main Container END -->    
    
    <?php if (auth()->check()): ?>
    <!-- Order modal-->
    <div class="modal fade" id="orderModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <!-- Modal body -->
                <div class="modal-body position-relative">
                    <form id="checkout-form">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control"
                                value="<?= auth()->user()->name ?>"
                                data-validate
                                data-required="Name is required"
                                data-pattern="[a-zA-Z]+"
                                data-pattern-message="Invalid name format"
                            />
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="text"
                                name="email"
                                id="email"
                                value="<?= auth()->user()->email ?>"
                                class="form-control"
                                data-validate
                                data-required="Email is required"
                                data-pattern="\S+@\S+\.\S+"
                                data-pattern-message="Invalid email format"
                            />
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input
                                type="text"
                                name="address"
                                id="address"
                                class="form-control"
                                data-validate
                                data-required="Address is required"
                                data-pattern="^[#.0-9a-zA-Z\s,-]+$"
                                data-pattern-message="Invalid address format"
                            />
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input
                                type="text"
                                name="city"
                                id="city"
                                class="form-control"
                                data-validate
                                data-required="City is required"
                                data-pattern="^([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$"
                                data-pattern-message="Invalid city name"
                            />
                        </div>
                        <div class="form-group">
                            <label for="contact">Phone number</label>
                            <input
                                type="tel"
                                name="contact"
                                id="contact"
                                class="form-control"
                                data-validate
                                data-required="Phone number is required"
                                data-pattern="^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$"
                                data-pattern-message="Invalid phone number"
                            />
                        </div>
                        <div class="form-group">
                            <label for="additionalInfo">Additional info</label>
                            <textarea
                                class="form-control"
                                id="additionalInfo"
                                name="additionalInfo"
                                rows="3"
                            ></textarea>
                        </div>
    
                        <button type="submit" class="btn-brand btn-add-to-cart-look d-flex justify-content-between">
                            <span>Order</span>
                            <span class="btn-add-to-cart-plus"><img src="<?= asset("img/check.svg") ?>" alt="Order"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif ?>
<?php include 'partials/footer.php' ?>