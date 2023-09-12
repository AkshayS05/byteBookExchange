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
 $postLikeId= sanitize_text_field($data['postId']);
wp_insert_post(array(
  //new post that we want to create
  'post_type' => 'post_like',
  'post_status' => 'publish',
  'post_title' => 'Another Test',
  'meta_input' => array(
    'liked_post_id' => $postLikeId
  )
));
};

function deletePostLike(){
  return 'Thanks for dislike';

};