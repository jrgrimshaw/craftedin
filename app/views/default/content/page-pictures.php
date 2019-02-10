<section class="main">
    <div class="main-content bg-fix clearfix">
        <div class="container">
        
            <div class="account">
                <div class="account-left">
                    <?php $pageSelected = 'pictures'; require_once 'includes/page-sidebar.php'; ?>
                </div>

                <div class="account-right">
                    <div class="account-inner slate">
                        <h1>Change Pictures</h1>

                        <div class="account-avatar">
                            <h2>Avatar</h2>

                            <img src="<?php echo USER_AVATAR_DIR . $data->avatar; ?>" alt="<?php echo escape($data->name); ?>">

                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="field field-border">
                                    <input type="file" name="avatar">
                                </div>
                                <input type="submit" class="button button-success" value="Update Avatar">
                            </form>
                        </div>

                        <div class="account-header">
                            <h2>Header</h2>

                            <img src="<?php echo USER_HEADER_DIR . $data->header; ?>" alt="<?php echo escape($data->name); ?>">
                            
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="field field-border">
                                    <input type="file" name="header">
                                </div>
                                <input type="submit" class="button button-success" value="Update Header">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>