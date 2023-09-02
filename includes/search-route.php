<?php
add_action('rest_api_init','bbeRegisterSearch');

function bbeRegisterSearch(){
  // namespace which you want to use, route to the ending part of the  url, array on what should happen when someone visits the url
  register_rest_route('bbe/v1', 'search',array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'bbeSearchResults'
  )); 
}

function bbeSearchResults($data) {
  // wordpress automatically converts php data to json data.
  // to return json
  // here we got collection of posts
  $instructors = new WP_Query(array(
    'post_type' => 'instructor',
    // s= search 
    // prevention from sql injection
    's' =>  sanitize_text_field($data['term']) 
  ));
  //posts = where all data for posts live

    $instructorResults = array();

    while($instructors->have_posts()){
      $instructors -> the_post();
      // this function takes two arguments, one is array you want to add on to, what you want to add in that array 
      array_push($instructorResults, array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink()
      ));
    }
    return $instructorResults;
}
?>