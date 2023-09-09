<!--  A single page not a post with page.php -->
<!-- This is a convention in wordpress to creaste a file name single.php which will hold the single page details whenever use visits any of the exisiting posts -->
<?php

if(!is_user_logged_in()){
  wp_redirect(esc_url(site_url('/')));
  exit;
}

get_header();
// this is a wordpress function to loop until there are pages
while(have_posts()) {
// this function will keep track of all the posts
 the_post(); 
 pageBanner();
 
 ?>

    <div class="container container--narrow page-section">
      <!-- form to add new notes -->
      <div class="create-note">
        <h1 class="headline ehadline--medium">Create New Note</h1>
        <input class="new-note-title" placeholder ="Title">
        <textarea class="new-note-body" placeholder="Add a note here..."></textarea>
        <span class="submit-note">Submit</span>
        <span class="note-limit-message">Note limit reached: delete an existing note to make room for a new one.</span>

      </div>
      <h2>All Notes:<h2>
    <ul class="min-list link-list" id ="my-notes">
      <?php 
      $userNotes = new WP_Query(array(
        'post_type' => 'note',
        'posts_per_page' => -1,
        'author' => get_current_user_id()
      ));
      while($userNotes -> have_posts()){
          $userNotes-> the_post(); ?>
          <!-- to get the id -->
      <li data-Id ="<?php the_ID(); ?>">
        <!-- whenever we want to fetch data from backend to display as value, we should use esc_attr  -->
        <!-- str_replace method to replace "Private with empty string -->
        <input readonly class="note-title-field" value="<?php echo str_replace('Private: ','',esc_attr(get_the_title())); ?>">
        <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>
        <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
        <!-- esc_attr, esc_textarea will not let javascript malicious code run -->
        <textarea readonly class="note-body-field"><?php echo esc_textarea(wp_strip_all_tags(get_the_content())); ?></textarea>
        <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span>
      </li>
    <?php }
      ?>
  </ul>
    </div>

<?php }

get_footer();

?>