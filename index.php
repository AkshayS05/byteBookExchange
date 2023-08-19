<?php get_header(); 

// this is a wordpress function to loop until there are posts
while(have_posts()) {
// this function will keep track of all the posts
  the_post(); ?>
<!-- to geenrate links we use the_permalink() -->
  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  <?php the_content(); ?>

<?php }
get_footer(); 

?>
 