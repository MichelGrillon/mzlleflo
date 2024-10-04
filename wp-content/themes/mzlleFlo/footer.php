<footer>
    <nav id="menuFooter">
        <?php wp_nav_menu(array(
            'sort_column' => 'menu_order',
            'theme_location' => 'footer',
            'fallback_cb' => false
        )); ?>
    </nav>


    <div id="footer_info">
        <div id="footer_left">

            <?php
            $tel = get_theme_mod('mzlleFlo_tel');
            if ($tel != '') {
                echo '<div id="tel"><i class="fas fa-phone-square-alt"></i> ' . $tel . '</div>';
            }
            $adress = get_theme_mod('mzlleFlo_adresse');
            if ($adress != '') {
                echo  '<div id="adress"><i class="fas fa-map-marker-alt"></i> ' . $adress . '</div>';
            } ?>
        </div>
        <div id="footer_right">
            <?php
            $facebook = get_theme_mod('mzlleFlo_facebook');
            if ($facebook != '') {
                echo '<div id="facebook"><a href="' . $facebook . '"><i class="fab fa-facebook"></i><p>Facebook</p></a></div>';
            }
            $tumblr = get_theme_mod('mzlleFlo_tumblr');
            if ($tumblr != '') {
                echo '<div id="tumblr"><a href="' . $tumblr . '"><i class="fa-brands fa-square-tumblr"></i><p>Tumblr</p></a></div>';
            }
            ?>

        </div>
    </div>
    <?php
    $copyright = get_theme_mod('mzlleFlo_credits');
    if ($copyright == 'oui') {
        echo '<div id="copyright"><i>&copy; M\' Zlle Flo - ' . date('Y') . ' / Tous droits réservés. Thème  par M\' Zlle Flo & Michel Grillon</i></div>';
    } ?>

</footer>
</div>
<!--FERMETURE WRAPPER-->
<?php wp_footer(); ?>

<div class="fleche-hdpage" id="retour-haut">
    <i class="fas fa-arrow-up"></i>
</div>
</body>


</html>