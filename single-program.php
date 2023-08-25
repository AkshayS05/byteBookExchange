
<!-- This is a convention in wordpress to create a file name single.php which will hold the single page details whenever use visits any of the exisiting posts -->
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

    <div class="metabox metabox--position-up metabox--with-home-link">
         <!-- to get the url for the post type archive -->
      <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs</a> <span class="metabox__main"><?php the_title(); ?></span></p>
    </div>

    <div class="generic-content">
      
      <?php the_content(); ?>
    </div>
    <!-- to display related events -->

<?php 
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

          while($homePageEvents ->have_posts()){
            //this will make the data, ready
            $homePageEvents->the_post(); ?>

            <div class="event-summary">
            <a class="event-summary__date t-center" href="#">
              <!-- event_date is the name we provided in plugin acf -->
              <span class="event-summary__month"><?php
              // php class --> it will return the current date if we don't provide it any date.
              $eventDate = new DateTime(get_field('event_date'));
              echo $eventDate->format('M')
              ?></span>
              <span class="event-summary__day"><?php 
               echo $eventDate->format('d')
              ?></span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
              <!-- wp_trim_words get two arguments, one the content we want to trim and second is number of words we want to trim. -->
              <?php if(has_excerpt()){
                // the_excerpt(); will create an automatic padding on each side, thus to tackle that we can use another function called get_the_excerpt()
                  echo get_the_excerpt();
              } else{
                echo wp_trim_words(get_the_content(), 18);
              } ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
            </div>
          </div>
          <?php } ?>
  </div>


<?php }
get_footer();
?>