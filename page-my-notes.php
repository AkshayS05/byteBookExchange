<!--  A single page not a post with page.php -->
<!-- This is a convention in wordpress to creaste a file name single.php which will hold the single page details whenever use visits any of the exisiting posts -->
<?php

if(!is_user_logged_in()){
  wp_redirect(esc_url(site_url('/')));
  exit;
}

get_header();
// this is a wordpress function to loop until there are pages
while(have_posts()) {
// this function will keep track of all the posts
 the_post(); 
 pageBanner();
 
 ?>

    <div class="container container--narrow page-section">
  custom code aarea ure.
    </div>

<?php }

get_footer();

?>