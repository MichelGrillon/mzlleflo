# mzlleflo
Projet Site d'une artiste - theme et plugins wordpress

Cahier des charges :

Présentation d’ensemble :
Le cahier des charges prévoit la création d'un site vitrine pour une artiste, destiné aux particuliers. 

Design :
Le design, adapté aux mobiles, doit être simple, intuitif et refléter les activités de l'artiste. 
Les polices Google choisies sont Great Vibes pour les titres, Send Flowers pour les catégories/menu et Playwrite Norge pour les textes.

Utilisation de fontes Google :
------------------------------
Head : Great vibes
Catégories/Menu : Send flowers
Textes : Playwrite norge


Contenu du site :
Le site comprendra plusieurs pages : 
Accueil, Galerie + Boutique, Contact, Actualités/News, Partenaires, Tutoriels, À propos, Conditions générales de vente, Conditions générales d'utilisation, Mentions légales, Mon compte et Mon panier. 

Fonctionnalités :
Parmi les fonctionnalités, on retrouve un espace client sécurisé, une administration accessible pour l'artiste, une galerie marchande combinée avec une galerie classique, un thème original et personnalisé, et la gestion des commandes, clients, stocks et articles via Woo commerce.

Plugins :
Des plugins sont prévus pour l'intégration des réseaux sociaux (Facebook, Instagram, Tumblr), une page de contact avancée avec formulaire personnalisable, intégration Google Maps et notifications par e-mail, et une galerie d'art interactive permettant d'ajouter et gérer les œuvres, avec affichage en grille ou carrousel et option de commentaires pour les visiteurs.


A.	Description détaillé des pages du site et spécifications fonctionnelles

Les articles, produits, et autres contenus seront mis à jour par la cliente. La fréquence de mise à jour dépendra du temps d'exécution de ses créations, des retours de location et donc des disponibilités des produits, de ses recherches de news et tutoriels…


Page 1 : Accueil
Description du contenu et des fonctionnalités sur cette page :
•	Derniers articles (5), 
•	Derniers produits (9), 
•	Dernières créations (5), 
•	Les types de créations (4), 
•	Widgets (produits en boutique, archives des créations, Catégories d'art, mots-clés)
Mis à jour par la cliente dés que possible (pas de fréquence définie)



Page 2 : Actualités
Articles sur les créations en cours d'exécution


Page 3 : Galerie d'art

Affichage par sous-menus répartis en catégories, des différentes créations :

-	Bijoux
-	Acrylique
-	Aquarelle
-	Noir et blanc
-	Cadre

-	Page 4 : Boutique

Comme son nom le laisse supposer, la porte d'entrée vers la vente et location de ses œuvres, réparties la aussi en catégories :
-	Bijoux, 
-	Cadres, 
-	Peintures 
o	Acrylique
o	Aquarelle
o	Noir et blanc


Page 5 : Tutoriels
Des articles (et des liens) vers des tutoriels en relations avec la création, peintures etc.


Page 6 : Partenaires
Page regroupant des liens vers les fournisseurs de l'artiste


Page 7 : Mon compte
Pour toute la gestion du compte, la connexion …
Dans le détail :
-	Se connecter, se déconnecter, 
-	Changer de mot de passe (volontairement ou suite à oubli)
-	Modifier coordonnées
-	Moyen de paiements
-	Accéder à ses téléchargements
-	Accéder à ses commandes


Page 8 : Mon panier
Pour toute la gestion du panier, produits, etc.

Page 9 : Contact

Pour contacter la cliente.
>	Accède à un formulaire de contact
>	Oblige les internautes à renseigner au moins 4 champs : nom, prénom, email, ville
Insertion d'une Google maps


Page 10 : A propos
Pour en savoir plus sur la cliente


Page 11 : Plan du site
Comme son nom l'indique, le référencement de toutes les pages du site



Sans oublier les pages obligatoires (via menu footer) :
•	Mentions Légales 
•	CGU – CGV 
•	Confidentialité 
•	Cookies 

Et l'accès aux réseaux sociaux de la cliente via la aussi le menu footer .

- modifications des fichiers :
wp-content/plugins/woocommerce/templates/single-product/add-to-cart/variable.php vers wp-content/themes/mzlleFlo/woocommerce/single-product/add-to-cart/variable.php : pour afficher les informations de paiement.
wp-content/plugins/woocommerce/templates/checkout/review-order.php vers wp-content/themes/mzlleFlo/woocommerce/checkout/review-order.php : pour afficher les informations de paiement.
wp-content/plugins/woocommerce/templates/cart/cart-totals.php vers wp-content/themes/mzlleFlo/woocommerce/cart/cart-totals.php : pour afficher la caution.

=> ne fonctionne pas actuellement, en cours de résolution => utilisations d'extensions dédiées (pour WooCommerce) si toujours ko, lors de la mise en ligne du site.


Extensions pour WooCommerce :  
- WooPayments
Si pas de résolutions des fichiers :
- WooCommerce Conditional Payment Gateways => pour gérer les passerelles de paiement conditionnelles basées sur les catégories de produits.
- "WooCommerce Deposits" ou "YITH WooCommerce Deposits and Down Payments" => permet de gérer les dépôts ou les cautions.

- C.	Adaptation pour le web mobile

Elle se fait principalement pat le fichier style.css, découpé en 4 "parties :

-	Partie globale, pour les styles qui ne dépendront pas des résolutions et seront communs à tous les types 
-	Partie Desktop qui ne gèrera que les grandes résolutions
-	Partie tablette
-	Partie mobile

-	Cela concerne bien évidement d'autres éléments de la page, comme l'apparition du menu burger et de son icone, lorsque l'on passe de desktop vers les résolutions inférieures, alors que ceux-ci sont cachés en mode desktop. 

Création de modèles de pages : 
==============================
404.php (fameux erreur 404...)
contact.php : pour le formulaire de contact
header.php et footer.php : header et footer personnalisés
page-full.php (sans sidebar)
sidebar.php : affichage des sidebars
archive.php et category.php (page d’archives des articles classés par catégories)
single.php (affichage d'un seul post)
taxonomy-art-category.php : afficher le type de contenu personnaliser (archives, categories) relatif à l'extension plugin-art-gallery (article "artwork")

Options personnalisées développées du thème :
=============================================
Couleurs (du texte d'entête, d'arrière plan, du texte)
Typographie : choix des fontes, tailles, Gras, Italique pour : menu, entête, texte global, catégories, footer
Art-gallery (cf extension) : nombre d'image par page, taille des images, effet de transition, couleurs fond et bordure d'image, durée d'animation, affichage flèche navigation, bouton de fermeture, légende et numéros d'images
Page contact - Google map : clé API, latitude, longitude, Zoom
Image d'entête 
Layout: taille de la sidebar
Footer : montrer le copyright ou pas, Téléphone, Adresse, URL facebook et Tumblr

==================================================================================================================

Widgets : 
- Categories d'art : affichage des créations, par catégories
- Archives des Créations : affichages des dernières Créations
Pour les deux widgets, voir la partie extension "Plugin-art-gallery" pour plus d'informations.

==================================================================================================================

Extensions : 

plugin-social-media : 
- création d'une application Facebook (via Facebook for Developers : Créer uune application)
Description: Un plugin pour automatiser la publication des nouveaux produits sur les réseaux sociaux.
Fonctionnalités:
Connexion aux comptes de réseaux sociaux (Facebook, Instagram, Twitter).
Publication automatique des nouveaux produits avec images et descriptions.
Interface pour programmer des publications.
Annulé : Facebook a restreint l'accès à certaines permissions, notamment celles permettant de publier directement sur le mur personnel d'un utilisateur. Sauf à faire une application commerciale ou de jeux, dont d'utiliser la version pâyante de l'API (for business…)…
L'application est créée mais n'a pas les droits nécessaires… désactivation de l'extension.

=====================================================

- Page de Contact Avancée
Description: Un plugin pour créer une page de contact avec des fonctionnalités avancées.
Fonctionnalités:
Formulaire de contact avec options personnalisables (champs, validations, etc.).
Intégration avec Google Maps pour afficher l'atelier ou la galerie.
Notifications par e-mail pour chaque soumission de formulaire.
Création du modèle de page "contact.php, ajout de short code : [advanced_contact_form] pour le formulaire et [google_maps address="123 Rue de l'Exemple, Ville, Pays" zoom="15" width="100%" height="400px"] pour la carte.
Création d'une page de remerciement qui apparait après la soumission du formulaire.


=====================================================

plugin-art-gallery :
- Créer des œuvres d'art dans WooCommerce automatiquement lorsqu'elles sont créées dans la galerie d'art: créer une taxonomie personnalisée 'art_category' pour le type de publication personnalisée 'artwork'. Définition d'un modèle de page pour afficher les archives de taxonomie : taxonomy-art_category.php qui servira pour les deux widgets personnalisés (class-artwork-archives-widget.php et class-art-categories-widget.php, pour afficher les archives des créations et des catégories dédiées, voir plus loin). 
- Mettre à jour les produits WooCommerce lorsque les œuvres d'art sont modifiées (bug en cours d'analyse).
- Modification de la Boucle de Produits :
Pour chaque produit, nous récupérons l'ID de l'œuvre d'art associée en utilisant get_post_meta($product_id, '_artwork_id', true).
Si une œuvre d'art est associée, nous affichons ses détails (image, titre et prix).
Sinon, nous affichons le modèle de contenu du produit WooCommerce par défaut.

Modification du fichier archive-product.php de woocommerce en template dans le dossier mon dossier thème :
-Header des Produits : Gardez le header original pour afficher le titre de la page et la description de l'archive.
-Filtres de la Galerie d'Art : Ajoutez des filtres pour les catégories de produits.
-Boucle de Produits WooCommerce : Inclure la logique pour afficher les œuvres d'art personnalisées.
-Annulé => Chargement Infini : Ajoutez le bouton de chargement infini après la boucle de produits

Créations de quatres scripts (dans le fichier scripts.js) : 
- Annulé => Lightbox pour Agrandir les Images
- Annulé :Filtrage des Œuvres d'Art
- Animation des Images au Survol
- Annulé => Chargement Infini (Infinite Scroll)

Créations de deux widgets : "class-art-categories-widget.php" et "class-artwork-archives-widget" dans un sous dossier "widgets" : wp-content/plugins/plugin-art-gallery/widgets/

Création de l'extension "plugin-art-gallery-block" : permet de créer un block pour les archives et un bloc pour les catégories, créer par l'extension "plugin-art-gallery"et à partir de ses deux widgets.
Ces blocs sont donc plaçable n'importe où, contrairement aux widgets qui ne sont plaçables que dans les sidebars et footer.

On a donc :

Pour plugin-art-gallery : 
wp-content/plugins/plugin-art-gallery/plugin-art-gallery.php, 
puis : 
wp-content/plugins/plugin-art-gallery/render-functions.php
puis :
wp-content/plugins/plugin-art-gallery/css/lightbox.css
puis :
wp-content/plugins/plugin-art-gallery/js/art-gallery.js
puis :
wp-content/plugins/plugin-art-gallery/js/lightbox.js
puis :
wp-content/plugins/plugin-art-gallery/widgets/class-art-categories-widget.php
puis :
wp-content/plugins/plugin-art-gallery/widgets/class-artwork-archives-widget.php

Pour plugin-art-gallery-blocks :
wp-content/plugins/plugin-art-gallery-blocks/plugin-art-gallery-blocks.php
puis :
wp-content/plugins/plugin-art-gallery-blocks/css/art-gallery-blocks.css
puis :
wp-content/plugins/plugin-art-gallery-blocks/js/art-gallery-blocks.js

==================================================================================================================

Scripts.js
Explications de scripts.js :

Récupère l'icône du menu mobile : la variable mobileMenuIcon récupère l'élément avec l'ID mobile-menu-icon.

Récupère le menu principal : la variable menuPrincipal récupère l'élément avec l'ID menuPrincipal.

Ajoute ou retire la classe "open" pour déplier ou replier le menu : la méthode classList.toggle("open") ajoute ou retire la classe open pour déplier ou replier le menu.

Récupère le bouton de retour en haut de page : la variable retourHaut récupère l'élément avec l'ID scroll-top.

Affiche le bouton de retour en haut de page : le bouton de retour en haut de page est affiché lorsque l'utilisateur fait défiler la page de plus de 300px.

Masque le bouton de retour en haut de page : le bouton de retour en haut de page est masqué lorsque l'utilisateur n'a pas fait défiler la page de plus de 300px.

Défile vers le haut de la page : la méthode window.scrollTo fait défiler la page vers le haut.

Défile en douceur : l'option behavior: "smooth" fait défiler la page en douceur.

Récupère l'ID du produit associé à l'œuvre d'art : la méthode $(this).data('product-id') récupère l'ID du produit associé à l'œuvre d'art.

Redirige vers la page du produit : la méthode window.location.href redirige l'utilisateur vers la page du produit.

Récupère le sélecteur de catégorie : la variable filterCategory récupère l'élément avec l'ID filter-category.

Récupère la catégorie sélectionnée : la variable category récupère la valeur sélectionnée dans le sélecteur de catégorie.

Récupère tous les éléments de la galerie : la méthode document.querySelectorAll('.art-gallery-item') récupère tous les éléments de la galerie.

Affiche l'élément s'il correspond à la catégorie sélectionnée : l'élément est affiché s'il correspond à la catégorie sélectionnée.

Masque l'élément s'il ne correspond pas à la catégorie sélectionnée : l'élément est masqué s'il ne correspond pas à la catégorie sélectionnée.

Anime l'élément en le déplaçant vers le haut et en l'agrandissant : l'élément est animé en le déplaçant vers le haut et en l'agrandissant.

Ajoute une ombre portée : l'élément reçoit une ombre portée.

Réinitialise l'ombre portée : l'ombre portée de l'élément est réinitialisée.

Récupère le bouton de chargement de plus de contenu : la variable loadMoreButton récupère l'élément avec l'ID load-more.

Récupère le numéro de la prochaine page : la variable nextPage récupère le numéro de la prochaine page.

Récupère le nombre maximal de pages : la variable maxPages récupère le nombre maximal de pages.

Fait une requête pour charger la prochaine page : la méthode fetch fait une requête pour charger la prochaine page.

Convertit la réponse en texte : la méthode response.text() convertit la réponse en texte.

Crée un nouveau parseur DOM : la méthode new DOMParser() crée un nouveau parseur DOM.

Parse le texte en un document HTML : la méthode parser.parseFromString parse le texte en un document HTML.

Récupère les nouveaux éléments de la galerie : la méthode doc.querySelectorAll('.art-gallery-item') récupère les nouveaux éléments de la galerie.

Ajoute les nouveaux éléments à la galerie : les nouveaux éléments sont ajoutés à la galerie.

Réinitialiser les événements pour les nouveaux éléments : les événements sont réinitialisés pour les nouveaux éléments.

Mettre à jour la lightbox pour les nouveaux éléments : la lightbox est mise à jour pour les nouveaux éléments.


Options personnalisées développées du thème :
=============================================
Couleurs (du texte d'entête, d'arrière plan, du texte)
Typographie : choix des fontes, tailles, Gras, Italique pour : menu, entête, texte global, catégories, footer
Art-gallery (cf extension) : nombre d'image par page, taille des images, effet de transition, couleurs fond et bordure d'image, durée d'animation, affichage flèche navigation, bouton de fermeture, légende et numéros d'images
Page contact - Google map : clé API, latitude, longitude, Zoom
Image d'entête 
Layout: taille de la sidebar
Footer : montrer le copyright ou pas, Téléphone, Adresse, URL facebook et Tumblr

=====================================================

Commentés, bug en cours d'analyse (affichage incorrecte) :

- Permet de boucler les images : l'option wrapAround permet de boucler les images dans la lightbox.
- Durée de l'animation de redimensionnement : l'option resizeDuration définit la durée de l'animation de redimensionnement de la lightbox.
- Réinitialise l'animation : l'animation de l'élément est réinitialisée.
- Met à jour le numéro de la prochaine page : le numéro de la prochaine page est mis à jour.
- Masque le bouton si toutes les pages ont été chargées : le bouton est masqué si toutes les pages ont été chargées.
- => création du fichier art-gallery.js et de son dossier dans wp-content/plugins (et des sous-dossier "js" et "css" dans le dossier de l'extension, et sous-dossier widgets)
=> mise à jour de scripts.js pour ajout lightbox (actellement commenté, à la demande de la cliente)
=> import de https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js et de https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.css => création de lightbox.js (dossier js) et de lightbox.css (dossier css du plugin). => annulé par la cliente, plus d'utilisation de Lightbox.
Le shortcode [art_gallery] génère la galerie d'art, affichant les œuvres sous forme de vignettes : Annulé => Chaque vignette est liée à une lightbox pour afficher l'image en grand format. Le bouton "Charger plus" utilise AJAX pour charger plus d'œuvres sans recharger la page.
•	Affichage de la galerie d'art : Un shortcode [art_gallery] permet d'afficher la galerie d'art sur une page. Cette galerie devait inclure des fonctionnalités de lightbox pour afficher les images en grand format, ainsi que le chargement infini pour charger plus d'œuvres au fur et à mesure que l'utilisateur fait défiler la page. ( la cliente à fini annuler ces effets). Lightbox désinstallé...
- Annulé => Requêtes AJAX pour le chargement infini des œuvres d'art.
- l'erreur "wp_enqueue_style"... lors de l'utilisation d'un plugin, mais malgrés cette erreur le plugin fonctionne. En cours...
- Il reste quelques bugs (mineurs) et éventuellement quelques ajustements esthétiques concernant la mise en page...

==============================================================================================================================================

mzlleflo
Project: Artist's Website - WordPress theme and plugins

Specifications:

Overall presentation: The project requires the creation of a showcase website for an artist, aimed at individual customers.

Design: The design should be mobile-friendly, simple, intuitive, and reflect the artist’s activities. The chosen Google Fonts are Great Vibes for titles, Send Flowers for categories/menu, and Playwrite Norge for text.

Google Fonts usage:
Headings: Great Vibes Categories/Menu: Send Flowers Text: Playwrite Norge

Website content: The site will include several pages: Home, Gallery + Shop, Contact, News, Partners, Tutorials, About, Terms and Conditions of Sale, Terms of Use, Legal Notice, My Account, and My Cart.

Features: Key features include a secure client area, easy administration for the artist, a combined classic and shop gallery, an original and customized theme, and management of orders, clients, stock, and products via WooCommerce.

Plugins: Planned plugins include social media integration (Facebook, Instagram, Tumblr), an advanced contact page with a customizable form, Google Maps integration, and email notifications. There will also be an interactive art gallery to add and manage artworks, displayed in a grid or carousel with comment options for visitors.

A. Detailed page descriptions and functional specifications

The client will update the articles, products, and other content. The update frequency will depend on the creation time, product availability, and new tutorials or news.

Page 1: Home Content and functionalities: • Latest articles (5) • Latest products (9) • Latest creations (5) • Creation types (4) • Widgets (shop products, creation archives, art categories, keywords) Updated by the client when possible (no set frequency).

Page 2: News Articles on ongoing creations.

Page 3: Art Gallery Displayed through submenus organized by categories of creations:

Jewelry
Acrylic
Watercolor
Black and white
Frames

Page 4: Shop As its name suggests, this is the entrance to selling and renting her works, also organized into categories:

Jewelry
Frames
Paintings o Acrylic o Watercolor o Black and white

Page 5: Tutorials Articles (and links) to tutorials related to creation, painting, etc.

Page 6: Partners A page listing the artist’s suppliers.

Page 7: My Account For account management, login, etc. Details include:

Log in, log out
Change password (voluntarily or after a forgotten password)
Update personal details
Manage payment methods
Access downloads
View orders

Page 8: My Cart For managing the shopping cart, products, etc.

Page 9: Contact For contacting the client.

Access to a contact form Visitors must fill in at least 4 fields: first name, last name, email, city Includes a Google map.

Page 10: About To learn more about the artist.

Page 11: Sitemap A full index of all website pages.

Mandatory pages (via the footer menu): • Legal notice • Terms and Conditions of Sale (TCS) and Terms of Use (TOU) • Privacy policy • Cookie policy

Social media links will also be accessible via the footer.

Modifications to files:

wp-content/plugins/woocommerce/templates/single-product/add-to-cart/variable.php to wp-content/themes/mzlleFlo/woocommerce/single-product/add-to-cart/variable.php: for displaying payment information.
wp-content/plugins/woocommerce/templates/checkout/review-order.php to wp-content/themes/mzlleFlo/woocommerce/checkout/review-order.php: for displaying payment information.
wp-content/plugins/woocommerce/templates/cart/cart-totals.php to wp-content/themes/mzlleFlo/woocommerce/cart/cart-totals.php: for displaying deposits.
Currently not functional, under resolution. Using dedicated WooCommerce plugins if unresolved at the website launch.

WooCommerce plugins:

WooPayments If file issues persist:
WooCommerce Conditional Payment Gateways: to manage payment gateways based on product categories.
"WooCommerce Deposits" or "YITH WooCommerce Deposits and Down Payments": to manage deposits or security payments.

B. Mobile Web Adaptation

Mainly done via the style.css file, split into 4 parts:

Global part for styles common to all resolutions
Desktop part for large resolutions
Tablet part
Mobile part
This includes elements like the burger menu icon that appears when transitioning from desktop to smaller resolutions, while hidden in desktop mode.

Custom page templates:
404.php (the famous 404 error...) contact.php: for the contact form header.php and footer.php: customized header and footer page-full.php (without sidebar) sidebar.php: for sidebar display archive.php and category.php (archive pages for posts by category) single.php (displaying a single post) taxonomy-art-category.php: displays customized content (archives, categories) for the art gallery plugin (artwork post type).

Custom theme options:
Colors (header text, background, and general text)
Typography: font selection, sizes, bold/italic for menu, header, global text, categories, footer
Art gallery (see plugin): number of images per page, image size, transition effects, background and border colors, animation duration, arrow navigation display, close button, captions, and image numbering
Contact page - Google Maps: API key, latitude, longitude, zoom level
Header image
Layout: sidebar size
Footer: display copyright or not, phone number, address, Facebook and Tumblr URLs

WordPress Theme Files

The WordPress theme will include custom post types, custom fields, and a taxonomy dedicated to displaying artworks.
This will allow the website administrator to easily manage new product updates, photos, texts, and product descriptions from the WordPress admin interface.

Features for the Client
Content Management:
The client will be able to manage:

News articles,
Products (adding, removing, modifying prices, stock, etc.),
Artworks in the gallery (same functionalities as for products),
Partners (management of partner links),
Tutorials,
Orders,
Customer profiles.
All this will be possible from the WordPress dashboard.

Custom Post Types (CPT):
Custom post types will be created for:

Artworks (which will integrate with the gallery and shop),
News articles,
Tutorials,
Partners.
Each custom post type will have its corresponding fields (title, description, images, etc.) for easy management.

Taxonomies:
Custom taxonomies will be used to categorize the products and artwork by type:

Product Categories (e.g., Jewelry, Acrylic Paintings, Watercolors, etc.),
Art Categories (e.g., Jewelry, Black & White, Frames, etc.).
These taxonomies will allow easy filtering and navigation through the products and artworks displayed on the website.

Art Gallery Plugin
The website will feature an interactive gallery, managed via a custom WordPress plugin.
The gallery will allow users to browse through the artist’s creations, categorized by type (e.g., paintings, jewelry, etc.).
Each artwork will have its dedicated page showing details such as the name, dimensions, medium, price (for those on sale), and other relevant info.

Gallery Display Options:
Grid view: Shows multiple artworks in a grid layout.
Carousel view: A scrolling display of artworks, one at a time, or a few depending on the screen size.
The gallery will also feature visitor interaction options, including:

Visitor comments: Visitors will be able to leave comments under each artwork.
Social sharing buttons: For sharing individual artworks on social media platforms.
The plugin will integrate with WooCommerce to enable purchasing or renting artworks directly from the gallery.

WooCommerce Integration
The website will use WooCommerce to handle all sales and rentals.
WooCommerce will provide the necessary functionalities for managing the products, stock, orders, and customer information.

Products:
Products will be grouped into different categories:

Jewelry,
Paintings,
Frames,
Black & White Artworks,
Acrylic Artworks,
Watercolors.
Each product page will display:

Product name,
Description,
Images,
Stock availability,
Pricing (with options for discounts, promotions, and sales),
Rental options for certain items.
WooCommerce Modifications:
The WooCommerce product and checkout pages will be customized to suit the artist's specific needs, such as:

Displaying special information (e.g., rental terms),
Managing deposits or down payments for artworks.
As previously mentioned, custom templates for WooCommerce will be used for:

Product pages,
Checkout page,
Cart page.
If custom modifications do not work, appropriate WooCommerce plugins (e.g., for deposits) will be employed.

Security:
The site will implement standard WordPress security practices:

Regular updates for WordPress, themes, and plugins,
Use of security plugins (e.g., Wordfence) to protect against attacks,
HTTPS encryption for secure transactions.
Email Notifications:
Both the client (site admin) and customers will receive email notifications for important events, such as:

Client: New orders, new customer registrations, stock updates.
Customers: Order confirmations, shipping details, password resets, etc.
Responsive Design:
As mentioned earlier, the site will be fully responsive and optimized for mobile devices.
The design will adapt to different screen sizes, ensuring a seamless browsing experience for users on desktops, tablets, and smartphones.


Commented, issue under analysis (display problem):

Allows looping through images: The wrapAround option enables looping through images in the lightbox.
Resizing animation duration: The resizeDuration option defines the duration of the lightbox's resizing animation.
Resets the animation: The element’s animation is reset.
Updates the next page number: The next page number is updated.
Hides the button if all pages have been loaded: The button is hidden if all pages have been loaded.
=> Creation of the art-gallery.js file and its folder under wp-content/plugins (and subfolders "js" and "css" in the plugin folder, and "widgets" subfolder).
=> Update of scripts.js to add lightbox (currently commented, as requested by the client).
=> Import of https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js and https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.css.
=> Creation of lightbox.js (in the js folder) and lightbox.css (in the plugin’s css folder).
=> Cancelled by the client, no more usage of Lightbox.
The shortcode [art_gallery] generates the art gallery, displaying artworks as thumbnails: Cancelled.
Each thumbnail is linked to a lightbox to display the image in a larger format. The "Load More" button uses AJAX to load more artworks without refreshing the page.

Art gallery display: A shortcode [art_gallery] is used to display the art gallery on a page. This gallery was supposed to include lightbox functionality for displaying images in a larger format, as well as infinite scrolling to load more artworks as the user scrolls down. (The client eventually cancelled these features). Lightbox uninstalled...
Cancelled: AJAX requests for infinite loading of artworks.
The error "wp_enqueue_style"... when using a plugin, but despite this error, the plugin works. Still under analysis...
There are a few minor bugs remaining and possibly some aesthetic adjustments concerning the layout...






