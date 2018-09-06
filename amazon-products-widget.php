<?php
/**
 * Plugin Name: Amazon Products Widget
 * Description: Simple widget that shows post-related products in the right side widget.
 * Author: Maxim Rubis
 * Author URI: https://rub.is/
 * Plugin URI: https://rub.is/
 * Version: 0.1.0
 */
 
add_action( 'widgets_init', function () 
{
    register_widget( 'Amazon_Products_Widget' );
});

class Amazon_Products_Widget extends WP_Widget 
{

    public function __construct() 
    {
        parent::__construct(
            'widget_amazon_products', 
            _x( 'Amazon Products Widget', 'Amazon Products Widget' ), 
            [ 'description' => __( 'Display a list of related Amazon products.' ) ] 
        );
        $this->alt_option_name = 'widget_amazon_products';
    }

    public function widget( $args, $instance ) 
    {
		$amazon_value = get_post_meta( get_the_ID(), 'amazon', true );
		
		if (!empty($amazon_value))
		{

			$title          = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recommended Products' );
			$title          = apply_filters( 'widget_title', $title, $instance, $this->id_base );
			
			$tag = ( ! empty( $instance['tag'] ) ) ? $instance['tag'] : 'rubis09-20';
			$width = ( ! empty( $instance['width'] ) ) ? $instance['width'] : '100';
	
			echo $args['before_widget'];
			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}               
		?>
<script type="text/javascript">
amzn_assoc_placement = "adunit0";
amzn_assoc_search_bar = "false";
amzn_assoc_tracking_id = "<?php echo $tag; ?>";
amzn_assoc_ad_mode = "manual";
amzn_assoc_ad_type = "smart";
amzn_assoc_marketplace = "amazon";
amzn_assoc_region = "US";
amzn_assoc_title = "";
amzn_assoc_linkid = "bcae2949b17be18b4be41f3cccaa09d6";
amzn_assoc_asins = "<?php echo $amazon_value; ?>";
amzn_assoc_size = "x1200";
</script>
<div style="width:<?php echo $width; ?>%">
	<script src="//z-na.amazon-adsystem.com/widgets/onejs?MarketPlace=US"></script>	
</div>
		<?php
			echo $args['after_widget']; 
		}
    }

    public function update( $new_instance, $old_instance ) 
    {
        $instance                   = $old_instance;
        $instance['title']          = strip_tags( $new_instance['title'] );
        $instance['tag']          = strip_tags( $new_instance['tag'] );
        $instance['width']          = !empty($new_instance['width']) ? intval( $new_instance['width'] ) : '';

        return $instance;
    }

    public function form( $instance ) 
    {
        $title      = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $tag      = isset( $instance['tag'] ) ? esc_attr( $instance['tag'] ) : '';
        $width      = isset( $instance['width'] ) ? esc_attr( $instance['width'] ) : '';

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'tag' ); ?>"><?php _e( 'Amazon Associate Tag:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'tag' ); ?>" name="<?php echo $this->get_field_name( 'tag' ); ?>" type="text" value="<?php echo $tag; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'wudth' ); ?>"><?php _e( 'Widget Width (%):' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo $width; ?>" />
        </p>
		<?php
    }
}
