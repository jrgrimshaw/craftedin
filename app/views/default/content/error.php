<section class="main">
    <div class="error-page">
        <div class="error-page-darken">
            <div class="container">
                <div class="error-page-inner">
                    <div class="error-badge">404</div>
                    <h1>Nothing to see here.</h1>
                    <h2>The page <code><?php echo substr(escape($_SERVER['REQUEST_URI']), 0, 50); ?></code> could not be found.</h2>
                    <a href="<?php echo APP_URL; ?>" class="button button-primary button-medium"><span class="ion-home">&nbsp;</span> Take me home</a>
                </div>
            </div>
        </div>
    </div>
</section>