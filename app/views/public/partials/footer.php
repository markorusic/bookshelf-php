
<!-- Main Footer -->
<footer>
    <div class="copyright">
        <div class="container text-center">
            <small class="text-center">
                <?= config('app.name') ?> © <?= date("Y") ?>. <a href="<?= asset('dokumentacija.pdf') ?>" target="_blank">Docs</a>
            </small>
            <p class="text-center">Author <a href="/about">Marko Rusić</a></p>
        </div>
    </div>
</footer>
<!-- Main Footer END -->

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<?php if (auth()->check('customer')): ?>
<script src="<?= asset('js/user-activity-track.js') ?>"></script>
<?php endif ?>
<script src="<?= asset('js/dist/index.js') ?>"></script>
</body>
</html>
