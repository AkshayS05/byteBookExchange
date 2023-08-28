
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
      <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs</a> <span class="metabox__main"><?php the_title(); ?></span></p>
    </div>

    <div class="generic-content">
      
      <?php the_content(); ?>
    </div>
    <!-- to display related events -->

      <?php 

      $relatedInstructors= new WP_Query(array(
        //parameters
        //-1 means give us all the posts that meet this condition
        'posts_per_page' => -1,
        'post_type' => 'instructor',

        //for letters and values, we can use meta_value, however, for numbers, we should user meta_value_num
        'orderby' => 'title',
        'order'=> 'ASC',
        //to not show past events
      
        'meta_query' => array(
          array(
            // if the array of related programs contain the ID number of the current program post
            'key' => 'related_programs',
            'compare' => 'LIKE',
            // to get the string
            'value' => '"' . get_the_ID() . '"'
          )
        )
      )); 

      if($relatedInstructors->have_posts()){

      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">' . get_the_title() . ' Instructors </h2>';
      echo '<ul class="professor-cards">';
      while($relatedInstructors ->have_posts()){
        //this will make the data, ready
        $relatedInstructors->the_post(); ?>
        <li class="professor-card__list-item">
          <a class="professor-card" href="<?php the_permalink(); ?>">
            <img class="professor-card__image" src="<?php the_post_thumbnail_url('instructorLandscape'); ?>">
            <span class="professor-card__name"><?php the_title(); ?></span>
          </a></li>

      <?php }
        echo '</ul>';
      }
      // function reset the global post object back to default url based query.
      wp_reset_postdata();

          $today = date('Ymd');
          $homePageEvents= new WP_Query(array(
            //parameters
            //-1 means give us all the posts that meet this condition
            'posts_per_page' => 2,
            'post_type' => 'event',
            // to say we weant to sort using custom data
            'meta_key' => 'event_date',
            //for letters and values, we can use meta_value, however, for numbers, we should user meta_value_num
            'orderby' => 'meta_value_num',
            'order'=> 'ASC',
            //to not show past events
           
            'meta_query' => array(
              array(
                //only return posts if the event date is greater or equal to todays date.
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
              ),
              array(
                // if the array of related programs contain the ID number of the current program post
                'key' => 'related_programs',
                'compare' => 'LIKE',
                // to get the string
                'value' => '"' . get_the_ID() . '"'
              )
            )
          )); 
         
         if($homePageEvents->have_posts()){

          echo '<hr class="section-break">';
          echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events </h2>';
          while($homePageEvents ->have_posts()){
            //this will make the data, ready
            $homePageEvents->the_post(); 
            // bsasically when there is nothing diff we want the same file to perform, if we have to we can sue function
            get_template_part('template-parts/content-event');

          }

         }
         ?>
  </div>


<?php }
get_footer();
?>