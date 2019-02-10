<div class="user-panel slate">
    <a href="<?php echo APP_URL; ?>user/<?php echo $user->data()->username ?>" class="clearfix">
        <div class="float-left">
            <img src="<?php echo USER_AVATAR_DIR . $user->data()->avatar; ?>" alt="<?php echo escape($user->data()->name); ?>">
        </div>
        <div class="float-right">
            <p class="name"><?php echo escape($user->data()->name); ?></p>
            <p class="prompt">View Profile</p>
        </div>
    </a>
</div>

<div class="menu-panel slate">
    <ul>
        <li>
            <a href="<?php echo APP_URL; ?>messages/inbox" <?php if($pageSelected === 'inbox'): ?>class="selected"<?php endif; ?>>
                <span class="icon ion-android-drafts"></span> Inbox
                <span class="float-right"><span class="ion-chevron-right"></span></span>
            </a>
        </li>
        <li>
            <a href="<?php echo APP_URL; ?>messages/sent" <?php if($pageSelected === 'sent'): ?>class="selected"<?php endif; ?>>
                <span class="icon ion-paper-airplane"></span> Sent
                <span class="float-right"><span class="ion-chevron-right"></span></span>
            </a>
        </li>
        <li>
            <a href="<?php echo APP_URL; ?>messages/trash" <?php if($pageSelected === 'trash'): ?>class="selected"<?php endif; ?>>
                <span class="icon ion-android-delete"></span> Trash
                <span class="float-right"><span class="ion-chevron-right"></span></span>
            </a>
        </li>
        <li>
            <a href="<?php echo APP_URL; ?>messages/compose" <?php if($pageSelected === 'compose'): ?>class="selected"<?php endif; ?>>
                <span class="icon ion-android-create"></span> Compose
                <span class="float-right"><span class="ion-chevron-right"></span></span>
            </a>
        </li>
    </ul>
</div>

<div class="menu-panel slate">
    <ul>
        <li>
            <a href="<?php echo APP_URL; ?>account/settings" <?php if($pageSelected === 'settings'): ?>class="selected"<?php endif; ?>>
                <span class="icon ion-gear-a"></span> Settings
                <span class="float-right"><span class="ion-chevron-right"></span></span>
            </a>
        </li>
        <li>
            <a href="<?php echo APP_URL; ?>account/password" <?php if($pageSelected === 'password'): ?>class="selected"<?php endif; ?>>
                <span class="icon ion-android-lock"></span> Change Password
                <span class="float-right"><span class="ion-chevron-right"></span></span>
            </a>
        </li>
        <li>
            <a href="<?php echo APP_URL; ?>account/pictures" <?php if($pageSelected === 'pictures'): ?>class="selected"<?php endif; ?>>
                <span class="icon ion-android-image"></span> Change Pictures
                <span class="float-right"><span class="ion-chevron-right"></span></span>
            </a>
        </li>
        <li>
            <a href="<?php echo APP_URL; ?>account/security" <?php if($pageSelected === 'sessions'): ?>class="selected"<?php endif; ?>>
                <span class="icon ion-android-expand"></span> Sessions
                <span class="float-right"><span class="ion-chevron-right"></span></span>
            </a>
        </li>
    </ul>
</div>

<div class="menu-panel slate">
    <ul>
        <li>
            <?php if($user->isPremium()): ?>
            <a href="<?php echo APP_URL; ?>account/plus" <?php if($pageSelected === 'plus'): ?>class="selected"<?php endif; ?>>
                <span class="icon ion-plus"></span> Your Plus
                <span class="float-right"><span class="ion-chevron-right"></span></span>
            </a>
            <?php else: ?>
            <a href="<?php echo APP_URL; ?>plus">
                <span class="icon ion-plus"></span> Upgrade to Plus
                <span class="float-right"><span class="ion-chevron-right"></span></span>
            </a>
            <?php endif; ?>
        </li>
    </ul>
</div>

<div class="menu-panel slate">
    <ul>
        <li>
            <a href="<?php echo APP_URL; ?>account/delete" class="text-red" <?php if($pageSelected === 'delete'): ?>class="selected"<?php endif; ?>>
                <span class="icon ion-android-close"></span> Delete Account
                <span class="float-right"><span class="ion-chevron-right"></span></span>
            </a>
        </li>
    </ul>
</div>