<?php
get_header();

pageBanner(array(
  'title'=> 'Past Events',
  'subtitle'=> 'A recap of our past events 🌏',

));
?>

      <div class="container container--narrow page-section">
        <?php

$today = date('Ymd');
$pastEvents= new WP_Query(array(
  //parameters
  // paged weill tell the custom query about on which page it should be on
  //get_query_var() provides all sort of info about current url
  'paged' => get_query_var('paged',1),
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
      'compare' => '<',
      'value' => $today,
      'type' => 'numeric'
    )
  )
)); 
        // will loop until there are posts in the database
        while($pastEvents-> have_posts()){
          $pastEvents-> the_post(); ?>

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
              <p><?php echo wp_trim_words(get_the_content(),18); ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
            </div>
          </div>
        <?php
        }
        
        // <!-- pagination--> only works for default queries that wordpress makes on its own that are tied to the current url -->
        // provide information of custom query to amke it work.
        echo paginate_links(array(
          'total' => $pastEvents -> max_num_pages
        ));
        ?>
      </div>

<?php
get_footer();
?>