<?php

/**
 * Plugin Name: Plugin Art Gallery Blocks
 * Description: Convertit les widgets de la galerie d'art en blocs Gutenberg.
 * Version: 1.0
 * Author: Michel Grillon
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Inclure les fonctions de rendu
require_once plugin_dir_path(__FILE__) . '../plugin-art-gallery/render-functions.php';

function register_art_gallery_blocks()
{
    // Enregistrer le script du bloc
    wp_register_script(
        'art-gallery-blocks-script',
        plugins_url('js/art-gallery-blocks.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-editor')
    );

    // Enregistrer le style du bloc
    wp_register_style(
        'art-gallery-blocks-style',
        plugins_url('css/art-gallery-blocks.css', __FILE__),
        array('wp-edit-blocks')
    );

    // Enregistrer les blocs
    register_block_type('art-gallery/artwork-archives', array(
        'editor_script' => 'art-gallery-blocks-script',
        'editor_style'  => 'art-gallery-blocks-style',
        'render_callback' => 'render_artwork_archives_block',
    ));

    register_block_type('art-gallery/art-categories', array(
        'editor_script' => 'art-gallery-blocks-script',
        'editor_style'  => 'art-gallery-blocks-style',
        'render_callback' => 'render_art_categories_block',
    ));

    register_block_type('art-gallery/latest-artworks', array(
        'editor_script' => 'art-gallery-blocks-script',
        'editor_style'  => 'art-gallery-blocks-style',
        'render_callback' => 'render_latest_artworks_block',
    ));
}
add_action('init', 'register_art_gallery_blocks');
