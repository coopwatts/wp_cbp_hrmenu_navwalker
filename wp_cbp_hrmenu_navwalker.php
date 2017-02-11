<?php

/**
 * Class Name: wp_cbp_hrmenu_navwalker
 * GitHub URI: 
 * Description: A custom WordPress nav walker class to implement Codrops cbp_hrmenu.
 * Version: 1.0
 * Author: Cooper Watts
 */

class wp_cbp_hrmenu_navwalker extends Walker_Nav_Menu {

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		if($depth === 0 || $depth === 2) {
			$output .= $indent . '<li>';
		} else {
			$output .= $indent . '<div><h4>';
		}
		
		//Store the attributes for this item
		$atts = array();
		$atts['title']  = ! empty( $item->title )	? $item->title	: '';
		$atts['target'] = ! empty( $item->target )	? $item->target	: '';
		$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';
		
		//If the item has children, then the href should not point to a location
		//And the markup for the children will be different
		if ( $args->has_children && $depth === 0 ) {
			
			$atts['href'] = '#';

		} else {
		
			$atts['href'] = ! empty( $item->url ) ? $item->url : '';
				
		}
		
		//Construct a string of the attributes
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		
		if($depth === 0 || $depth === 2) {
		
			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;
			
		} else {
			
			$item_output = $args->before;
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= $args->after;
			$item_output .= '</h4><ul>';
			
		}
		
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		
		//Prepare for next item if necessary
		if ( $args->has_children && $depth === 0 ) {
			
			$output .= "\t" . '<div class="cbp-hrsub">' . "\n\t" . '<div class="cbp-hrsub-inner">' . "\n\t" . "\n\t";

		}
		
	}
	
	/**
	 * @param string $output (Required) Passed by reference. Used to append additional content.
	 * @param object $object (Required) The data object.
	 * @param int $depth (Required) Depth of the item.
	 * @param array $args (Optional) An array of additional arguments. Default value: array()
	 */
	public function end_el( &$output, $object, $depth = 0, $args = array() ) {
	
		if($depth === 2) {
			$output .= "</a></li>";
		} else if($depth === 1) {
			$output .= 	"</div>";
		} 
	}
	
	/**
	 * @param string $output (Required) Passed by reference. Used to append additional content.
	 * @param int $depth (Required) Depth of menu item. Used for padding.
	 * @param stdClass $args (Optional) An object of wp_nav_menu() arguments. Default value: array()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		//Do nothing extra
	}
	
	/**
	 * @param string $output (Required) Passed by reference. Used to append additional content.
	 * @param int $depth (Required) Depth of menu item. Used for padding.
	 * @param stdClass $args (Optional) An object of wp_nav_menu() arguments. Default value: array()
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		//Do nothing extra
	}

	/**
	 *
	 * This method shouldn't be called directly, use the walk() method instead.
	 *
	 * @param object $element Data object
	 * @param array $children_elements List of elements to continue traversing.
	 * @param int $max_depth Max depth to traverse.
	 * @param int $depth Depth of current element.
	 * @param array $args
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return null Null on failure with no changes to parameters.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;

        $id_field = $this->db_fields['id'];

        // Display this element.
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

	/**
	 * Menu Fallback
	 * =============
	 * If this function is assigned to the wp_nav_menu's fallback_cb variable
	 * and a manu has not been assigned to the theme location in the WordPress
	 * menu manager the function with display nothing to a non-logged in user,
	 * and will add a link to the WordPress menu manager if logged in as an admin.
	 *
	 * Version: 2.0.4
 	 * Author: Edward McIntyre - @twittem
     * License: GPL-2.0+
     * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
     *
	 * @param array $args passed from the wp_nav_menu function.
	 *
	 */
	public static function fallback( $args ) {
		if ( current_user_can( 'manage_options' ) ) {

			extract( $args );

			$fb_output = null;

			if ( $container ) {
				$fb_output = '<' . $container;

				if ( $container_id )
					$fb_output .= ' id="' . $container_id . '"';

				if ( $container_class )
					$fb_output .= ' class="' . $container_class . '"';

				$fb_output .= '>';
			}

			$fb_output .= '<ul';

			if ( $menu_id )
				$fb_output .= ' id="' . $menu_id . '"';

			if ( $menu_class )
				$fb_output .= ' class="' . $menu_class . '"';

			$fb_output .= '>';
			$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
			$fb_output .= '</ul>';

			if ( $container )
				$fb_output .= '</' . $container . '>';

			echo $fb_output;
		}
	}
}

?>