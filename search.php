<?php
get_header();

pageBanner(array(
  'title'=> 'Search Results',
  // get_search_query(false) will not let user inject any js or malicious code in the search -- cross site scripting.
  'subtitle'=> 'You searched for &ldquo;' . esc_html(get_search_query(false)) . '&rdquo;',

));
?>

      <div class="container container--narrow page-section">
        <?php
        // will loop until there are posts in the database
        if(have_posts()){
          while(have_posts()){
            the_post(); 
            // file you wana pull, particular file in the folder
            get_template_part('template-parts/content', get_post_type());
            
           
          }
          // <!-- pagination -->
          echo paginate_links();
        
      }else{
          echo '<h2 class="headline headline--small-plus">No results match that search.</h2>';
        }
       
        get_search_form();
        ?>
      </div>

<?php
get_footer();
?>