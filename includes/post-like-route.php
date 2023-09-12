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

function createPostLike() {
return 'Thanks for trying a like';
};

function deletePostLike(){
  return 'Thanks for dislike';

};