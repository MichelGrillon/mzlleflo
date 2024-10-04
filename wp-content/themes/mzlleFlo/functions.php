<?php
// Définition des paramètres de l'image du bandeau
function mzlleFlo_custom_header_setup()
{
    $header_args = array(
        'flex-height' => true,
        'flex-width' => true,
        'default-image' => get_template_directory_uri() . '/images/logo6_medium.gif',
    );
    add_theme_support('custom-header', $header_args);
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'mzlleFlo_custom_header_setup');

// Activer l'option de couleur d'arrière-plan avec une couleur par défaut
add_theme_support('custom-background', array('default-color' => 'cccccc'));

// Fonction pour ajouter les styles CSS du thème
function mzlleFlo_scripts()
{
    // Enregistrer et enfiler le style principal du thème depuis le dossier css
    wp_enqueue_style('mzlleFlo-style', get_template_directory_uri() . '/style.css');

    // Enregistrer et enfiler le style principal de WooCommerce
    wp_enqueue_style('woocommerce-general', get_template_directory_uri() . '/woocommerce.css');
    // Utilise le style par défaut de WooCommerce
    wp_enqueue_style('woocommerce-general', plugins_url('woocommerce/assets/css/woocommerce.css'));

    // Enregistrer et enfiler le style FontAwesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css');

    // Lightbox JS and CSS from CDN
    //wp_enqueue_script('lightbox-js', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js', array('jquery'), null, true);
    //wp_enqueue_style('lightbox-css', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css');

    // Charger les styles spécifiques pour le modèle "Full Width"
    if (is_page_template('full-width.php')) {
        wp_enqueue_style('full-width-style', get_template_directory_uri() . '/css/full-width.css');
    }

    // Enregistrer et enfiler le script personnalisé
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/scripts.js');
    wp_enqueue_script('custom-menu-script', get_template_directory_uri() . '/js/custom-menu.js', array('jquery'), null, true);

    // Localiser le script avec la URL AJAX
    wp_localize_script('custom-script', 'my_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}

// Ajouter les styles CSS avec le hook wp_enqueue_scripts
add_action('wp_enqueue_scripts', 'mzlleFlo_scripts');

function mzlleFlo_custom_admin_scripts($hook)
{
    if ($hook == 'widgets.php' || $hook == 'customize.php') {
        // Charger seulement les scripts nécessaires pour les widgets ou le customizer
        wp_enqueue_script('custom-widget-script', get_template_directory_uri() . '/js/custom-widget.js');
    }
}
add_action('admin_enqueue_scripts', 'mzlleFlo_custom_admin_scripts');

// Enregistrer les emplacements des menus
if (function_exists('register_nav_menus')) {
    register_nav_menus(array(
        'principal' => 'Menu principal',
        'footer' => 'Menu footer',
    ));
}

// Activer le support pour les balises de titre dynamiques
add_theme_support('title-tag');

// Ajout des options personnalisées avec l'objet $wp_customize et les méthodes add_setting, add_control, add_section, fonction pour personnaliser le thème dans le customizer de WordPress
function mzlleFlo_customize_register($wp_customize)
{
    // Vérifier si selective_refresh est défini : ajoute des rafraîchissements partiels pour certains éléments

    //Nous souhaitons ajouter l'icône de crayon au sein du "Live Preview" dans Apparence > Personnaliser :
    // Nous devons utiliser pour cela selective_refresh->add_partial() pour chaque option à $wp_customize .
    //Nous ajoutons donc le code suivant à la fonction mzelleFlo_customize_register() :
    if (isset($wp_customize->selective_refresh)) {

        //En premier paramètre de add_partial(), nous spécifions le nom de l'option (existante ou personnalisée)
        //et en second paramètre nous passons un tableau dans lequel nous définissons l'élément HTML devant lequel l'icône de crayon sera ajoutée.

        // Ajouter des partiels pour le rafraîchissement sélectif
        $wp_customize->selective_refresh->add_partial('blogname', array('selector' => '.site-title'));
        $wp_customize->selective_refresh->add_partial('blogdescription', array('selector' => '.site-description'));
        $wp_customize->selective_refresh->add_partial('header-image', array('selector' => '#logo'));
        $wp_customize->selective_refresh->add_partial('mzlleFlo_credits', array('selector' => '#copyright'));
        $wp_customize->selective_refresh->add_partial('my_layout_width', array('selector' => '#colonneDroite'));
    }

    // Ajoute des paramètres et des contrôles pour personnaliser le thème
    // couleur du texte
    $wp_customize->add_setting('text_color', array(
        'default' => '#000000',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_control($wp_customize, 'text_color', array(
        'label' => 'Couleur du texte',
        'section' => 'colors',
        'settings' => 'text_color',
    )));

    // Ajouter une section pour le footer
    $wp_customize->add_section('my_footer', array(
        'title' => 'Footer',
        'priority' => 120,
    ));

    // Ajouter une section pour la mise en page "Layout"
    $wp_customize->add_section('my_layout', array(
        'title' => 'Layout',
        'priority' => 60,
    ));

    // Ajouter un paramètre et un contrôle pour la largeur de la sidebar
    $wp_customize->add_setting('my_layout_width', array(
        'default' => 25, // Valeur par défaut: 25%
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',
    ));
    // Ajout du contrôleur pour "layout_width"
    $wp_customize->add_control('my_layout_width', array(
        'settings' => 'my_layout_width',
        'label' => "Largeur de la sidebar",
        'description' => '<em>20% à 40%</em>', // Description en italique
        'section' => 'my_layout',
        'type' => 'range',
        'input_attrs' => array(
            'min' => 20,
            'max' => 40,
            'step' => 5,
        )
    ));

    // Ajouter un paramètre et un contrôle pour afficher le copyright, seuls les users pouvant éditer les options pourront y accéder
    $wp_customize->add_setting('mzlleFlo_credits', array(
        'default' => 'oui',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',
    ));
    //Ajout du contrôleur 'mzelleFlo_credit
    $wp_customize->add_control('mzlleFlo_credits', array(
        'settings' => 'mzlleFlo_credits',
        'label' => "Souhaitez-vous montrer le copyright ?",
        'section' => 'my_footer',
        'type' => 'radio',
        'choices' => array(
            'oui' => "Oui",
            'non' => "Non",
        )
    ));

    // Ajouter des paramètres et des contrôles pour les informations de contact dans le footer
    // Ajout de l'option "Téléphone"
    $wp_customize->add_setting('mzlleFlo_tel', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',
    ));
    $wp_customize->add_control('mzlleFlo_tel', array(
        'settings' => 'mzlleFlo_tel',
        'label' => "Téléphone",
        'section' => 'my_footer',
        'type' => 'input',
        'input_attrs' => array('placeholder' => '0123456789'),
    ));

    // Ajout de l'option "Adresse"
    $wp_customize->add_setting('mzlleFlo_adresse', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',
    ));
    $wp_customize->add_control('mzlleFlo_adresse', array(
        'settings' => 'mzlleFlo_adresse',
        'label' => "Adresse",
        'section' => 'my_footer',
        'type' => 'textarea',
        'input_attrs' => array('placeholder' => 'votre adresse'),
    ));

    // Ajout de l'option "URL page Facebook"
    $wp_customize->add_setting('mzlleFlo_facebook', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('mzlleFlo_facebook', array(
        'settings' => 'mzlleFlo_facebook',
        'label' => "URL page Facebook",
        'section' => 'my_footer',
        'type' => 'url',
        'input_attrs' => array('placeholder' => 'http://www.facebook.fr'),
    ));

    // Ajout de l'option "URL page Tumblr"
    $wp_customize->add_setting('mzlleFlo_tumblr', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',
    ));
    $wp_customize->add_control('mzlleFlo_tumblr', array(
        'settings' => 'mzlleFlo_tumblr',
        'label' => "URL page Tumblr",
        'section' => 'my_footer',
        'type' => 'url',
        'input_attrs' => array('placeholder' => 'https://'),
    ));

    // Section pour Google Maps
    $wp_customize->add_section('my_google', array(
        'title' => 'Page contact - Google map',
        'priority' => 50,
    ));
    $wp_customize->add_setting('my_google_map', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',
        'default'        => false,
    ));
    $wp_customize->add_control('my_google_map', array(
        'settings' => 'my_google_map',
        'label' => "Afficher la Google map ?",
        'description' => "(page contact - juste avant le footer)",
        'section' => 'my_google',
        'type'      => 'checkbox',
    ));

    $wp_customize->add_setting('my_google_api', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',
    ));
    $wp_customize->add_control('my_google_api', array(
        'settings' => 'my_google_api',
        'label' => "votre clé API",
        'section' => 'my_google',
        'description' => 'https://developers.google.com/maps/documentation/embed/embedding-map',
        'type' => 'url',
    ));
    $wp_customize->add_setting('my_google_lat', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',
    ));
    $wp_customize->add_control('my_google_lat', array(
        'settings' => 'my_google_lat',
        'label' => "Latitude",
        'section' => 'my_google',
        'type' => 'input',
    ));
    $wp_customize->add_setting('my_google_long', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',
    ));
    $wp_customize->add_control('my_google_long', array(
        'settings' => 'my_google_long',
        'label' => "Longitude",
        'section' => 'my_google',
        'type' => 'input',
    ));
    $wp_customize->add_setting('my_google_zoom', array(
        'default' => 10,
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',
    ));
    $wp_customize->add_control('my_google_zoom', array(
        'settings' => 'my_google_zoom',
        'label' => "Zoom",
        'section' => 'my_google',
        'type' => 'range',
        'input_attrs' => array(
            'min' => 0,
            'max' => 21,
            'step' => 1,
        )
    ));

    // Section pour les polices
    $wp_customize->add_section('typography', array(
        'title' => 'Typographie',
        'priority' => 30,
    ));

    // Polices Google
    $google_fonts = array(
        'default' => 'Police par défaut',
        'Roboto' => 'Roboto',
        'Open Sans' => 'Open Sans',
        'Lato' => 'Lato',
        'Montserrat' => 'Montserrat',
        'Great Vibes' => 'Great Vibes',
        'Send Flowers' => 'Send Flowers',
        'Playwrite NO' => 'Playwrite NO',
    );

    // Menu
    $wp_customize->add_setting('menu_font_family', array(
        'default' => 'Playwrite NO',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('menu_font_family', array(
        'label' => 'Police pour le menu',
        'section' => 'typography',
        'type' => 'select',
        'choices' => $google_fonts,
    ));

    $wp_customize->add_setting(
        'menu_font_size',
        array(
            'default' => 16,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control('menu_font_size', array(
        'label' => 'Taille de la police pour le menu',
        'section' => 'typography',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 10,
            'max' => 100,
            'step' => 1,
        ),
    ));

    $wp_customize->add_setting('menu_font_bold', array(
        'default' => false,
        'sanitize_callback' => 'mzlleFlo_sanitize_checkbox',
    ));
    $wp_customize->add_control('menu_font_bold', array(
        'label' => 'Gras',
        'section' => 'typography',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('menu_font_italic', array(
        'default' => false,
        'sanitize_callback' => 'mzlleFlo_sanitize_checkbox',
    ));
    $wp_customize->add_control('menu_font_italic', array(
        'label' => 'Italique',
        'section' => 'typography',
        'type' => 'checkbox',
    ));

    // Entête
    $wp_customize->add_setting('header_font_family', array(
        'default' => 'Roboto',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('header_font_family', array(
        'label' => 'Police pour l\'entête',
        'section' => 'typography',
        'type' => 'select',
        'choices' => $google_fonts,
    ));

    $wp_customize->add_setting('header_font_size', array(
        'default' => 24,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('header_font_size', array(
        'label' => 'Taille de la police pour l\'entête',
        'section' => 'typography',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 10,
            'max' => 100,
            'step' => 1,
        ),
    ));

    $wp_customize->add_setting('header_font_bold', array(
        'default' => false,
        'sanitize_callback' => 'mzlleFlo_sanitize_checkbox',
    ));
    $wp_customize->add_control('header_font_bold', array(
        'label' => 'Gras',
        'section' => 'typography',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('header_font_italic', array(
        'default' => false,
        'sanitize_callback' => 'mzlleFlo_sanitize_checkbox',
    ));
    $wp_customize->add_control('header_font_italic', array(
        'label' => 'Italique',
        'section' => 'typography',
        'type' => 'checkbox',
    ));

    // Texte global
    $wp_customize->add_setting('body_font_family', array(
        'default' => 'Open Sans',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('body_font_family', array(
        'label' => 'Police pour le texte global',
        'section' => 'typography',
        'type' => 'select',
        'choices' => $google_fonts,
    ));

    $wp_customize->add_setting('body_font_size', array(
        'default' => 16,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('body_font_size', array(
        'label' => 'Taille de la police pour le texte global',
        'section' => 'typography',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 10,
            'max' => 100,
            'step' => 1,
        ),
    ));

    $wp_customize->add_setting('body_font_bold', array(
        'default' => false,
        'sanitize_callback' => 'mzlleFlo_sanitize_checkbox',
    ));
    $wp_customize->add_control('body_font_bold', array(
        'label' => 'Gras',
        'section' => 'typography',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('body_font_italic', array(
        'default' => false,
        'sanitize_callback' => 'mzlleFlo_sanitize_checkbox',
    ));
    $wp_customize->add_control('body_font_italic', array(
        'label' => 'Italique',
        'section' => 'typography',
        'type' => 'checkbox',
    ));

    // Catégories
    $wp_customize->add_setting('categories_font_family', array(
        'default' => 'Open Sans',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('categories_font_family', array(
        'label' => 'Police pour les catégories',
        'section' => 'typography',
        'type' => 'select',
        'choices' => $google_fonts,
    ));

    $wp_customize->add_setting('categories_font_size', array(
        'default' => 24,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('categories_font_size', array(
        'label' => 'Taille de la police pour les catégories',
        'section' => 'typography',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 10,
            'max' => 100,
            'step' => 1,
        ),
    ));

    $wp_customize->add_setting('categories_font_bold', array(
        'default' => false,
        'sanitize_callback' => 'mzlleFlo_sanitize_checkbox',
    ));
    $wp_customize->add_control('categories_font_bold', array(
        'label' => 'Gras',
        'section' => 'typography',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('categories_font_italic', array(
        'default' => false,
        'sanitize_callback' => 'mzlleFlo_sanitize_checkbox',
    ));
    $wp_customize->add_control('categories_font_italic', array(
        'label' => 'Italique',
        'section' => 'typography',
        'type' => 'checkbox',
    ));

    // Texte footer
    $wp_customize->add_setting('footer_font_family', array(
        'default' => 'Open Sans',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_font_family', array(
        'label' => 'Police pour le footer',
        'section' => 'typography',
        'type' => 'select',
        'choices' => $google_fonts,
    ));

    $wp_customize->add_setting('footer_font_size', array(
        'default' => 16,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('footer_font_size', array(
        'label' => 'Taille de la police pour le footer',
        'section' => 'typography',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 10,
            'max' => 100,
            'step' => 1,
        ),
    ));

    $wp_customize->add_setting('footer_font_bold', array(
        'default' => false,
        'sanitize_callback' => 'mzlleFlo_sanitize_checkbox',
    ));
    $wp_customize->add_control('footer_font_bold', array(
        'label' => 'Gras',
        'section' => 'typography',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('footer_font_italic', array(
        'default' => false,
        'sanitize_callback' => 'mzlleFlo_sanitize_checkbox',
    ));
    $wp_customize->add_control('footer_font_italic', array(
        'label' => 'Italique',
        'section' => 'typography',
        'type' => 'checkbox',
    ));

    // Ajouter une section pour la galerie d'art
    $wp_customize->add_section('art_gallery_section', array(
        'title' => __('Art Gallery', 'textdomain'),
        'priority' => 30,
    ));

    // Ajouter un contrôle pour le nombre d'images par page
    $wp_customize->add_setting('art_gallery_images_per_page', array(
        'default' => 10,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(
        'art_gallery_images_per_page',
        array(
            'label' => __('Nombre d\'images par page', 'textdomain'),
            'section' => 'art_gallery_section',
            'type' => 'number',
        )
    );

    // Ajouter un contrôle pour la taille des images
    $wp_customize->add_setting('art_gallery_image_size', array(
        'default' => 'medium',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('art_gallery_image_size', array(
        'label' => __('Taille des images', 'textdomain'),
        'section' => 'art_gallery_section',
        'type' => 'select',
        'choices' => array(
            'thumbnail' => __('Petite', 'textdomain'),
            'medium' => __('Moyenne', 'textdomain'),
            'large' => __('Grande', 'textdomain'),
        ),
    ));

    // Ajouter un contrôle pour l'effet de transition
    $wp_customize->add_setting('art_gallery_transition_effect', array(
        'default' => 'fade',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('art_gallery_transition_effect', array(
        'label' => __('Effet de transition', 'textdomain'),
        'section' => 'art_gallery_section',
        'type' => 'select',
        'choices' => array(
            'fade' => __('Fade', 'textdomain'),
            'slide' => __('Slide', 'textdomain'),
        ),
    ));

    // Ajouter un contrôle pour la couleur de fond de la lightbox
    $wp_customize->add_setting('art_gallery_lightbox_bg_color', array(
        'default' => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'art_gallery_lightbox_bg_color', array(
        'label' => __('Couleur de fond de la lightbox', 'textdomain'),
        'section' => 'art_gallery_section',
    )));

    // Ajouter un contrôle pour la couleur de la bordure des images
    $wp_customize->add_setting('art_gallery_image_border_color', array(
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'art_gallery_image_border_color', array(
        'label' => __('Couleur de la bordure des images', 'textdomain'),
        'section' => 'art_gallery_section',
    )));

    // Ajouter un contrôle pour l'affichage des légendes
    $wp_customize->add_setting('art_gallery_show_captions', array(
        'default' => true,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('art_gallery_show_captions', array(
        'label' => __('Afficher les légendes', 'textdomain'),
        'section' => 'art_gallery_section',
        'type' => 'checkbox',
    ));

    // Ajouter un contrôle pour l'affichage des numéros d'image
    $wp_customize->add_setting('art_gallery_show_image_numbers', array(
        'default' => true,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('art_gallery_show_image_numbers', array(
        'label' => __('Afficher les numéros d\'image', 'textdomain'),
        'section' => 'art_gallery_section',
        'type' => 'checkbox',
    ));

    // Ajouter un contrôle pour la durée de l'animation
    $wp_customize->add_setting('art_gallery_animation_duration', array(
        'default' => 600,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('art_gallery_animation_duration', array(
        'label' => __('Durée de l\'animation (ms)', 'textdomain'),
        'section' => 'art_gallery_section',
        'type' => 'number',
    ));

    // Ajouter un contrôle pour l'affichage des flèches de navigation
    $wp_customize->add_setting('art_gallery_show_navigation_arrows', array(
        'default' => true,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('art_gallery_show_navigation_arrows', array(
        'label' => __('Afficher les flèches de navigation', 'textdomain'),
        'section' => 'art_gallery_section',
        'type' => 'checkbox',
    ));

    // Ajouter un contrôle pour l'affichage du bouton de fermeture
    $wp_customize->add_setting('art_gallery_show_close_button', array(
        'default' => true,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('art_gallery_show_close_button', array(
        'label' => __('Afficher le bouton de fermeture', 'textdomain'),
        'section' => 'art_gallery_section',
        'type' => 'checkbox',
    ));

    // Enregistrer les nouvelles polices Google Fonts
    function mzlleFlo_enqueue_google_fonts()
    {
        $header_font = get_theme_mod('header_font_family', 'Roboto');
        $body_font = get_theme_mod('body_font_family', 'Open Sans');
        $categories_font = get_theme_mod('categories_font_family', 'Open Sans');
        $footer_font = get_theme_mod('footer_font_family', 'Open Sans');
        $menu_font = get_theme_mod('menu_font_family', 'Playwrite NO');

        $fonts = array_unique(array($header_font, $body_font, $categories_font, $footer_font, $menu_font));
        $font_query = implode('|', array_map('urlencode', $fonts));

        wp_enqueue_style('mzlleFlo-google-fonts', 'https://fonts.googleapis.com/css?family=' . $font_query, false);
    }
    add_action('wp_enqueue_scripts', 'mzlleFlo_enqueue_google_fonts');

    function mzlleFlo_sanitize_checkbox($checked)
    {
        return ((isset($checked) && true == $checked) ? true : false);
    }
}

//Les fonctions seront exécutées lors de l'enregistrement des options par WordPress (hook 'customize_register').
// Ajouter l'action customize_register pour enregistrer les personnalisations de thème
add_action('customize_register', 'mzlleFlo_customize_register');

// Ajouter du CSS pour les personnalisations de thème

//Appliquer l'option de couleur du texte que nous avons paramétrée mais aussi la couleur du texte d'entête que nous avions activée
//(la couleur d'arrière-plan s'applique déjà au body ), celle-ci sera appliquée au titre principal.
// Il est impossible d'inserer du php au sein du css, la solution est donc de gérer ceci dans le html balise <style>
//Afin d'associer les options de couleurs des elements html souhaités, nous greffons son execution lors de la construction du <head>

function theme_customize_css()
{
    $menu_font = get_theme_mod('menu_font_family', 'Playwrite NO');
    $menu_font_size = get_theme_mod('menu_font_size', 16);
    $menu_font_bold = get_theme_mod('menu_font_bold') ? 'bold' : 'normal';
    $menu_font_italic = get_theme_mod('menu_font_italic') ? 'italic' : 'normal';

    $header_font = get_theme_mod('header_font_family', 'Roboto');
    $header_font_size = get_theme_mod('header_font_size', 24);
    $header_font_bold = get_theme_mod('header_font_bold') ? 'bold' : 'normal';
    $header_font_italic = get_theme_mod('header_font_italic') ? 'italic' : 'normal';

    $body_font = get_theme_mod('body_font_family', 'Open Sans');
    $body_font_size = get_theme_mod('body_font_size', 16);
    $body_font_bold = get_theme_mod('body_font_bold') ? 'bold' : 'normal';
    $body_font_italic = get_theme_mod('body_font_italic') ? 'italic' : 'normal';

    $categories_font = get_theme_mod('categories_font_family', 'Open Sans');
    $categories_font_size = get_theme_mod('categories_font_size', 24);
    $categories_font_bold = get_theme_mod('categories_font_bold') ? 'bold' : 'normal';
    $categories_font_italic = get_theme_mod('categories_font_italic') ? 'italic' : 'normal';

    $footer_font = get_theme_mod('footer_font_family', 'Open Sans');
    $footer_font_size = get_theme_mod('footer_font_size', 24);
    $footer_font_bold = get_theme_mod('footer_font_bold') ? 'bold' : 'normal';
    $footer_font_italic = get_theme_mod('footer_font_italic') ? 'italic' : 'normal';

    // Art Gallery Settings
    $art_gallery_images_per_page = get_theme_mod('art_gallery_images_per_page', 10);
    $art_gallery_image_size = get_theme_mod('art_gallery_image_size', 'medium');
    $art_gallery_transition_effect = get_theme_mod('art_gallery_transition_effect', 'fade');
    $art_gallery_lightbox_bg_color = get_theme_mod('art_gallery_lightbox_bg_color', '#000000');
    $art_gallery_image_border_color = get_theme_mod('art_gallery_image_border_color', '#ffffff');
    $art_gallery_show_captions = get_theme_mod('art_gallery_show_captions', true);
    $art_gallery_show_image_numbers = get_theme_mod('art_gallery_show_image_numbers', true);
    $art_gallery_animation_duration = get_theme_mod('art_gallery_animation_duration', 600);
    $art_gallery_show_navigation_arrows = get_theme_mod('art_gallery_show_navigation_arrows', true);
    $art_gallery_show_close_button = get_theme_mod('art_gallery_show_close_button', true);
?>
    <style type="text/css">
        nav#menuPrincipal ul li a {
            font-family: '<?php echo esc_attr($menu_font); ?>', sans-serif;
            font-size: <?php echo intval($menu_font_size); ?>px;
            font-weight: <?php echo esc_attr($menu_font_bold); ?>;
            font-style: <?php echo esc_attr($menu_font_italic); ?>;
        }

        body {
            font-family: '<?php echo esc_attr($body_font); ?>', sans-serif;
            font-size: <?php echo intval($body_font_size); ?>px;
            font-weight: <?php echo esc_attr($body_font_bold); ?>;
            font-style: <?php echo esc_attr($body_font_italic); ?>;
        }

        header h1 {
            font-family: '<?php echo esc_attr($header_font); ?>', sans-serif;
            font-size: <?php echo intval($header_font_size); ?>px;
            font-weight: <?php echo esc_attr($header_font_bold); ?>;
            font-style: <?php echo esc_attr($header_font_italic); ?>;
        }

        .category {
            font-family: '<?php echo esc_attr($categories_font); ?>', sans-serif;
            font-size: <?php echo intval($categories_font_size); ?>px;
            font-weight: <?php echo esc_attr($categories_font_bold); ?>;
            font-style: <?php echo esc_attr($categories_font_italic); ?>;
        }

        footer {
            font-family: '<?php echo esc_attr($footer_font); ?>', sans-serif;
            font-size: <?php echo intval($footer_font_size); ?>px;
            font-weight: <?php echo esc_attr($footer_font_bold); ?>;
            font-style: <?php echo esc_attr($footer_font_italic); ?>;
        }

        /* Art Gallery Styles */
        .art-gallery {
            /* Add your custom styles for the art gallery here */
        }

        .art-gallery-item {
            /* Add your custom styles for the art gallery items here */
        }

        .lb-outerContainer {
            background-color: <?php echo esc_attr($art_gallery_lightbox_bg_color); ?>;
        }

        .lb-image {
            border-color: <?php echo esc_attr($art_gallery_image_border_color); ?>;
        }

        .lb-caption {
            display: <?php echo $art_gallery_show_captions ? 'block' : 'none'; ?>;
        }

        .lb-number {
            display: <?php echo $art_gallery_show_image_numbers ? 'block' : 'none'; ?>;
        }

        .lb-nav {
            display: <?php echo $art_gallery_show_navigation_arrows ? 'block' : 'none'; ?>;
        }

        .lb-close {
            display: <?php echo $art_gallery_show_close_button ? 'block' : 'none'; ?>;
        }
    </style>
<?php
}
// Ajoute l'action pour insérer le CSS personnalisé dans le head
add_action('wp_head', 'theme_customize_css');

// Enregistrer les sidebars via la méthode register_sidebar() au sein d'une fonction qui sera exécutée lors de l'initialisation des widgets

// Fonction pour enregistrer les sidebars (widgets areas)
function mzlleFlo_register_sidebars()
{

    //Ce test permet à cette fonction d'être réécrite éventuellement par un thème enfant ou un plugin.
    if (function_exists('register_sidebar')) {
        // Enregistrer la sidebar principale
        register_sidebar(array(
            'id' => 'sidebar-droite',
            'name' => 'Barre latérale principale',
            'description' => "Colonne de widgets qui apparait à droite",
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'id' => 'sidebar-bas',
            'name' => 'Zone de dépôt en pied de page',
            'description' => "Emplacement de widgets au-dessus du footer",
            'before_widget' => '<div class="widget-bas">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'id' => 'sidebar-contact',
            'name' => 'Barre latérale Contact',
            'description' => "Colonne de widgets de la page Contact qui apparait à gauche",
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));
    }
}

// Ajoute l'action pour enregistrer les sidebars
add_action('widgets_init', 'mzlleFlo_register_sidebars');

// Fonction ajouter des classes au <body> pour les articles et les catégories
function add_custom_body_classes($classes)
{
    if (is_single() || is_page() || is_category()) {
        $classes[] = 'main-container';
    }
    return $classes;
}
add_filter('body_class', 'add_custom_body_classes');

// Fonction pour modifier la longueur des extraits
function nbMotsExtraits($length)
{
    return 25;
}
add_filter('excerpt_length', 'nbMotsExtraits');

// Fonction pour modifier le texte "Lire la suite" des extraits
function finExtrait($more)
{
    return '&nbsp;[&rarr;]';
}
add_filter('excerpt_more', 'finExtrait');

// Définir la largeur du contenu
if (!isset($content_width)) $content_width = 900;

// Ajouter le support pour les commentaires sur les articles
if (is_singular()) wp_enqueue_script("comment-reply");

// Ajouter le support pour les liens de flux automatiques
add_theme_support('automatic-feed-links');

// Fonction pour ajouter les styles de l'éditeur
function mzlleFlo_add_editor_styles()
{
    add_editor_style(get_stylesheet_uri());
}
add_action('init', 'mzlleFlo_add_editor_styles');

// Modifier l'URL du login
function custom_login_url()
{
    return home_url('/welcome-mzlleflo');
}
add_filter('login_headerurl', 'custom_login_url');

//Bloquer l'authentification au back-office pendant 15 minutes après trois tentatives
function limit_login_attempts()
{
    $max_attempts = 3;
    $lockout_duration = 15 * 60; // 15 minutes

    $attempts = get_transient('login_attempts_' . $_SERVER['REMOTE_ADDR']);

    if ($attempts === false) {
        set_transient('login_attempts_' . $_SERVER['REMOTE_ADDR'], 1, $lockout_duration);
    } elseif ($attempts >= $max_attempts) {
        $error = 'Vous avez dépassé le nombre maximum de tentatives de connexion. Réessayez dans 15 minutes.';
        wp_die($error, 'Erreur de connexion');
    } else {
        set_transient('login_attempts_' . $_SERVER['REMOTE_ADDR'], $attempts + 1, $lockout_duration);
    }
}
add_action('wp_login_failed', 'limit_login_attempts');

// Activer le support pour WooCommerce
function yourtheme_setup()
{
    add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'yourtheme_setup');

// Wrappers pour le contenu WooCommerce
function yourtheme_woocommerce_wrapper_start()
{
    echo '<div id="primary" class="content-area">';
    echo '<main id="main" class="site-main">';
}

function yourtheme_woocommerce_wrapper_end()
{
    echo '</main></div>';
}

add_action('woocommerce_before_main_content', 'yourtheme_woocommerce_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'yourtheme_woocommerce_wrapper_end', 10);

//RGPD : Ajouter la lecture des conditions avant validation de la commande.
add_action('woocommerce_review_order_before_submit', 'wpm_woocommerce_rgpd', 10);
function wpm_woocommerce_rgpd()
{   ?>
    <p class="form-row terms">
        <input type="checkbox" class="input-checkbox" name="rgpd" id="rgpd">
        <label for="rgpd" class="checkbox">J’ai lu et j'accepte la <a href="#">politique de confidentialité du site*</a></strong></label>
    </p>
<?php
}

// Erreur affichée si l’utilisateur ne coche pas la case  
add_action('woocommerce_checkout_process', 'wpm_woocommerce_rgpd_erreur');
function wpm_woocommerce_rgpd_erreur()
{
    if (!(int) isset($_POST['rgpd'])) {
        wc_add_notice(__('<strong>Vous devez accepter la <a href="/politique-de-confidentialite/">politique de confidentialité du site</a></strong>'), 'error');
    }
}

function desactiver_wp_editor_si_woocommerce()
{
    if (class_exists('WooCommerce')) {
        wp_deregister_script('wp-editor');
    }
}
add_action('wp_print_scripts', 'desactiver_wp_editor_si_woocommerce', 100);

// Disable Widgets Block Editor 
add_filter('use_widgets_block_editor', '__return_false');

// Removing front end admin bar because it's ugly
add_filter('show_admin_bar', '__return_false');

//Script pour gérer les passerelles de paiement conditionnelles
add_filter('woocommerce_available_payment_gateways', 'manage_payment_gateways_based_on_transaction_type', 10, 1);

/**
 * Fonction pour gérer les passerelles de paiement en fonction du type de transaction.
 *
 * @param array $available_gateways Les passerelles de paiement disponibles.
 * @return array Les passerelles de paiement filtrées.
 */
function manage_payment_gateways_based_on_transaction_type($available_gateways)
{
    // Ne pas appliquer les modifications dans l'administration
    if (is_admin()) return $available_gateways;

    // Initialiser le type de transaction
    $type_of_transaction = '';

    // Parcourir les articles du panier
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        if ($product->is_type('variation')) {
            // Récupérer l'attribut "Type de transaction"
            $type_of_transaction = $product->get_attribute('pa_type_de_transaction'); // Assurez-vous que le slug de l'attribut est correct
            error_log('Type de transaction: ' . $type_of_transaction); // Message de débogage
            break;
        }
    }

    // Si le type de transaction est "Vente", désactiver le prélèvement automatique
    if ($type_of_transaction == 'Vente') {
        unset($available_gateways['stripe_sepa']);
    }
    // Si le type de transaction est "Location (mensuel)", désactiver la carte bancaire
    elseif ($type_of_transaction == 'Location (mensuel)') {
        unset($available_gateways['stripe']);
    }

    // Retourner les passerelles de paiement filtrées
    return $available_gateways;
}


//Script pour gérer les dépôts
add_action('woocommerce_before_calculate_totals', 'adjust_price_for_deposit', 10, 1);

/**
 * Fonction pour ajuster le prix total en fonction du type de transaction.
 *
 * @param WC_Cart $cart_object L'objet panier WooCommerce.
 */
function adjust_price_for_deposit($cart_object)
{
    // Parcourir les articles du panier
    foreach ($cart_object->get_cart() as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        if ($product->is_type('variation')) {
            // Récupérer l'attribut "Type de transaction"
            $type_of_transaction = $product->get_attribute('pa_type_de_transaction'); // Assurez-vous que le slug de l'attribut est correct

            // Ajouter un message de débogage
            error_log('Type de transaction: ' . $type_of_transaction);

            // Si le type de transaction est "Location (mensuel)", ajuster le prix pour inclure la caution
            if ($type_of_transaction == 'Location (mensuel)') {
                $original_price = $product->get_price();
                $deposit = $original_price * 0.30; // 30% du prix de vente
                $cart_item['data']->set_price($original_price + $deposit);
            }
        }
    }
}


//Afficher la caution dans le panier : Ajouter un message personnalisé dans le panier
add_action('woocommerce_before_cart', 'display_deposit_message_in_cart');

/**
 * Fonction pour afficher un message de caution dans le panier.
 */
function display_deposit_message_in_cart()
{
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        if ($product->is_type('variation')) {
            $type_of_transaction = $product->get_attribute('pa_type_de_transaction'); // Assurez-vous que le slug de l'attribut est correct

            // Ajouter un message de débogage
            error_log('Type de transaction: ' . $type_of_transaction);

            if ($type_of_transaction == 'Location (mensuel)') {
                $original_price = $product->get_price() / 1.30; // Calculer le prix original
                $deposit = $original_price * 0.30; // 30% du prix de vente
                echo '<p>Une caution de ' . wc_price($deposit) . ' (30% du prix de vente) sera prélevée pour cette location.</p>';
            }
        }
    }
}


//Afficher les informations de paiement sur les pages de produit : Ajouter un message personnalisé sur les pages de produit
add_action('woocommerce_single_product_summary', 'display_payment_info_on_product_page', 25);

/**
 * Fonction pour afficher les informations de paiement sur les pages de produit.
 */
function display_payment_info_on_product_page()
{
    global $product;
    if ($product->is_type('variation')) {
        $type_of_transaction = $product->get_attribute('pa_type_de_transaction'); // Assurez-vous que le slug de l'attribut est correct

        // Ajouter un message de débogage
        error_log('Type de transaction: ' . $type_of_transaction);

        if ($type_of_transaction == 'Vente') {
            echo '<p>Paiement par carte bancaire.</p>';
        } elseif ($type_of_transaction == 'Location (mensuel)') {
            echo '<p>Paiement par prélèvement automatique. Une caution de 30% du prix de vente sera prélevée.</p>';
        }
    }
}

//Afficher les informations de paiement sur la page de paiement : Ajouter un message personnalisé sur la page de paiement
add_action('woocommerce_review_order_before_payment', 'display_payment_info_on_checkout_page');

/**
 * Fonction pour afficher les informations de paiement sur la page de paiement.
 */
function display_payment_info_on_checkout_page()
{
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        if ($product->is_type('variation')) {
            $type_of_transaction = $product->get_attribute('pa_type_de_transaction'); // Assurez-vous que le slug de l'attribut est correct

            // Ajouter un message de débogage
            error_log('Type de transaction: ' . $type_of_transaction);

            if ($type_of_transaction == 'Vente') {
                echo '<p>Paiement par carte bancaire.</p>';
            } elseif ($type_of_transaction == 'Location (mensuel)') {
                echo '<p>Paiement par prélèvement automatique. Une caution de 30% du prix de vente sera prélevée.</p>';
            }
        }
    }
}

//Afficher la caution dans le panier (récapitulatif) : Ajouter un message personnalisé dans le récapitulatif du panier
add_action('woocommerce_cart_collaterals', 'display_deposit_message_in_cart_totals');

/**
 * Fonction pour afficher un message de caution dans le récapitulatif du panier.
 */
function display_deposit_message_in_cart_totals()
{
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        if ($product->is_type('variation')) {
            $type_of_transaction = $product->get_attribute('pa_type_de_transaction'); // Assurez-vous que le slug de l'attribut est correct

            // Ajouter un message de débogage
            error_log('Type de transaction: ' . $type_of_transaction);

            if ($type_of_transaction == 'Location (mensuel)') {
                $original_price = $product->get_price() / 1.30; // Calculer le prix original
                $deposit = $original_price * 0.30; // 30% du prix de vente
                echo '<p>Une caution de ' . wc_price($deposit) . ' (30% du prix de vente) sera prélevée pour cette location.</p>';
            }
        }
    }
}
