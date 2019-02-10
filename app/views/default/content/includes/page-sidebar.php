<div class="user-panel slate">
    <a href="<?php echo APP_URL; ?>page/<?php echo $data->username ?>" class="clearfix">
        <div class="float-left">
            <img src="<?php echo USER_AVATAR_DIR . $data->avatar; ?>" alt="<?php echo escape($data->name); ?>">
        </div>
        <div class="float-right">
            <p class="name"><?php echo escape($data->name); ?></p>
            <p class="prompt">View Page</p>
        </div>
    </a>
</div>

<div class="menu-panel slate">
    <ul>
        <li>
            <a href="<?php echo APP_URL; ?>page/<?php echo $data->username ?>?manage=settings" <?php if($pageSelected === 'settings'): ?>class="selected"<?php endif; ?>>
                <span class="icon ion-gear-a"></span> Page Settings
                <span class="float-right"><span class="ion-chevron-right"></span></span>
            </a>
        </li>
        <li>
            <a href="<?php echo APP_URL; ?>page/<?php echo $data->username ?>?manage=pictures" <?php if($pageSelected === 'pictures'): ?>class="selected"<?php endif; ?>>
                <span class="icon ion-android-image"></span> Change Pictures
                <span class="float-right"><span class="ion-chevron-right"></span></span>
            </a>
        </li>
        <?php if($user->isPageOwner($data->id)): ?>
        <li>
            <a href="<?php echo APP_URL; ?>page/<?php echo $data->username ?>?manage=members" <?php if($pageSelected === 'members'): ?>class="selected"<?php endif; ?>>
                <span class="icon ion-android-create"></span> Editors
                <span class="float-right"><span class="ion-chevron-right"></span></span>
            </a>
        </li>
        <?php endif; ?>
    </ul>
</div>

<div class="menu-panel slate">
    <ul>
        <li>
            <a href="<?php echo APP_URL; ?>pages?create=1" class="text-green">
                <strong><span class="icon ion-plus"></span> Create a New Page</strong>
                <span class="float-right"><span class="ion-chevron-right"></span></span>
            </a>
        </li>
    </ul>
</div>