jQuery(document).ready(function($) {
    // Gère l'ouverture du menu
    $('.menu-item-has-children').on('click', function(event) {
        event.stopPropagation();
        var $submenu = $(this).children('.sub-menu');

        // Cache les autres sous-menus
        $('.sub-menu').not($submenu).slideUp('fast');

        // Basculer l'affichage du sous-menu cliqué
        $submenu.slideToggle('fast');
    });

    // Cache les sous-menus lorsque l'utilisateur clique en dehors
    $(document).on('click', function() {
        $('.sub-menu').slideUp('fast');
    });
});
