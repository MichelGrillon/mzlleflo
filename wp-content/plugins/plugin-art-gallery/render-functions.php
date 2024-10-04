<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function render_artwork_archives_block()
{
    $artwork_archives = wp_get_archives(array(
        'post_type' => 'artwork',
        'type' => 'monthly',
        'echo' => 0
    ));

    if ($artwork_archives) {
        return '<ul>' . $artwork_archives . '</ul>';
    } else {
        return __('Aucune archive trouvée.', 'textdomain');
    }
}

function render_art_categories_block()
{
    $art_categories = get_terms(array(
        'taxonomy' => 'art_category',
        'hide_empty' => false,
    ));

    if (!empty($art_categories) && !is_wp_error($art_categories)) {
        $output = '<ul>';
        foreach ($art_categories as $category) {
            $output .= '<li><a href="' . get_term_link($category) . '">' . $category->name . '</a></li>';
        }
        $output .= '</ul>';
        return $output;
    } else {
        return __('Aucune catégorie d\'art trouvée.', 'textdomain');
    }
}

function render_latest_artworks_block($attributes)
{
    $number_of_posts = isset($attributes['numberOfPosts']) ? $attributes['numberOfPosts'] : 5;
    $layout = isset($attributes['layout']) ? $attributes['layout'] : 'vertical';

    $args = array(
        'post_type' => 'artwork',
        'posts_per_page' => $number_of_posts,
        'orderby' => 'date',
        'order' => 'DESC'
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
?>
        <div class="wp-block-art-gallery-latest-artworks <?php echo esc_attr($layout); ?>">
            <?php
            while ($query->have_posts()) {
                $query->the_post();
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                $excerpt = get_the_excerpt();
            ?>
                <div class="artwork-preview">
                    <?php if ($image_url) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
                    <?php endif; ?>
                    <h2><?php echo esc_html(get_the_title()); ?></h2>
                    <p><?php echo esc_html($excerpt); ?></p>
                </div>
            <?php
            }
            wp_reset_postdata();
            ?>
        </div>
<?php
        return ob_get_clean();
    } else {
        return __('Aucun article trouvé.', 'textdomain');
    }
}
