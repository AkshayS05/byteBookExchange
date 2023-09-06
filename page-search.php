<!--  A single page not a post with page.php -->
<!-- This is a convention in wordpress to creaste a file name single.php which will hold the single page details whenever use visits any of the exisiting posts -->
<?php
get_header();
// this is a wordpress function to loop until there are pages
while(have_posts()) {
// this function will keep track of all the posts
 the_post(); 
 pageBanner();
 
 ?>

    <div class="container container--narrow page-section">
   
      <!-- // if current page has the parent page using postID 
      // get_the_ID() to get the parents id dynamically not only for About us for example. -->
      <?php
      // if current page is the parent page it will output 0 else it will give parents' id
      $theParent = wp_get_post_parent_id(get_the_ID());
      if ($theParent) { ?>
        <div class="metabox metabox--position-up metabox--with-home-link">
          <!-- get_the_title to get the title of the post we provide and as a link we use get_permalink -->
      <p><a class="metabox__blog-home-link" href="<?php echo get_permalink
      ($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title(); ?></span></p>
    </div>
      <?php }
    ?>
    

      <!-- sidebar menu -->
      <?php   
      //return pages and not output on screen
  $testArray = get_pages(array(
    // if current page has children it will return else it won't return anything.
        'child_of' => get_the_ID()
));

      if($theParent or $testArray){?>
      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent) ?>"><?php echo get_the_title($theParent)?></a></h2>
        <ul class="min-list">
          <?php 
          //to list pages-- this will list all the poges we have on our site.
          // requires an associative array-- which is like a key value
          if($theParent){
            //if there is a parent page
            $findChildrenOf = $theParent;
          }else{
            $findChildrenOf = get_the_ID();
          }
          wp_list_pages(array(
            // to not print "Pages'
            'title_li' => NULL,
            'child_of' => $findChildrenOf,
            // to sort child pages which is alphabetically by default
              'sort_column' => 'menu_order'
          ));
          ?>
        </ul>
      </div>
   <?php }
    ?>

      <div class="generic-content">
        <!-- esc_url improves security -->
        
      <?php get_search_form(); ?>
      </div>
    </div>

<?php }

get_footer();

?>