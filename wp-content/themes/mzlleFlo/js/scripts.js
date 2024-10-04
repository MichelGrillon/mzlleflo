 // Gestion de la recherche
jQuery(document).ready(function($) {
    $('.search-icon').click(function() {
        $('#searchform').toggleClass('visible');
    });
});

document.addEventListener("DOMContentLoaded", function () {
   
    // Gestion du menu mobile
    const mobileMenuIcon = document.getElementById("mobile-menu-icon"); // Récupère l'icône du menu mobile
    const menuPrincipal = document.getElementById("menuPrincipal"); // Récupère le menu principal

    // Lorsque l'icône de menu mobile est cliquée, le menu se déplie ou se replie
    mobileMenuIcon.addEventListener("click", function () {
        menuPrincipal.classList.toggle("open"); // Ajoute ou retire la classe "open" pour déplier ou replier le menu
    });
    document.addEventListener('DOMContentLoaded', function() {
    const toggleNav = document.getElementById('mobile-menu-icon');
    const menuPrincipal = document.getElementById('menuPrincipal');

    toggleNav.addEventListener('click', function() {
        menuPrincipal.classList.toggle('open');
    });
});

    // JavaScript pour la gestion des sous-menus en version mobile en lieu et place du "hover". vers.1
document.addEventListener('DOMContentLoaded', function () {
    var menuItems = document.querySelectorAll('#menuPrincipal > ul > li');

    menuItems.forEach(function (item) {
        item.addEventListener('click', function (event) {
            event.stopPropagation(); // Empêche la propagation de l'événement

            var submenu = this.querySelector('ul');
            if (submenu) {
                // Toggle the submenu
                submenu.classList.toggle('show');
            }
        });

        // Ajout d'un événement pour ne pas fermer le sous-menu si l'utilisateur survole le sous-menu
        item.addEventListener('mouseover', function () {
            var submenu = this.querySelector('ul');
            if (submenu) {
                submenu.classList.add('show');
            }
        });

        item.addEventListener('mouseout', function () {
            var submenu = this.querySelector('ul');
            if (submenu) {
                submenu.classList.remove('show');
            }
        });
    });

    document.addEventListener('click', function (event) {
        // Ferme tous les sous-menus lorsqu'on clique à l'extérieur
        if (!event.target.closest('#menuPrincipal')) {
            var submenus = document.querySelectorAll('#menuPrincipal ul.show');
            submenus.forEach(function (submenu) {
                submenu.classList.remove('show');
            });
        }
    });
});

    
    // JavaScript pour la gestion des sous-menus en version mobile en lieu et place du "hover".vers.2
document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('nav#menuPrincipal ul li');

    menuItems.forEach(item => {
        item.addEventListener('click', function(event) {
            const subMenu = item.querySelector('ul');
            if (subMenu) {
                event.preventDefault(); // Empêche le lien de rediriger
                subMenu.classList.toggle('active');
            }
        });
    });

    // Fermez les sous-menus lorsque vous cliquez en dehors du menu
    document.addEventListener('click', function(event) {
        if (!event.target.closest('nav#menuPrincipal')) {
            menuItems.forEach(item => {
                const subMenu = item.querySelector('ul');
                if (subMenu) {
                    subMenu.classList.remove('active');
                }
            });
        }
    });
});
    
    // Ajout le code pour la flèche de retour en haut de la page
    const retourHaut = document.getElementById("retour-haut");

    // Écoutez le défilement de la page
    window.addEventListener("scroll", function() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            retourHaut.style.display = "block";
        } else {
            retourHaut.style.display = "none";
        }
    });

    // Ajout un gestionnaire d'événements pour le clic sur la flèche
    retourHaut.addEventListener("click", function() {
        document.body.scrollTop = 0; // Pour les navigateurs Chrome, Safari
        document.documentElement.scrollTop = 0; // Pour les navigateurs Firefox, IE, Opera
    });

    
   
    // Initialisation de la lightbox
    lightbox.option({
        'resizeDuration': 200, // Durée de l'animation de redimensionnement
        'wrapAround': true // Permet de boucler les images
    });

    // Filtrage des œuvres d'art
    const filterCategory = document.getElementById('filter-category'); // Récupère le sélecteur de catégorie
    if (filterCategory) {
        filterCategory.addEventListener('change', function () {
            const category = this.value; // Récupère la catégorie sélectionnée
            const items = document.querySelectorAll('.art-gallery-item'); // Récupère tous les éléments de la galerie
            items.forEach(item => {
                if (category === '' || item.classList.contains(category)) {
                    item.style.display = 'block'; // Affiche l'élément s'il correspond à la catégorie sélectionnée
                } else {
                    item.style.display = 'none'; // Masque l'élément s'il ne correspond pas à la catégorie sélectionnée
                }
            });
        });
    }

    // Animation des images au survol
    const galleryItems = document.querySelectorAll('.art-gallery-item'); // Récupère tous les éléments de la galerie
    galleryItems.forEach(item => {
        item.addEventListener('mouseover', function () {
            this.style.transform = 'translateY(-10px) scale(1.05)'; // Anime l'élément en le déplaçant vers le haut et en l'agrandissant
            this.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.2)'; // Ajoute une ombre portée
        });
        item.addEventListener('mouseout', function () {
            this.style.transform = 'translateY(0) scale(1)'; // Réinitialise l'animation
            this.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)'; // Réinitialise l'ombre portée
        });
    });

    // Gestion du chargement infini
    const loadMoreButton = document.getElementById('load-more');
    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', function () {
            const nextPage = parseInt(this.getAttribute('data-next-page'), 10); // Récupère le numéro de la prochaine page
            const maxPages = parseInt(this.getAttribute('data-max-pages'), 10); // Récupère le nombre maximal de pages
            const selectedCategory = document.getElementById('filter-category').value; // Récupère la catégorie sélectionnée


            if (nextPage <= maxPages) {
                fetch(`${my_ajax_object.ajax_url}?action=load_more_artworks&page=${nextPage}&category=${selectedCategory}`, {
                    method: 'POST',
                })
                .then(response => response.text()) // Convertit la réponse en texte
                .then(data => {
                    const parser = new DOMParser(); // Crée un nouveau parseur DOM
                    const doc = parser.parseFromString(data, 'text/html'); // Parse le texte en un document HTML
                    const newItems = doc.querySelectorAll('.art-gallery-item'); // Récupère les nouveaux éléments de la galerie
                    newItems.forEach(item => {
                        document.querySelector('.art-gallery').appendChild(item); // Ajoute les nouveaux éléments à la galerie
                    });

                    // Réinitialiser les événements pour les nouveaux éléments
                    newItems.forEach(item => {
                        item.addEventListener('mouseover', function () {
                            this.style.transform = 'translateY(-10px) scale(1.05)';
                            this.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.2)';
                        });
                        item.addEventListener('mouseout', function () {
                            this.style.transform = 'translateY(0) scale(1)';
                            this.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
                        });
                    });

                    // Mettre à jour la lightbox pour les nouveaux éléments
                    lightbox.init();

                    loadMoreButton.setAttribute('data-next-page', nextPage + 1); // Met à jour le numéro de la prochaine page
                    if (nextPage + 1 > maxPages) {
                        loadMoreButton.style.display = 'none'; // Masque le bouton si toutes les pages ont été chargées
                    }
                });
            } else {
                loadMoreButton.style.display = 'none'; // Masque le bouton si toutes les pages ont été chargées
            }
        });
    }

    // Ajout du filtrage par catégorie
    if (filterCategory) {
        filterCategory.addEventListener('change', function () {
            const selectedCategory = this.value; // Récupère la catégorie sélectionnée
            fetch(`${my_ajax_object.ajax_url}?action=load_more_artworks&page=1&category=${selectedCategory}`, {
                method: 'POST',
            })
            .then(response => response.text()) // Convertit la réponse en texte
            .then(data => {
                const parser = new DOMParser(); // Crée un nouveau parseur DOM
                const doc = parser.parseFromString(data, 'text/html'); // Parse le texte en un document HTML
                const newItems = doc.querySelectorAll('.art-gallery-item'); // Récupère les nouveaux éléments de la galerie
                const artGallery = document.querySelector('.art-gallery'); // Récupère la galerie d'art
                artGallery.innerHTML = ''; // Réinitialise le contenu de la galerie
                newItems.forEach(item => {
                    artGallery.appendChild(item); // Ajoute les nouveaux éléments à la galerie
                });

                // Réinitialiser les événements pour les nouveaux éléments
                newItems.forEach(item => {
                    item.addEventListener('mouseover', function () {
                        this.style.transform = 'translateY(-10px) scale(1.05)';
                        this.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.2)';
                    });
                    item.addEventListener('mouseout', function () {
                        this.style.transform = 'translateY(0) scale(1)';
                        this.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
                    });
                });

                // Mettre à jour la lightbox pour les nouveaux éléments
                lightbox.init();

                loadMoreButton.setAttribute('data-next-page', 2); // Met à jour le numéro de la prochaine page
                loadMoreButton.style.display = newItems.length ? 'block' : 'none'; // Affiche ou masque le bouton en fonction du nombre d'éléments
            });
        });
    }
});

// JavaScript personnalisé pour la galerie d'art
jQuery(document).ready(function($) {
    // JavaScript personnalisé pour la galerie d'art
    $('.artwork-item').on('click', function() {
        var productId = $(this).data('product-id'); // Récupère l'ID du produit associé à l'œuvre d'art
        if (productId) {
            window.location.href = '/product/' + productId; // Redirige vers la page du produit
        }
    });
});


