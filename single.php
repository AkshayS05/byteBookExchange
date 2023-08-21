
<!-- This is a convention in wordpress to creaste a file name single.php which will hold the single page details whenever use visits any of the exisiting posts -->
<?php
get_header();
// this is a wordpress function to loop until there are posts
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
    Metabox will go here.
    <div class="generic-content">
  <?php the_content(); ?>
</div>
  </div>


<?php }
get_footer();
?>