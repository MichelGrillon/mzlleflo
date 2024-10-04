<?php
/* Template Name: Contact */

get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
        if (is_active_sidebar('sidebar-contact')) :
?>
            <aside id="colonneGauche">
                <?php dynamic_sidebar('sidebar-contact'); ?>
            </aside>
            <section id="pages" class="haut avecAside">
            <?php else : ?>
                <section id="pages" class="haut">
                <?php endif; ?>
                <h2><?php the_title(); ?></h2>
                <?php the_content(); ?>
                </section>
        <?php
    endwhile;
endif;
        ?>
        </main>

        <?php
        $google_map = get_theme_mod('my_google_map');
        if ($google_map) :
            $my_api = get_theme_mod('my_google_api');
            $my_lat = get_theme_mod('my_google_lat');
            $my_long = get_theme_mod('my_google_long');
            $my_zoom = get_theme_mod('my_google_zoom');
        ?>
            <div id="map" style="height: 400px; width: 100%;"></div>
            <script>
                (g => {
                    var h, a, k, p = "The Google Maps JavaScript API",
                        c = "google",
                        l = "importLibrary",
                        q = "__ib__",
                        m = document,
                        b = window;
                    b = b[c] || (b[c] = {});
                    var d = b.maps || (b.maps = {}),
                        r = new Set,
                        e = new URLSearchParams,
                        u = () => h || (h = new Promise(async (f, n) => {
                            await (a = m.createElement("script"));
                            e.set("libraries", [...r] + "");
                            for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                            e.set("callback", c + ".maps." + q);
                            a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                            d[q] = f;
                            a.onerror = () => h = n(Error(p + " could not load."));
                            a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                            m.head.append(a)
                        }));
                    d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
                })({
                    key: "<?php echo esc_js($my_api); ?>",
                    v: "weekly"
                });

                let map;

                async function initMap() {
                    const {
                        Map
                    } = await google.maps.importLibrary("maps");
                    const {
                        AdvancedMarkerElement
                    } = await google.maps.importLibrary("marker");

                    const position = {
                        lat: <?php echo floatval($my_lat); ?>,
                        lng: <?php echo floatval($my_long); ?>
                    };

                    map = new Map(document.getElementById("map"), {
                        zoom: <?php echo intval($my_zoom); ?>,
                        center: position,
                        mapId: "DEMO_MAP_ID",
                    });

                    const marker = new AdvancedMarkerElement({
                        map: map,
                        position: position,
                        title: "Notre emplacement",
                    });
                }

                initMap();
            </script>
        <?php
        endif;

        get_footer();
        ?>