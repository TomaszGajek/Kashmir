<?php

function vue_theme_scripts(){

    $base_url  = esc_url_raw( home_url() );
	$base_path = rtrim( parse_url( $base_url, PHP_URL_PATH ), '/' );

    wp_enqueue_script( 'app-run', 'http://localhost:3000//_nuxt/runtime.js', array(), '1.0.0', true );
    wp_enqueue_script( 'common', 'http://localhost:3000//_nuxt/common.app.js', array(), '1.0.0', true );
    wp_enqueue_script( 'vendors', 'http://localhost:3000//_nuxt/vendors.app.js', array(), '1.0.0', true );
    wp_enqueue_script( 'app', 'http://localhost:3000//_nuxt/app.js', array(), '1.0.0', true );

    wp_localize_script( 'app', 'wp', array(
		'root'      => esc_url_raw( rest_url() ),
		'base_url'  => $base_url,
		'base_path' => $base_path ? $base_path . '/' : '/',
		'nonce'     => wp_create_nonce( 'wp_rest' ),
		'site_name' => get_bloginfo( 'name' )
	) );

}


add_action( 'wp_enqueue_scripts', 'vue_theme_scripts', 10 );
