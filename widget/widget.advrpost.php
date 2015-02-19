<?php
/**
 * Adds Advertisement widget.
 */
class Adv_Recent_Post_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'adv_widget', // Base ID
            'Advanced Recent Post Widget', // Name
            array( 'description' => __( 'An Advanced Recent Post Widget', 'tmthree' ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        $adv_url = $instance['adv_url'];
        $mediaid = $instance['mediaid'];
        $attach = wp_prepare_attachment_for_js($mediaid);

        $thumbs = $attach['sizes']['thumbnail']['url'];
        echo $before_widget;

        if (empty( $title ) ){
            $title =  "";
        }
        ?>

        <div class="adv-item">
            <?php if($thumbs){ ?>
                <a href="<?php if($adv_url){ echo $adv_url; } else{ echo "#"; } ?>" title="<?php echo $title; ?>">
                    <img src='<?php echo $thumbs; ?>' alt="<?php echo $title; ?>" />
                    <p><?php echo $title; ?></p>
                </a>
            <?php } ?>
        </div>

        <?php
        echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['mediaid'] = strip_tags( $new_instance['mediaid'] );
        $instance['adv_url'] = strip_tags( $new_instance['adv_url'] );

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */

    public function form( $instance ) {

        // widget title not post title
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'Widget Title', 'tmthree' );
        }

        // all post type
        if(isset($instance['post_type_name'])){
            $post_type_name = $instance['post_type_name'];
        }

        // number of post display
        if(isset($instance['number_of_post'])){
            $number_of_post = $instance['number_of_post'];
        }else{
            $number_of_post = 4;
        }

        // show thumbs
        if(isset($instance['show_thumbs'])){
            $show_thumbs = $instance['show_thumbs'];
        }else{
            $show_thumbs = 1;
        }



        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>



    <?php
    }

} // class Adv_Widget


/// init 
/// 


function init_adv_recent_post_widget(){
    register_widget('Adv_Recent_Post_Widget');
}

add_action('widgets_init', 'init_adv_recent_post_widget');
