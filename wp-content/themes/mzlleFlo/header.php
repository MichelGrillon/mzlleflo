<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"> -->
    <!--  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->
    <!-- <script defer src="js/scripts.js"></script> -->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php wp_body_open(); ?> <div id="wrapper">
    <header class="site-header">
        <a href="<?php echo esc_url(home_url()); ?>" title="<?php bloginfo('name'); ?>">
            <div id="logo">
                <?php $image = get_header_image(); ?>
                <?php if (!empty($image)) : ?>
                    <img src="<?php echo esc_url($image); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="logo" />
                <?php else : ?>
                    <img src="<?php echo get_theme_support('custom_header', 'default-image'); ?>" alt="logo" />
                <?php endif; ?>
            </div>
            <?php if (display_header_text()) : ?>
                <div id="titre">
                    <h1 class="site-title"><?php bloginfo('name'); ?></h1>
                    <h2 class="site-description"><?php bloginfo('description'); ?></h2>
                </div>
            <?php endif; ?>
        </a>

        <!-- Icône du menu mobile -->
        <div id="mobile-menu-icon">
            <a class="toggle-nav" href="#"><i class="fas fa-bars"></i></a>
        </div>

    </header>

    <nav id="menuPrincipal">
        <!-- Menu Principal -->
        <?php
        wp_nav_menu(array(
            'sort_column' => 'menu-order',
            'theme_location' => 'principal',
            'container' => false,
            'menu_id' => 'main-menu',
        ));
        ?>
    </nav>
    <!--Fonction de recherche -->
    <div id="recherche">
        <i class="fas fa-search search-icon"></i>
        <form role="search" method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="Rechercher..." />
            <input type="submit" id="searchsubmit" value="Rechercher" />
        </form>
    </div>
    <?php do_action('after_main_menu'); ?>

    <!-- Nous générons un id unique pour chaque contenu et nous ajoutons de la même manière que pour le body
         des classes spécifiques générées automatiquement à chaque contenu. -->
    <main id="post-<?php the_ID(); ?>" <?php post_class(); ?>>