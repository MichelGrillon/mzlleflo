<?php if (is_active_sidebar('sidebar-droite')) : ?>
    <aside id="colonneDroite">
        <?php dynamic_sidebar('sidebar-droite'); ?>
    </aside>
<?php endif; ?>
</main>
<?php if (is_active_sidebar('sidebar-bas')) : ?>
    <aside id="bas">
        <?php dynamic_sidebar('sidebar-bas'); ?>
    </aside>
<?php endif; ?>