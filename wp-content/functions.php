<?php

//creating guest blogger widget
class GuestBlogWidget extends WP_Widget {
    function __construct() {
        parent::__construct('guest_blog_widget', 'Guest Blogger', array(
            'description' => 'Widget for Guest Bloggers signup'
        ));
    }

    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);

        echo $args['before_widget'];
        if(!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        echo '<h1>Hello world from my widget</h1>';
        echo '<p>Some sample widget content</p>';

        echo $args['after_widget'];
    }

    public function form($instance) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = 'New title';
        }
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">'Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php

    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }
}

function guest_logger_load_widget() {
    register_widget('GuestBlogWidget');
}

add_action('widgets_init', 'guest_logged_load_widget');