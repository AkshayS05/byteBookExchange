<?php 

function bbe_files(){
  //load as many css and js files using this function
  wp_enqueue_style('bbe_main_styles', get_theme_file_uri('./build/style-index.css') );
  wp_enqueue_style('bbe_extra_styles', get_theme_file_uri('./build/index.css') );
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
}
// wp_enqueue_scrips - to load css and js files
// this will be called when wordpress has to on a precise time        
add_action('wp_enqueue_scripts', "bbe_files");
?>