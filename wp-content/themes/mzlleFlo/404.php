<?php get_header(); ?>
<section id="erreur404" class="haut">
    <h2>Erreur de page !</h2>
    <p>Oups il semble que la page demandée n'existe pas.</p>
    <p>Retour à la page d'acceuil <a href="<?php echo esc_url(home_url()); ?>">ici</a></p>
</section>
</main>
<?php get_footer(); ?>