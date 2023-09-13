<?php

add_action('rest_api_init', 'bbePostLikeRoutes');

function bbePostLikeRoutes(){
  register_rest_route('bbe/v1','managePostLike', array(
    'methods' => 'POST',
    'callback' =>'createPostLike'
  ));
  register_rest_route('bbe/v1','managePostLike', array(
    'methods' => 'DELETE',
    'callback' =>'deletePostLike'
  ));
}

function createPostLike($data) {

  if(is_user_logged_in()){
    $post = sanitize_text_field($data['postId']);

    $existCountQuery = new WP_Query(array(
      'author' => get_current_user_id(),
      'post_type' => 'post_like',
      'meta_query' => array(
        array(
          'key' => 'liked_post_id',
          'compare' => 'equal',
          'value' => $post
        )
      )
        ));

    if($existCountQuery -> found_posts == 0 AND get_post_type($post) == 'post') {
      return  wp_insert_post(array(
        'post_type' => 'post_like',
        'post_status' => 'publish',
        'post_title' => ' New Post Like',
        'meta_input' => array(
        'liked_post_id' => $post
        )
      ));
    } else{
      die("Invalid post id");
    }

  
  }else{
    die("Only logged in users can create like a post.");
  }
}

function deletePostLike($data){

  $postId = sanitize_text_field($data['postLike']);

    if (get_current_user_id() == get_post_field('post_author', $postId) AND get_post_type( $postId) == 'post_like') {
      
      wp_delete_post( $postId, true);
      return 'Congrats, liked deleted!';
    }else{
      die("You do not have permission to delete that");
    }
  }