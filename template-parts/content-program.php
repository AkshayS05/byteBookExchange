<div class="post-item">
          <h2 class="headline headline--medium headline--post-title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
          </h2>
          <!-- to display author and other relevant information -->
     
        <div class ="generic-content">
          <?php the_excerpt(); ?>
          <!-- taking to the full page -->
          <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">View program &raquo;</a></p>
        </div>
      </div>