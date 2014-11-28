<!DOCTYPE HTML>
    <head>
        <title><?php bloginfo('name'); ?> | <?php wp_title(); ?></title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/galactic-theme/stylesheets/styles.css">
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
        <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <?php wp_head(); ?>
        <script src="<?php echo SCRIPTS; ?>/navigation.js"></script>
        <script src="<?php echo SCRIPTS; ?>/general.js"></script>
        <script src="<?php echo SCRIPTS; ?>/jquery.scrollUp.js"></script>
    </head>
    <body>
        <div id="page-wrap" class="container-fluid"><!-- WHOLE PAGE WRAPPER -->
            <header id="main-header">
                <div id="header-logo">
                    <h1>LOGO</h1>
                </div>
                <?php
                wp_nav_menu(array(
                    'theme-location' => 'main',
                    'container' => 'nav',
                    'container_class' => 'main-nav',
                ));
                ?>
            </header>
            <div class="clear"></div>
            <?php get_search_form(); ?>
            <div id="content-wrap" class="container"><!-- CONTENT WRAPPER -->
