<?php
/*
Plugin Name: plugin-art-gallery
Plugin URI:
Description: Un plugin pour gérer et afficher une galerie d'art en relation avec WooCommerce
Author: Michel Grillon
Version: 1.0
Licence: GPL2
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Inclure les fonctions de rendu
require_once plugin_dir_path(__FILE__) . 'render-functions.php';

// Enqueue scripts and styles for the frontend
/*add_action('wp_enqueue_scripts', 'enqueue_art_gallery_scripts');
function enqueue_art_gallery_scripts()
{
    // Vérifier si les styles Lightbox sont déjà enqueués
    if (!wp_style_is('lightbox-css', 'enqueued')) {
        wp_enqueue_style('lightbox-css', plugin_dir_url(__FILE__) . 'css/lightbox.css');
    }

    // Vérifier si les scripts Lightbox sont déjà enqueués
    if (!wp_script_is('lightbox-js', 'enqueued')) {
        wp_enqueue_script('lightbox-js', plugin_dir_url(__FILE__) . 'js/lightbox.js', array('jquery'), null, true);
    }

    // Enqueue script de la galerie d'art
    wp_enqueue_script('art-gallery', plugin_dir_url(__FILE__) . 'js/art-gallery.js', array('jquery'), null, true);

    // Localiser le script avec l'URL AJAX
    wp_localize_script('art-gallery', 'artGallery', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('load_more_artworks_nonce')
    ));
}*/

require_once plugin_dir_path(__FILE__) . 'widgets/class-artwork-archives-widget.php';
require_once plugin_dir_path(__FILE__) . 'widgets/class-art-categories-widget.php';

// Fonction pour enregistrer les widgets
function register_artwork_widgets()
{
    register_widget('Artwork_Archives_Widget');
    register_widget('Art_Categories_Widget');
}
add_action('widgets_init', 'register_artwork_widgets');

// Créer un type de publication personnalisé pour les œuvres d'art
add_action('init', 'create_art_post_type');
function create_art_post_type()
{
    // Enregistrer le type de publication personnalisé 'artwork'
    register_post_type('artwork', array(
        'labels' => array(
            'name' => __('Galerie d\'art', 'textdomain'), // Nom au pluriel
            'singular_name' => __('Galerie d\'art', 'textdomain') // Nom au singulier
        ),
        'public' => true, // Accessible publiquement
        'has_archive' => true, // A une archive
        'supports' => array('title', 'editor', 'thumbnail'), // Supporte le titre, l'éditeur et l'image à la une
        'show_in_rest' => true, // Disponible dans l'API REST
        'taxonomies' => array('art_category'), // Supporte les catégories personnalisées
    ));
}

// Enregistrer les catégories personnalisées pour les œuvres d'art
add_action('init', 'register_art_creation_taxonomy');
function register_art_creation_taxonomy()
{
    $labels = array(
        'name' => _x('Art Categories', 'taxonomy general name'),
        'singular_name' => _x('Art Category', 'taxonomy singular name'),
        'search_items' => __('Search Art Categories'),
        'all_items' => __('All Art Categories'),
        'parent_item' => __('Parent Art Category'),
        'parent_item_colon' => __('Parent Art Category:'),
        'edit_item' => __('Edit Art Category'),
        'update_item' => __('Update Art Category'),
        'add_new_item' => __('Add New Art Category'),
        'new_item_name' => __('New Art Category Name'),
        'menu_name' => __('Art Categories'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'art-category'),
    );

    register_taxonomy('art_category', array('artwork'), $args);
}

// Ajouter les catégories personnalisées à la section "Ajouter des éléments de menu"
add_filter('wp_nav_menu_item_post_type_meta_boxes', 'add_art_categories_to_menu_meta_boxes');
function add_art_categories_to_menu_meta_boxes($post_types)
{
    $post_types[] = 'art_category'; // Utiliser les catégories personnalisées
    return $post_types;
}

// Ajouter une meta box pour lier les œuvres d'art aux produits WooCommerce
add_action('add_meta_boxes', 'add_artwork_product_meta_box');
function add_artwork_product_meta_box()
{
    add_meta_box(
        'artwork_product_meta_box', // ID de la meta box
        __('Produit WooCommerce associé', 'textdomain'), // Titre de la meta box
        'display_artwork_product_meta_box', // Fonction de rappel pour afficher la meta box
        'artwork', // Type de publication auquel la meta box est ajoutée
        'side', // Position de la meta box (côté)
        'default' // Priorité de la meta box
    );
}

function display_artwork_product_meta_box($post)
{
    // Récupérer l'ID du produit WooCommerce associé à l'œuvre d'art
    $product_id = get_post_meta($post->ID, '_artwork_product_id', true);

    // Afficher le champ de sélection pour lier l'œuvre d'art à un produit WooCommerce
    echo '<label for="artwork_product_id">' . __('Sélectionner le produit WooCommerce', 'textdomain') . '</label>';
    echo '<select name="artwork_product_id" id="artwork_product_id">';
    echo '<option value="">' . __('Aucun', 'textdomain') . '</option>';

    // Récupérer tous les produits WooCommerce
    $products = wc_get_products(array('limit' => -1));
    foreach ($products as $product) {
        // Afficher chaque produit dans le champ de sélection
        echo '<option value="' . $product->get_id() . '"' . selected($product_id, $product->get_id(), false) . '>' . $product->get_name() . '</option>';
    }
    echo '</select>';
}

// Sauvegarder la meta box lors de la sauvegarde de la publication
add_action('save_post', 'save_artwork_product_meta_box');
function save_artwork_product_meta_box($post_id)
{
    // Vérifier si l'ID du produit WooCommerce est défini
    if (isset($_POST['artwork_product_id'])) {
        // Mettre à jour la meta donnée avec l'ID du produit WooCommerce
        update_post_meta($post_id, '_artwork_product_id', sanitize_text_field($_POST['artwork_product_id']));
    }
}

// Créer un produit WooCommerce lorsque l'œuvre d'art est publiée
add_action('publish_artwork', 'create_woocommerce_product_from_artwork');
function create_woocommerce_product_from_artwork($post_id)
{
    // Vérifier si le type de publication est 'artwork'
    if (get_post_type($post_id) != 'artwork') {
        return;
    }

    // Récupérer l'ID du produit WooCommerce associé à l'œuvre d'art
    $product_id = get_post_meta($post_id, '_artwork_product_id', true);

    // Si aucun produit WooCommerce n'est associé, créer un nouveau produit
    if (empty($product_id)) {
        $post = get_post($post_id);
        $title = $post->post_title;
        $content = $post->post_content;
        $image_id = get_post_thumbnail_id($post_id);

        // Créer un nouveau produit WooCommerce
        $product = new WC_Product_Simple();
        $product->set_name($title);
        $product->set_description($content);
        $product->set_status('publish');
        $product->set_catalog_visibility('visible');

        // Si une image à la une est définie, l'associer au produit
        if ($image_id) {
            $product->set_image_id($image_id);
        }

        // Sauvegarder le produit et mettre à jour la meta donnée avec l'ID du nouveau produit
        $new_product_id = $product->save();
        update_post_meta($post_id, '_artwork_product_id', $new_product_id);
    }

    // Appeler les fonctions de publication sur les réseaux sociaux => Désactivé pour non création de l'API Facebook
    /*$title = get_the_title($post_id);
    $description = get_the_content($post_id);
    $link = get_permalink($post_id);

    // Assurez-vous que les fonctions de publication sont disponibles
    if (function_exists('post_to_facebook') && function_exists('post_to_tumblr')) {
        post_to_facebook($title, $description, $link);
        post_to_tumblr($title, $description, $link);
    } else {
        add_settings_error('social_media_settings', 'social_media_functions_error', 'Les fonctions de publication sur les réseaux sociaux ne sont pas disponibles.', 'error');
    }*/
}


// Mettre à jour le produit WooCommerce lorsque l'œuvre d'art est mise à jour
add_action('save_post', 'update_woocommerce_product_from_artwork', 20, 1);
function update_woocommerce_product_from_artwork($post_id)
{
    // Vérifier si le type de publication est 'artwork'
    if (get_post_type($post_id) != 'artwork') {
        return;
    }

    // Récupérer l'ID du produit WooCommerce associé à l'œuvre d'art
    $product_id = get_post_meta($post_id, '_artwork_product_id', true);

    // Si un produit WooCommerce est associé, mettre à jour ses informations
    if (!empty($product_id)) {
        $post = get_post($post_id);
        $title = $post->post_title;
        $content = $post->post_content;
        $image_id = get_post_thumbnail_id($post_id);

        // Récupérer le produit WooCommerce
        $product = wc_get_product($product_id);
        if ($product) {
            // Mettre à jour les informations du produit
            $product->set_name($title);
            $product->set_description($content);

            // Si une image à la une est définie, l'associer au produit
            if ($image_id) {
                $product->set_image_id($image_id);
            }

            // Sauvegarder le produit
            $product->save();
        }
    }
}

// Charger les œuvres d'art supplémentaires pour le chargement infini via Ajax
add_action('wp_ajax_load_more_artworks', 'load_more_artworks');
add_action('wp_ajax_nopriv_load_more_artworks', 'load_more_artworks');

function load_more_artworks()
{
    check_ajax_referer('load_more_artworks_nonce', 'nonce');

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';

    $args = array(
        'post_type' => 'artwork',
        'posts_per_page' => get_option('posts_per_page'),
        'paged' => $page,
    );

    if ($category) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'art_category',
                'field' => 'slug',
                'terms' => $category,
            ),
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product_id = get_post_meta(get_the_ID(), '_artwork_product_id', true);
            $artwork_id = get_post_meta($product_id, '_artwork_id', true);
            $artwork = get_post($artwork_id);

            if ($artwork) {
?>
                <div class="art-gallery-item <?php echo strtolower(get_the_terms($artwork_id, 'art_category')[0]->name); ?>">
                    <a href="<?php echo get_the_post_thumbnail_url($artwork_id, 'large'); ?>" class="lightbox">
                        <?php echo get_the_post_thumbnail($artwork_id, 'large'); ?>
                        <h2><?php echo get_the_title($artwork_id); ?></h2>
                        <p><?php echo get_post_meta($artwork_id, 'price', true); ?></p>
                    </a>
                </div>
    <?php
            } else {
                wc_get_template_part('content', 'product');
            }
        }
        wp_reset_postdata();
    }
    wp_die();
}

// Shortcode pour afficher la galerie d'art
add_shortcode('art_gallery', 'display_art_gallery');
function display_art_gallery()
{
    ob_start();
    ?>
    <div class="art-gallery">
        <?php
        $args = array(
            'post_type' => 'artwork',
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => 1,
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $product_id = get_post_meta(get_the_ID(), '_artwork_product_id', true);
        ?>
                <div class="art-gallery-item">
                    <a href="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" class="lightbox">
                        <?php the_post_thumbnail('large'); ?>
                        <h2><?php the_title(); ?></h2>
                        <p><?php echo get_post_meta($product_id, '_price', true); ?></p>
                    </a>
                </div>
        <?php
            }
            wp_reset_postdata();
        }
        ?>
    </div>
    <button id="load-more" data-next-page="2"><?php _e('Charger plus', 'textdomain'); ?></button>
<?php
    return ob_get_clean();
}

// Fonction pour récupérer les valeurs des paramètres de personnalisation
function get_art_gallery_option($option_name, $default = '')
{
    return get_theme_mod($option_name, $default);
}

// Exemple d'utilisation des paramètres dans l'extension
$images_per_page = get_art_gallery_option('art_gallery_images_per_page', 10);
$image_size = get_art_gallery_option('art_gallery_image_size', 'medium');
$transition_effect = get_art_gallery_option('art_gallery_transition_effect', 'fade');
$lightbox_bg_color = get_art_gallery_option('art_gallery_lightbox_bg_color', '#000000');
$image_border_color = get_art_gallery_option('art_gallery_image_border_color', '#ffffff');
$show_captions = get_art_gallery_option('art_gallery_show_captions', true);
$show_image_numbers = get_art_gallery_option('art_gallery_show_image_numbers', true);
$animation_duration = get_art_gallery_option('art_gallery_animation_duration', 600);
$show_navigation_arrows = get_art_gallery_option('art_gallery_show_navigation_arrows', true);
$show_close_button = get_art_gallery_option('art_gallery_show_close_button', true);

register_activation_hook(__FILE__, 'flush_rewrite_rules');

?>