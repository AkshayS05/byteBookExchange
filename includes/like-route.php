<?php

add_action('rest_api_init', 'bbeLikeRoutes');

function bbeLikeRoutes(){
  register_rest_route('bbe/v1','manageLike',array(
    'methods' =>'POST' ,
    'callback' => 'createLike'
  ));
  register_rest_route('bbe/v1','manageLike',array(
    'methods' => 'DELETE',
    'callback' => 'deleteLike'
  ));

}
function createLike($data){
  if (is_user_logged_in()) {

    $instructor = sanitize_text_field($data['instructorId']);
    $existQuery = new WP_Query(array(
      'author' => get_current_user_id(),
      'post_type' => "like",
      'meta_query'=> array(
        array(
          'key' => "liked_instructor_id",
          'compare'=>'=',
          'value' => $instructor
        )
      )
    ));
    if($existQuery-> found_posts == 0 AND get_post_type($instructor) == 'instructor'){
        //create a new like post
        return wp_insert_post(array(
          // describe new post to create
          'post_type' => 'like',
          'post_status' => 'publish',
          'post_title' => 'another test',
          'meta_input' => array(
          'liked_instructor_id'=> $instructor
          )
         ));
    }else {
      //if like does exist--> cancel the current request
      die("Invalid instructor id");
    }
   
  }else{
    die("Only logged in users can like.");
  }
  
}
function deleteLike($data){

$likeId = sanitize_text_field($data['like']);
  if (get_current_user_id() == get_post_field('post_author',$likeId) AND get_post_type($likeId) == 'like') {
    wp_delete_post($likeId, true);
    return 'Congrats, liked deleted!';
  }else{
    die("You do not have permission to delete that");
  }
}