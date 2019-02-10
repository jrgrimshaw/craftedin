<!DOCTYPE html>
<html itemscope="" itemtype="http://schema.org/WebPage" lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=0.9, maximum-scale=0.9, user-scalable=no"> -->
    <meta name="viewport" content="width=940px">
    <meta name="google-site-verification" content="8DSbJ8FTiWsdImUaXu_nPPltnBZCYLBDxASqVcPbwLM">
    <meta name="author" content="CraftedIn">
    <meta name="description" content="CraftedIn is the premier hangout for developers, designers and more to share their work and interact with a like-minded community.">
    <meta name="keywords" content="crafted, in, craftedin, social, community, free, developers, designers, showcase, hangout, share">
    <?php $notification = new Notification; ?>
    <title><?php if($user->isLoggedIn() && $notification->getUnreadNotifications()->count()) { echo '(' . $notification->getUnreadNotifications()->count() . ')'; } ?> <?php echo isset($title) ? 'CraftedIn - ' .  $title : 'CraftedIn'; ?></title>
    <link rel="shortcut icon" href="<?php echo APP_URL; ?>favicon.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo APP_URL; ?>apple-touch-icon.png">
    <link rel="search" href="<?php echo APP_URL; ?>opensearch.xml" type="application/opensearchdescription+xml" title="CraftedIn">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL; ?>css/tooltipster.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL; ?>css/main.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.4.1/jquery.timeago.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/tooltipster/3.3.0/js/jquery.tooltipster.min.js"></script>
    <script src="<?php echo STATIC_URL; ?>js/main.js"></script>
</head>
<body>
    <?php if(isset($blank) !== true) { require_once 'header.php'; } ?>
    <?php require_once 'content/' . $content . '.php'; ?>
    <?php if(isset($blank) !== true) { require_once 'footer.php'; } ?>

    <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" defer></script>
    <script src="//checkout.stripe.com/v2/checkout.js" defer></script>
</body>
</html>