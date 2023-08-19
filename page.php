<!--  A single page not a post with page.php -->
<!-- This is a convention in wordpress to creaste a file name single.php which will hold the single page details whenever use visits any of the exisiting posts -->
<?php
// this is a wordpress function to loop until there are pages
while(have_posts()) {
// this function will keep track of all the posts
  the_post(); ?>
  <h1>A page not a post</h1>
<!-- to geenrate links we use the_permalink() -->
  <h2> <?php the_title(); ?></h2>
  <?php the_content(); ?>

<?php }

?>