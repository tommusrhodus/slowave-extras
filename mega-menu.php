<?php 

/*-----------------------------------------------------------------------------------*/
/*	MEGA MENU
/*-----------------------------------------------------------------------------------*/
function register_mega_menu() {

    $labels = array( 
        'name' => __( 'Ebor Mega Menu', 'tucson' ),
        'singular_name' => __( 'Ebor Mega Menu Item', 'tucson' ),
        'add_new' => __( 'Add New', 'tucson' ),
        'add_new_item' => __( 'Add New Ebor Mega Menu Item', 'tucson' ),
        'edit_item' => __( 'Edit Ebor Mega Menu Item', 'tucson' ),
        'new_item' => __( 'New Ebor Mega Menu Item', 'tucson' ),
        'view_item' => __( 'View Ebor Mega Menu Item', 'tucson' ),
        'search_items' => __( 'Search Ebor Mega Menu Items', 'tucson' ),
        'not_found' => __( 'No Ebor Mega Menu Items found', 'tucson' ),
        'not_found_in_trash' => __( 'No Ebor Mega Menu Items found in Trash', 'tucson' ),
        'parent_item_colon' => __( 'Parent Ebor Mega Menu Item:', 'tucson' ),
        'menu_name' => __( 'Ebor Mega Menu', 'tucson' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Mega Menus entries for Slowave.', 'tucson'),
        'supports' => array( 'title', 'editor' ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 40,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'post'
    );

    register_post_type( 'mega_menu', $args );
}
add_action( 'init', 'register_mega_menu' );


function add_sc_select(){
	
	global $post; 
	if(!( get_post_type( $post->ID ) == 'mega_menu' ))
		return false;
	
    echo '<select id="sc_select"><option>Insert Menu</option>';
		$menus = get_terms('nav_menu');
		foreach($menus as $menu){
		  echo '<option value="[ebor_mega_menu title=\'' . $menu->name . '\' child_menu=\'' . $menu->term_id . '\']">' . $menu->name . '</option>';
		} 
     echo '</select>';
}
add_action('media_buttons','add_sc_select',11);


function button_js() {
    echo '<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#sc_select").change(function() {
            send_to_editor(jQuery("#sc_select :selected").val());
                return false;
            });
        });
    </script>';
}
add_action('admin_head', 'button_js');

function tucson_ebor_mega_menu( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'child_menu' => '',
		'title' => ''
	), $atts));	

	$items = wp_get_nav_menu_items( $child_menu );
	
	$output = '';
	
	if( $title) 
		$output .= '<h4>'. $title .'</h4>';
		
	$output .= '<ul class="circled">';
	
	if($items){
	foreach( $items as $item ){
		$output .= '<li><a href="' . $item->url . '">'. $item->title .'</a></li>';
	}
	}
				
	$output .= '</ul>';
	
    return $output;
}
add_shortcode('ebor_mega_menu', 'tucson_ebor_mega_menu');