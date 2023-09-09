<?php 
//to get file from includes folder
require get_theme_file_path('/includes/search-route.php');

add_action('rest_api_init','bbe_custom_rest');

function bbe_custom_rest(){
  // this function accepts three arguments -> 1. post type you want to customize. 2. name of new field. 3. how to manage this field
  register_rest_field("post",'authorName',array(
    //associative array
    'get_callback' => function(){
      return get_the_author();
    }
  ));
  register_rest_field("note",'userNoteCount',array(
    //associative array
    'get_callback' => function(){
      return count_user_posts(get_current_user_id(),'note');
    }
  ));
}
//$args = NULL will make it optional
function pageBanner($args= NULL){
  if(!isset($args['title'])) {
    $args['title'] = get_the_title();
  }
  if(!isset($args['subtitle'])) {
    $args['subtitle'] = get_field('page_banner_subtitle');
  }
  if(!isset($args['photo'])) {
    if(get_field('page_banner_background_image')) {
      $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
          $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
  }
  ?>
  <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args['subtitle'] ?></p>
        </div>
      </div>
    </div>
<?php }

function bbe_files(){
  //load as many css and js files using this function
  wp_enqueue_style('bbe_main_styles', get_theme_file_uri('./build/style-index.css') );
  wp_enqueue_style('bbe_extra_styles', get_theme_file_uri('./build/index.css') );
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
  //javascript file
  wp_enqueue_script('main-bbe-js', get_theme_file_uri('./build/index.js'), array('jquery'),'1.0',true );

  // takes three agruments , name of js file, variable name, array of data 
  wp_localize_script('main-bbe-js','bbeData',array(
    // associative array
    'root_url' => get_site_url(),
    'nonce' => wp_create_nonce('wp_rest')
  ));

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
  //for banner image
  add_image_size('pageBanner', 1500, 350, true);
}

// wp_enqueue_scrips - to load css and js files
// this will be called when wordpress has to on a precise time        
add_action('wp_enqueue_scripts', "bbe_files");
//to get the site title
add_action('after_setup_theme', "university_features");

//while calling the function, wordpress provides a reference to the $query object
function university_adjust_queries($query){
  if(!is_admin() AND is_post_type_archive('campus') AND is_main_query()){
    $query->set('posts_per_page', -1);
  }

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

function universityMapKey($api) {
$api['key'] = '';
return $api;
}
add_filter('acf/fields/google_map/api','universityMapKey');

//Redirect subscriber accounts out of admin and onto the homepage with "admin_init"
add_action('admin_init','redirectSubsToFrontend');

function redirectSubsToFrontend(){
  // 
  $currentUser = wp_get_current_user();
  if(count($currentUser-> roles) == 1 AND $currentUser -> roles[0] == 'subscriber'){
    wp_redirect(site_url('/'));
    //stop here
    exit;
  }
}
add_action('wp_loaded','noSubsAdminBar');

function noSubsAdminBar(){
  // 
  $currentUser = wp_get_current_user();
  if(count($currentUser-> roles) == 1 AND $currentUser -> roles[0] == 'subscriber'){
    show_admin_bar(false);
  }
}

//customize login screen
add_filter('login_headerurl','headerUrl');
//to change the link on login page
function headerUrl(){
  return esc_url(site_url('/'));
}
add_action('login_enqueue_scripts', 'loginCss');

function loginCss(){
  wp_enqueue_style('bbe_main_styles', get_theme_file_uri('./build/style-index.css') );
  wp_enqueue_style('bbe_extra_styles', get_theme_file_uri('./build/index.css') );
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
}
add_filter('login_headertitle', 'loginTitle');

function loginTitle(){
  return get_bloginfo('name');
}
// Force note posts to be private
// filter or modify data that will be added to the database.
// 2- represnte we want functionn to accept two parameters
// 10 -> priortiy on when it will run
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

function makeNotePrivate($data, $postarr) {
  // the first condition will remove all the html removed in case they add.
  if ($data['post_type'] == 'note'){
    // which user account , which post type
    // new post we are intending to create wil  not have an id
    if (count_user_posts(get_current_user_id(), 'note') > 2 AND !$postarr['ID']){
        die("You have exceeded the note limit.");
    }
    $data['post_content'] = sanitize_textarea_field($data['post_content']);
    $data['post_title'] = sanitize_text_field($data['post_title']);
  }
  if($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {
    $data['post_status'] = "private";
  }
  
  return $data;
}
?>