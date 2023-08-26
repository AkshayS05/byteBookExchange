<?php
get_header();
pageBanner(array(
  'title' => "All Events",
  'subtitle' => "See what is going on in our world. 🌏",
));
?>
      <div class="container container--narrow page-section">
        <?php
        // will loop until there are posts in the database
        while(have_posts()){
          the_post(); ?>

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
        
        // <!-- pagination -->
        echo paginate_links();
        ?>
        <hr class="section-break" />
  <p>Looking for a recap of our past events? <a href="<?php echo site_url('/past-events') ?>">Check out our past events archive. <a></p>

      </div>

<?php
get_footer();
?>