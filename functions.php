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
  // register_nav_menu('headerMenuLocation','Header Menu Location');
  // register_nav_menu('footerMenuLocationOne','Footer Menu Location One');
  // register_nav_menu('footerMenuLocationTwo','Footer Menu Location Two');
  add_theme_support('title-tag');

  //to add featured image
  add_theme_support('post-thumbnails');
  //image -> w X h, boolean - for crop, to decide from where to crop, we can use an array instead of a boolean
  add_image_size('instructorLandscape', 400, 260, true);
  //for portrait
  add_image_size('instructorPortrait',480, 650, true);
}

// wp_enqueue_scrips - to load css and js files
// this will be called when wordpress has to on a precise time        
add_action('wp_enqueue_scripts', "bbe_files");
//to get the site title
add_action('after_setup_theme', "university_features");

//while calling the function, wordpress provides a reference to the $query object
function university_adjust_queries($query){
  if(!is_admin() AND is_post_type_archive('program') AND is_main_query()){

    $query -> set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);

  }
  //set it only for events page
  //is_main_query will check if the query passsed to the function is not a custom query and is default url based query
  if(!is_admin() AND is_post_type_archive('event') AND $query-> is_main_query()){
    $today = date('Ymd');
  //order by event date and exclude past events
    $query -> set('meta_key','event_date');
    $query -> set('orderby','meta_value_num');
    $query -> set('order','ASC');
    $query -> set('meta_query',array(
      array(
        //only return posts if the event date is greater or equal to todays date.
        'key' => 'event_date',
        'compare' => '>=',
        'value' => $today,
        'type' => 'numeric'
      )
    ));
  }
}

add_action('pre_get_posts', 'university_adjust_queries');

?>