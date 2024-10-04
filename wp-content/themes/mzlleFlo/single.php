<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        while (have_posts()) :
            the_post();
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                </header>
                <div class="entry-content">
                    <?php
                    if (has_post_thumbnail() && !post_password_required() && !is_attachment()) {
                        // Vérifiez si l'image mise en avant est déjà présente dans le contenu
                        $content = get_the_content();
                        if (strpos($content, '<img') === false) {
                            // Envelopper l'image dans un lien vers l'article
                            echo '<a href="' . esc_url(get_permalink()) . '">';
                            the_post_thumbnail('large'); // Utilisez la taille d'image que vous avez enregistrée
                            echo '</a>';
                        }
                    }
                    the_content();
                    ?>
                </div>
            </article>
        <?php
        endwhile;
        ?>
    </main>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>