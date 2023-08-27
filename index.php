<?php
get_header();

pageBanner(array(
  'title'=> 'Welcome to my blog!',
  'subtitle'=> 'Keep up with my latest blogs',

));
?>

      <div class="container container--narrow page-section">
        <?php
        // will loop until there are posts in the database
        while(have_posts()){
          the_post(); ?>

          <div class="post-item">
          <h2 class="headline headline--medium headline--post-title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
          </h2>
          <!-- to display author and other relevant information -->
          <div class="metabox">
            <!-- n.j.s => Month, date, year -->
            <p>Posted By <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?> </p>
        </div>
        <div class ="generic-content">
          <?php the_excerpt(); ?>
          <!-- taking to the full page -->
          <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue Reading &raquo;</a></p>
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