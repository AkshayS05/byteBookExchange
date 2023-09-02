<?php
add_action('rest_api_init','bbeRegisterSearch');

function bbeRegisterSearch(){
  // namespace which you want to use, route to the ending part of the  url, array on what should happen when someone visits the url
  register_rest_route('bbe/v1', 'search',array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'bbeSearchResults'
  )); 
}

function bbeSearchResults(){
  return 'Yuhuuuuu you got it..';
}
?>