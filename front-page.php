<?php get_header(); ?>

<div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/library-hero.jpg') ?>)"></div>
      <div class="page-banner__content container t-center c-white">
        <h1 class="headline headline--large">Welcome!</h1>
        <h2 class="headline headline--medium">We think you&rsquo;ll like it here.</h2>
        <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
        <a href="#" class="btn btn--large btn--blue">Find Your Major</a>
      </div>
    </div>

    <div class="full-width-split group">
      <div class="full-width-split__one">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>
    
          <?php 
          $today = date('Ymd');
          $homePageEvents= new WP_Query(array(
            //parameters
            //-1 means give us all the posts that meet this condition
            'posts_per_page' => -1,
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
          <?php }
      
          ?>

          <p class="t-center no-margin"><a href="<?php echo get_post_Type_archive_link('event'); ?>" class="btn btn--blue">View All Events</a></p>
        </div>
      </div>
      <div class="full-width-split__two">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
            <?php 
            //custom query
            $homepagePosts = new WP_Query(array(
              // key value for associative array
              'posts_per_page' => 2,
              
            ));
            //to access exisiting methods inside WP_Query
            // the_permalink() fetches links for posts
            while($homepagePosts-> have_posts()){
              $homepagePosts-> the_post(); ?>
              <div class="event-summary">
            <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
              <span class="event-summary__month"><?php the_time('M'); ?></span>
              <span class="event-summary__day"><?php the_time('d'); ?></span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
              <p><?php if(has_excerpt()){
                // the_excerpt(); will create an automatic padding on each side, thus to tackle that we can use another function called get_the_excerpt()
                  echo get_the_excerpt();
              } else{
                echo wp_trim_words(get_the_content(), 18);
              } ?> <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
            </div>
          </div>
        <!-- this function will cleanup custom queries. -->
            <?php } wp_reset_postdata();
            ?>
         

          <p class="t-center no-margin"><a href="<?php echo site_url('/blog') ?>" class="btn btn--yellow">View All Blog Posts</a></p>
        </div>
      </div>
    </div>

    <div class="hero-slider">
      <div data-glide-el="track" class="glide__track">
        <div class="glide__slides">
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('images/bus.jpg') ?>)">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">Free Transportation</h2>
                <p class="t-center">All students have free unlimited bus fare.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('images/apples.jpg') ?> ">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">An Apple a Day</h2>
                <p class="t-center">Our dentistry program recommends eating apples.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('images/bread.jpg') ?>">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">Free Food</h2>
                <p class="t-center">Fictional University offers lunch plans for those in need.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
        </div>
        <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
      </div>
    </div>

<?php
get_footer(); 

?>
 