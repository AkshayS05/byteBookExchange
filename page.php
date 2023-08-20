<!--  A single page not a post with page.php -->
<!-- This is a convention in wordpress to creaste a file name single.php which will hold the single page details whenever use visits any of the exisiting posts -->
<?php
get_header();
// this is a wordpress function to loop until there are pages
while(have_posts()) {
// this function will keep track of all the posts
 the_post(); ?>

<div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg') ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title(); ?></h1>
        <div class="page-banner__intro">
          <p>Replace it later please.</p>
        </div>
      </div>
    </div>

    <div class="container container--narrow page-section">
   
      <!-- // if current page has the parent page using postID 
      // get_the_ID() to get the parents id dynamically not only for About us for example. -->
      <?php
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

      <div class="page-links">
        <h2 class="page-links__title"><a href="#">About Us</a></h2>
        <ul class="min-list">
          <?php 
          //to list pages-- this will list all the poges we have on our site.
          wp_list_pages();
          ?>
        </ul>
      </div>

      <div class="generic-content">
    <?php 
    the_content();
    ?>
      </div>
    </div>

<?php }

get_footer();

?>