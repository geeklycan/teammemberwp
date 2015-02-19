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
        $post_type_name     = $instance['post_type_name'];
        $number_of_post     = $instance['number_of_post'];
        $show_thumbs        = $instance['show_thumbs']; // 1 = show ; otherwise not
        $display_style      = $instance['display_style']; // 0 = vertical ; 1 = horizontal;
        $post_title_show    = $instance['post_title_show']; // 1 = yes; 0 = no;

        echo $before_widget;

        if (!empty( $title ) ){
            echo "<h2>". $title. "</h2>";
        }

        $cls = "col-md-12";
        if(1 == $display_style){
            // horizontal style
            $cls = "col-md-3";
        }
        ?>

        <div class="row">
            <?php
                global $post;
                $postdata = get_latest_cpt($post_type_name, $number_of_post);
                foreach ( $postdata as $post ) : setup_postdata( $post );
            ?>
            <div class="<?php echo $cls; ?>">
                <a href="<?php the_permalink(); ?>" <?php if ($post_title_show == 1){ echo 'title="'.get_the_title($post->ID).'"'; } ?>>
                <?php if($show_thumbs){
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail('thumbnail');
                    }
                }?>
                <?php if ($post_title_show == 1){ echo "<h3>".get_the_title($post->ID)."</h3>"; } ?>
                </a>
            </div>
                    <?php
                endforeach;
            wp_reset_postdata();
            wp_reset_query();
            ?>
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
        $instance['post_type_name'] = strip_tags( $new_instance['post_type_name'] );
        $instance['number_of_post'] = strip_tags( $new_instance['number_of_post'] );
        $instance['show_thumbs'] = strip_tags( $new_instance['show_thumbs'] );
        $instance['display_style'] = strip_tags( $new_instance['display_style'] );
        $instance['post_title_show'] = strip_tags($new_instance['post_title_show']);

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     * @return string|void
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
        }else{
            $post_type_name = '';
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

        // 0 = vertical ; 1 = horizontal
        if(isset($instance['display_style'])){
            $display_style = $instance['display_style'];
            if(0 == $display_style){
                $vertical = true;
                $horizontal = false;
            }else{
                $horizontal = true;
                $vertical = false;
            }
        }else{
            $vertical = true;
            $horizontal = false;
        }

        // 1= yes ; 0 = no;
        if(isset($instance['post_title_show'])){
            $post_title_show = $instance['post_title_show'];

            if( 1 == $post_title_show ){
                $yes = true;
                $no = false;
            }else{
                $yes = false;
                $no = true;
            }

        }else{
            $yes = true;
            $no = false;
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('post_type_name'); ?>"><?php _e( 'Post Type: '); ?>
                <select class='widefat' id="<?php echo $this->get_field_id('post_type_name'); ?>"
                        name="<?php echo $this->get_field_name('post_type_name'); ?>" >

                    <?php
                    $post_types = $this->get_all_post_type();
                    foreach($post_types AS $post_type):
                        if("attachment" != $post_type):
                    ?>
                    <option value='<?php echo $post_type; ?>'<?php echo ($post_type_name == $post_type)?'selected':''; ?>>
                        <?php echo $post_type; ?>
                    </option>

                    <?php
                        endif;
                        endforeach; ?>

                </select>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'number_of_post' ); ?>"><?php _e( 'Number Of Post:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'number_of_post' ); ?>" name="<?php echo $this->get_field_name( 'number_of_post' ); ?>" type="text" value="<?php echo esc_attr( $number_of_post ); ?>" />
        </p>

        <p>
            <input class="checkbox" type="checkbox" value="1" <?php checked($show_thumbs, 1); ?> id="<?php echo $this->get_field_id('show_thumbs'); ?>" name="<?php echo $this->get_field_name('show_thumbs'); ?>" />
            <label for="<?php echo $this->get_field_id('show_thumbs'); ?>"><?php _e( 'Show Thumbnails: '); ?></label>
        </p>



        <p>
           <label for="<?php echo $this->get_field_id( 'display_style' ); ?>"><?php _e('Display Style: '); ?></label>
           <label>
               <input type="radio" name="<?php echo $this->get_field_name('display_style'); ?>" id="<?php $this->get_field_name('display_style'); ?>" value="0" <?php checked($vertical, true); ?>/>
        <?php _e( 'Vertical'); ?>
           </label>
            <label>
               <input type="radio" name="<?php echo $this->get_field_name('display_style'); ?>" id="<?php $this->get_field_name('display_style'); ?>" value="1" <?php checked($horizontal, true); ?>/>
        <?php _e( 'Horizontal'); ?>
           </label>
        </p>



        <p>
            <label for="<?php echo $this->get_field_id( 'post_title_show' ); ?>"><?php _e('Show Post Title: '); ?></label>
            <label>
                <input type="radio" name="<?php echo $this->get_field_name('post_title_show'); ?>" id="<?php $this->get_field_name('post_title_show'); ?>" value="1" <?php checked($yes, true); ?>/>
                <?php _e( 'Yes'); ?>
            </label>
            <label>
                <input type="radio" name="<?php echo $this->get_field_name('post_title_show'); ?>" id="<?php $this->get_field_name('post_title_show'); ?>" value="0" <?php checked($no, true); ?>/>
                <?php _e( 'No'); ?>
            </label>
        </p>


    <?php
    }


    private function get_all_post_type(){
        $args = array('public' => true);
        return get_post_types($args, 'names');
    }
} // class Adv_Widget


/// init 
/// 


function init_adv_recent_post_widget(){
    register_widget('Adv_Recent_Post_Widget');
}

add_action('widgets_init', 'init_adv_recent_post_widget');
