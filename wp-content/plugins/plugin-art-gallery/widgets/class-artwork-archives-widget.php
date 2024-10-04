<?php

class Artwork_Archives_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'artwork_archives_widget',
            __('Archives des Créations', 'textdomain'),
            array('description' => __('Affiche les archives des créations', 'textdomain'))
        );
    }

    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);

        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $artwork_archives = wp_get_archives(array(
            'post_type' => 'artwork',
            'type' => 'monthly',
            'echo' => 0
        ));

        if ($artwork_archives) {
            echo '<ul>' . $artwork_archives . '</ul>';
        } else {
            echo __('Aucune archive trouvée.', 'textdomain');
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Archives des Créations', 'textdomain');
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
