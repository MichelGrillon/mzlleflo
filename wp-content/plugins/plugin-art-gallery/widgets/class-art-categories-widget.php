<?php

class Art_Categories_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'art_categories_widget',
            __('Catégories d\'Art', 'textdomain'),
            array('description' => __('Affiche les catégories d\'art', 'textdomain'))
        );
    }

    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);

        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $art_categories = get_terms(array(
            'taxonomy' => 'art_category',
            'hide_empty' => false,
        ));

        if (!empty($art_categories) && !is_wp_error($art_categories)) {
            echo '<ul>';
            foreach ($art_categories as $category) {
                echo '<li><a href="' . get_term_link($category) . '">' . $category->name . '</a></li>';
            }
            echo '</ul>';
        } else {
            echo __('Aucune catégorie d\'art trouvée.', 'textdomain');
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Catégories d\'Art', 'textdomain');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titre:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

?>