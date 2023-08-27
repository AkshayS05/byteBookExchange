<!-- This is a convention in wordpress to create a file name single.php which will hold the single page details whenever use visits any of the exisiting posts -->
<?php
get_header();
// this is a wordpress function to loop until there are posts
while(have_posts()) {
// this function will keep track of all the posts
  the_post(); 
  pageBanner();
  ?>

    <div class="container container--narrow page-section">

    <div class="metabox metabox--position-up metabox--with-home-link">
         <!-- to get the url for the post type archive -->
      <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Events Home</a> <span class="metabox__main"><?php the_title(); ?></span></p>
    </div>

    <div class="generic-content">
  <?php the_content(); ?>
  
</div>
<?php 
// to show related events
$relatedPrograms = get_field('related_programs');
//only run if there is any related program
if($relatedPrograms){

  echo '<hr class ="section-break" >';
  echo '<h2 class="headline headline--medium">Related Program(s)</h2>';
  echo '<ul class="link-list min-list">';
  
  foreach($relatedPrograms as $program){ ?>
    <!-- the_title will only work for wordpress default. -->
    <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
    
    <?php }
echo '</ul>';
}

?>
  </div>


<?php }
get_footer();
?>