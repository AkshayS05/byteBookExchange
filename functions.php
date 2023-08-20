<?php 

function bbe_files(){
  //load as many css and js files using this function
  wp_enqueue_style('bbe_main_styles', get_theme_file_uri('./build/style-index.css') );
  wp_enqueue_style('bbe_extra_styles', get_theme_file_uri('./build/index.css') );
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
  //javascript file
  wp_enqueue_script('main-bbe-js', get_theme_file_uri('./build/index.js'), array('jquery'),'1.0',true );

}

function university_features(){
  //to add menu option to our theme
  register_nav_menu('headerMenuLocation','Header Menu Location');
  register_nav_menu('footerMenuLocationOne','Footer Menu Location One');
  register_nav_menu('footerMenuLocationTwo','Footer Menu Location Two');
  add_theme_support('title-tag');
}

// wp_enqueue_scrips - to load css and js files
// this will be called when wordpress has to on a precise time        
add_action('wp_enqueue_scripts', "bbe_files");
//to get the site title
add_action('after_setup_theme', "university_features");
?>