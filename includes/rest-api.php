<?php 
// namespace WPSE\RestAPI\Frontpage;
/**
* Add menus to REST API.
*/

function wp_api_v2_menus_get_all_menus () {
    $menus = [];
    foreach (get_registered_nav_menus() as $slug => $description) {
        $obj = new stdClass;
        $obj->slug = $slug;
        $obj->description = $description;
        $menus[] = $obj;
    }
    return $menus;
}
/**
 * Get menu's data from his id
 * @param  array $data WP REST API data variable
 * @return object Menu's data with his items
 */
function wp_api_v2_menus_get_menu_data ( $data ) {
    $menu = new stdClass;
	$menu->items = [];
    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $data['id'] ] ) ) {
        $menu = get_term( $locations[ $data['id'] ] );
        $menu->items = wp_get_nav_menu_items($menu->term_id);
        foreach($menu->items as $value){
            $path = str_replace(  home_url() , "", $value->url );
            $value->link = $path;
        }
    }
    return $menu;
}



/**
* Contact Form.
*/

function send_contact_form(WP_REST_Request $request){
    $full_name = sanitize_text_field(trim($request['full_name']));
    $email = sanitize_text_field(trim($request['email']));
    $body = wp_kses_post(trim($request['body']));

    $errors = [];

    if(empty($full_name)) {
        $errors[] = "Name is required";
    }
    if(empty($email) || ! filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors[]= "Valid Email is required";
    }
    if(empty($body)){
        $errors[]="Message is required";
    }
    if(count($errors)) {
        return new WP_Error('contact_form_errors',$errors,['status'=>422]);
    }

    $message = "<h2>Full name: $full_name</h2><br><h2>From: $email</h2><br>Message: $body";


    $headers = ['Content-Type: text/html; charset=UTF-8'];
    wp_mail($email,'contact form',$message,$headers);
   
    return "success";
}






/**
* Template name
*/

function get_post_id_by_template($template){
    global $wpdb;
    $wh = ($lang_slug) ? " AND t.slug = %s" : "";
  
    $query = $wpdb->prepare(
      "SELECT DISTINCT p.ID
      FROM $wpdb->posts p
      INNER JOIN $wpdb->postmeta meta ON meta.post_id = p.ID
      INNER JOIN $wpdb->term_relationships tr ON meta.post_id = tr.object_id
      INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
      INNER JOIN $wpdb->terms t ON tt.term_id = t.term_id
      WHERE p.post_status = 'publish' AND meta.meta_key = %s AND meta.meta_value = %s" . $wh,
      '_wp_page_template',
      $template
    );
  
    $ids = $wpdb->get_results($query);
  
    if($ids && isset($ids[0])){
      $p = $ids[0];
      return $p->ID;
    } else {
      return false;
    }
  }// get_post_id_by_template




add_action( 'rest_api_init', function () {

    // CUSTOM POST TYPES
    $post_types_args = array(
        'public'   => true,
        '_builtin' => false
     );
 
     $post_types = get_post_types( $post_types_args, 'names', 'and' );
     $posts_post_types = array_merge( array( "post", "posts" ), $post_types);
     $pages_posts_post_types = array_merge(array( "page", "pages", "post", "posts" ), $post_types);

    //register menus
    register_rest_route( 'menus/v1', '/menus', array(
        'methods' => 'GET',
        'callback' => 'wp_api_v2_menus_get_all_menus',
    ) );
    register_rest_route( 'menus/v1', '/menus/(?P<id>[a-zA-Z0-9_-]+)', array(
        'methods' => 'GET',
        'callback' => 'wp_api_v2_menus_get_menu_data',
    ) );
    
    register_rest_route('send-contact-form/v1','/contact',[
        'methods'=> 'POST',
        'callback'=> 'send_contact_form'
    ]);

    //register page template names    

    register_rest_route( 'template/v2', '/template',[
        'methods'=>'GET',
        'callback'=>'wp_rest_all_templates'
    ]);


    register_rest_route( 'template/v2', '/template/(?P<id>[a-zA-Z0-9_-]+)',[
        'methods'=>'GET',
        'callback'=>'wp_rest_page_template_return'
    ]);

     // Add featured_image url to post-details, not just the media-id
     register_rest_field(  $pages_posts_post_types, "featured_image", array(
        "get_callback" => function( $post ) {
            return (object) array(
                "html"=>get_the_post_thumbnail( $post['id'], 'large' ),
                "url"=>wp_get_attachment_image_src( get_post_thumbnail_id( $post['id']), 'full', false  ),
                "url_medium"=>wp_get_attachment_image_src( get_post_thumbnail_id( $post['id']), 'medium'  , false),
                "url_square"=>wp_get_attachment_image_src( get_post_thumbnail_id( $post['id']), 'square' , false ),

              );
        },
        "schema" => array(
            "description" => __( "Featured Image HTML." ),
            "type"        => "object"
        ),
    ) );


} );

add_action( 'rest_api_init', 'slug_register_yoast_seo_meta' );

function slug_register_yoast_seo_meta() {
    register_rest_field( 'page',
        '_yoast_wpseo_title',
        array(
            'get_callback'    => 'get_seo_meta_field',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field( 'page',
        '_yoast_wpseo_metadesc',
        array(
            'get_callback'    => 'get_seo_meta_field',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field( 'oferta',
        '_yoast_wpseo_title',
        array(
            'get_callback'    => 'get_seo_meta_field',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field( 'oferta',
        '_yoast_wpseo_metadesc',
        array(
            'get_callback'    => 'get_seo_meta_field',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}
function get_seo_meta_field( $object, $field_name, $request ) {
    return get_post_meta( $object[ 'id' ], $field_name, true );
}
