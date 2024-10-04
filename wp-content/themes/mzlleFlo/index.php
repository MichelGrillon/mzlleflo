<?php get_header(); ?>



<?php
if (is_active_sidebar('sidebar_droite')) : ?>
    <section id="articles" class="haut avecAside">
    <?php else : ?>
        <section id="articles" class="haut">
            <?php endif;
        if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="unArticle">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <?php the_excerpt(); ?>
                    <p class="infos">
                        <?php comments_number('Aucun commentaire', 'un seul commentaire', '% commentaires'); ?>
                    </p>
                </div>
        <?php endwhile;

            if (empty(get_theme_mod('my_slider_first'))) :
                the_posts_pagination();
            endif;
        endif; ?>
        </section>

        <?php get_sidebar(); ?>

        <?php get_footer(); ?>