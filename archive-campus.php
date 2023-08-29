<?php
get_header();
pageBanner(array(
  'title'=> "Our Campuses",
  'subtitle'=> "Checkout our virtual campuses which actually doesn't exist 🏫",

));
?>

      <div class="container container--narrow page-section">
        <ul class="link-list min-list">
        <?php
        // will loop until there are posts in the database
        while(have_posts()){
          the_post(); 
          get_field('map_location');
          ?>
    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
    <?php the_field('map_location'); ?>
        <?php
    
        }
        // <!-- pagination -->
        echo paginate_links();
        ?>
        </ul>

      </div>
      
      <?php
     the_field('Map');
get_footer();
?>