document.addEventListener("DOMContentLoaded", function () {
    // Initialisation de la lightbox
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    });

    // Gestion du chargement infini
    const loadMoreButton = document.getElementById("load-more");
    if (loadMoreButton) {
        loadMoreButton.addEventListener("click", function () {
            const nextPage = parseInt(this.getAttribute("data-next-page"));
            const data = new FormData();
            data.append("action", "load_more_artworks");
            data.append("page", nextPage);
            data.append("nonce", artGallery.nonce); // Ajouter le nonce pour la sécurité

            fetch(artGallery.ajax_url, {
                method: "POST",
                body: data
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.text();
            })
            .then(data => {
                const newItems = document.createElement("div");
                newItems.innerHTML = data;

                document.querySelector(".art-gallery").appendChild(newItems);

                // Réinitialiser la lightbox après l'ajout de nouveaux éléments
                lightbox.init();

                // Mettre à jour le numéro de la prochaine page
                this.setAttribute("data-next-page", nextPage + 1);

                // Cacher le bouton si plus aucun article n'est chargé
                if (!newItems.childElementCount) {
                    this.style.display = "none";
                }
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });
        });
    }
});
