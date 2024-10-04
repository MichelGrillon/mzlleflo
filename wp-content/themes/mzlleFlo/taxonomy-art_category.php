<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <header class="page-header">
            <h1 class="page-title"><?php single_term_title(); ?></h1>
            <?php the_archive_description('<div class="taxonomy-description">', '</div>'); ?>
        </header>

        <?php if (have_posts()) : ?>
            <div class="art-gallery">
                <?php while (have_posts()) : the_post(); ?>
                    <div class="art-gallery-item">
                        <a href="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" class="lightbox">
                            <?php the_post_thumbnail('medium'); ?>
                            <h2><?php the_title(); ?></h2>
                            <?php
                            $product_id = get_post_meta(get_the_ID(), '_artwork_product_id', true);
                            if ($product_id) {
                                $product = wc_get_product($product_id);
                                if ($product) {
                                    echo '<p>' . $product->get_price_html() . '</p>';
                                }
                            }
                            ?>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php the_posts_navigation(); ?>
        <?php else : ?>
            <p><?php _e('No artworks found in this category.', 'textdomain'); ?></p>
        <?php endif; ?>

    </main>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>