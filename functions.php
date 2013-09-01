<?php
	/**
	 * engage functions and definitions v1
	 *
	 */


/*   ====================================================================================================================
	
	UTILITIES
	 
=========================================================================================================================
*/

	
// dequeue responsive css

	function engage_remove_scripts() {
		wp_dequeue_style( 'responsive' );
		wp_deregister_style( 'responsive' );
		
		// Now register your styles and scripts here
	}
	add_action( 'wp_enqueue_scripts', 'engage_remove_scripts', 20 );




// remove personal options block

if(is_admin()){
  remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
  add_action( 'personal_options', 'prefix_hide_personal_options' );
}
function prefix_hide_personal_options() {
?>
<script type="text/javascript">
  jQuery(document).ready(function( $ ){
    $("#your-profile .form-table:first, #your-profile h3:first, .form-table:last, h3:last").remove();
    $("#nickname,#display_name").parent().parent().remove();
  });
</script>
<?php
}



//Remove tags metabox from Posts


function engage_remove_tags_metabox() {
	remove_meta_box( 'tagsdiv-post_tag' , 'post' , 'normal' ); 
}
add_action( 'admin_menu' , 'engage_remove_tags_metabox' );



// remove aim, jabber and yim
add_filter( 'user_contactmethods', 'update_contact_methods',10,1);

function update_contact_methods( $contactmethods ) {

unset($contactmethods['aim']);  
unset($contactmethods['jabber']);  
unset($contactmethods['yim']);  


return $contactmethods;
}





// changing default wordpres email settings 
 
		add_filter('wp_mail_from', 'new_mail_from');
		add_filter('wp_mail_from_name', 'new_mail_from_name');
		 
		function new_mail_from($old) {
			 return 'karina@se-legal.net';
		}
		
		function new_mail_from_name($old) {
			 return 'Senscot Legal';
		}    
    



/*   ====================================================================================================================
	
	IMAGES
	 
=========================================================================================================================
*/


	//below fixed spans with 10px padding left and right
	
   add_image_size( 'small-thumb', 200, 132, true );
	add_image_size( 'medium-thumb', 280, 180, true );
	add_image_size( 'small-main', 600, 340, true );
	add_image_size( 'medium-main', 680, 420, true );
	add_image_size( 'full-main', 940, 420, true );
	add_image_size( 'half-main', 440, 276, true ); 	


/* 	Fixed span with no padding

	add_image_size( 'small-thumb', 220, 132, true );
	add_image_size( 'medium-thumb', 300, 180, true );
	add_image_size( 'small-main', 620, 340, true );
	add_image_size( 'medium-main', 700, 420, true );
	add_image_size( 'full-main', 940, 420, true );
	add_image_size( 'half-main', 460, 276, true );	*/




/*   ====================================================================================================================
	
	SIDEBARS
	 
=========================================================================================================================
*/

// http://codex.wordpress.org/Function_Reference/register_sidebar

function engage_register_sidebars() {
  $sidebars = array( 'Page', 'Search');

  foreach($sidebars as $sidebar) {
    register_sidebar(
      array(
        'id'            => 'engage-' . sanitize_title($sidebar),
        'name'          => __($sidebar, 'engage'),
        'description'   => __($sidebar, 'engage'),
        'before_widget' => '<article id="%1$s" class="widget %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></article>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
      )
    );
  }
}

add_action('widgets_init', 'engage_register_sidebars');