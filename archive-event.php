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
          the_post(); 
          get_template_part('template-parts/content-event');
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