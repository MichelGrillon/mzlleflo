<?php get_header();
if (have_posts()) : while (have_posts()) : the_post();
        if (is_active_sidebar('sidebar-droite')) : ?>
            <section id="pages" class="haut avecAside">
            <?php else : ?>
                <section id="pages" class="haut">
                <?php endif; ?>
                <h2><?php the_title(); ?></h2>

                <?php the_content(); ?>
                </section>
        <?php endwhile;
endif;
get_sidebar();
get_footer(); ?>