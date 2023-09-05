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
          'permalink' => get_the_permalink(),
          // two things-> which post you wana find image for 0 means current and other is size
          'image' => get_the_post_thumbnail_url(0, 'instructorLandscape')
        ));
      }
      if(get_post_type() == 'program'){
        $relatedCampuses = get_field('related_campus');
        if($relatedCampuses){
          foreach(){
            
          }
        }
        array_push($mainQueryResults['programs'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'id' => get_the_id()
        ));
      }
      if(get_post_type() == 'campus'){
        array_push($mainQueryResults['campuses'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink()
        ));
      }
      if(get_post_type() == 'event'){
        $eventDate = new DateTime(get_field('event_date'));
        $description = null;
        if(has_excerpt()){
          $description = get_the_excerpt();
      } else{
        $description = wp_trim_words(get_the_content(), 18);
      } 
        array_push($mainQueryResults['events'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'month' => $eventDate -> format('M'),
          'day' => $eventDate -> format('d'),
          'description' => $description
        ));
      }
    }
 

    // Relationship query
    if ($mainQueryResults['programs']) {
    // to make it work when atleast one consition is true
    $programsMetaQuery = array('relation' => 'OR');
      foreach($mainQueryResults['programs'] as $item){
        array_push($programsMetaQuery,   array(
          'key' => 'related_programs',
          'compare' => 'LIKE',
          // wordpress wraps each value in qutotations
          'value' => '"' . $item['id'] . '"'
        ));
      }
      
        $programRelationshipQuery = new WP_Query(array(
          // If meta query si emoty, it will give all the instructor posts
          'post_type' => array(
            'professor', 'event', 
          ),
          'meta_query' => $programsMetaQuery 
        ));


            while($programRelationshipQuery -> have_posts()){
                $programRelationshipQuery -> the_post();
    
                if(get_post_type() == 'event'){
                  $eventDate = new DateTime(get_field('event_date'));
                  $description = null;
                  if(has_excerpt()){
                    $description = get_the_excerpt();
                } else{
                  $description = wp_trim_words(get_the_content(), 18);
                } 
                  array_push($mainQueryResults['events'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'month' => $eventDate -> format('M'),
                    'day' => $eventDate -> format('d'),
                    'description' => $description
                  ));
                }
            

                if(get_post_type() == 'instructor'){
                  array_push($mainQueryResults['instructors'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    // two things-> which post you wana find image for 0 means current and other is size
                    'image' => get_the_post_thumbnail_url(0, 'instructorLandscape')
                  ));
                }
            }
              $mainQueryResults['instructors'] = array_values(array_unique($mainQueryResults['instructors'],SORT_REGULAR ));
              $mainQueryResults['events'] = array_values(array_unique($mainQueryResults['events'],SORT_REGULAR ));
          }
         return $mainQueryResults;
      
}
?>