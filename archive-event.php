<?php
get_header();
?>

<div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg') ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">
          All Events
        </h1>
        <div class="page-banner__intro">
          <p>
            See what is going on in our world. 🌏
          </p>
        </div>
      </div>
    </div>
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
      </div>

<?php
get_footer();
?>