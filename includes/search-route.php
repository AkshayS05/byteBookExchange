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
  $mainQuery = new WP_Query(array(
    'post_type' => array('post','page','instructor', 'program', 'campus', 'event'),
    // s= search 
    // prevention from sql injection
    's' =>  sanitize_text_field($data['term']) 
  ));
  //posts = where all data for posts live

    $mainQueryResults = array(
      'generalInfo' => array(),
      'instructors' => array(),
      'programs' => array(),
      'events' => array(),
      'campuses' => array(),
    );

    while($mainQuery ->have_posts()){
      $mainQuery -> the_post();
      // this function takes two arguments, one is array you want to add on to, what you want to add in that array 
      if(get_post_type() == 'post'OR get_post_type() == 'page'){
        array_push($mainQueryResults['generalInfo'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'postType' => get_post_type(),
          'authorName' => get_the_author()
        ));
      }
      if(get_post_type() == 'instructor'){
        array_push($mainQueryResults['instructors'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink()
        ));
      }
      if(get_post_type() == 'program'){
        array_push($mainQueryResults['programs'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink()
        ));
      }
      if(get_post_type() == 'campus'){
        array_push($mainQueryResults['campuses'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink()
        ));
      }
      if(get_post_type() == 'event'){
        array_push($mainQueryResults['events'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink()
        ));
      }
    }
    return $mainQueryResults;
}
?>