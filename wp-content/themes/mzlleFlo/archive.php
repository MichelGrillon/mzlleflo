<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        if (is_category()) {
            // Afficher le titre de la catégorie
            echo '<h1 class="category-title">' . single_cat_title('', false) . '</h1>';
        } elseif (is_tag()) {
            // Afficher le titre de l'étiquette
            echo '<h1 class="tag-title">' . single_tag_title('', false) . '</h1>';
        } elseif (is_author()) {
            // Afficher le nom de l'auteur
            echo '<h1 class="author-title">' . get_the_author() . '</h1>';
        } elseif (is_day()) {
            // Afficher la date du jour
            echo '<h1 class="date-title">' . get_the_date() . '</h1>';
        } elseif (is_month()) {
            // Afficher la date du mois
            echo '<h1 class="date-title">' . get_the_date('F Y') . '</h1>';
        } elseif (is_year()) {
            // Afficher la date de l'année
            echo '<h1 class="date-title">' . get_the_date('Y') . '</h1>';
        } else {
            // Afficher un titre par défaut
            echo '<h1 class="archive-title">' . __('Archives', 'textdomain') . '</h1>';
        }

        if (have_posts()) :
            while (have_posts()) :
                the_post();
        ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>
                    </header>
                    <div class="entry-content">
                        <?php
                        if (has_post_thumbnail()) {
                            // Envelopper l'image dans un lien vers l'article
                            echo '<a href="' . esc_url(get_permalink()) . '">';
                            the_post_thumbnail('medium'); // Utilisez la taille d'image que vous avez enregistrée
                            echo '</a>';
                        }
                        the_excerpt();
                        ?>
                    </div>
                </article>
            <?php
            endwhile;
        else :
            ?>
            <p><?php esc_html_e('Désolé, aucun article ne correspond à votre recherche...', 'textdomain'); ?></p>
        <?php
        endif;
        ?>
    </main>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>