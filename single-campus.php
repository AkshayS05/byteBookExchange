
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
      <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Campuses</a> <span class="metabox__main"><?php the_title(); ?></span></p>
    </div>

    <div class="generic-content">
      
      <?php the_content(); 
    the_field('map_location');
      ?>
    </div>
    <!-- to display related campus -->
    <?php 

      $relatedPrograms= new WP_Query(array(
        //parameters
        //-1 means give us all the posts that meet this condition
        'posts_per_page' => -1,
        'post_type' => 'program',

        //for letters and values, we can use meta_value, however, for numbers, we should user meta_value_num
        'orderby' => 'title',
        'order'=> 'ASC',
        //to not show past events
      
        'meta_query' => array(
          array(
            // if the array of related campus contain the ID number of the current program post
            'key' => 'related_campus',
            'compare' => 'LIKE',
            // to get the string
            'value' => '"' . get_the_ID() . '"'
          )
        )
      )); 

      if($relatedPrograms->have_posts()){

      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">Programs Available At this Campus</h2>';
      echo '<ul class="min-list link-list">';
      while($relatedPrograms ->have_posts()){
        //this will make the data, ready
        $relatedPrograms->the_post(); ?>
        <li>
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?>
          </a></li>

      <?php }
        echo '</ul>';
      }
      // function reset the global post object back to default url based query.
      wp_reset_postdata();

       
         ?>
  </div>


<?php }
get_footer();
?>