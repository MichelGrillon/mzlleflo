<?php
/*
Template Name: Page sans sidebar
*/
get_header();
if (have_posts()) : while (have_posts()) : the_post();
?>
        <section id="pages" class="haut">
            <h2><?php the_title(); ?></h2>
            <?php the_content(); ?>
        </section>

<?php endwhile;
endif; ?>
</main>
<?php if (is_active_sidebar('sidebar-bas')) : ?>
    <aside id="bas">
        <?php dynamic_sidebar('sidebar-bas'); ?>
    </aside>
<?php endif;
get_footer(); ?>