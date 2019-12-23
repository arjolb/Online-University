<?php
    if (!is_user_logged_in()) {
        wp_redirect(esc_url(site_url('/')));
        exit;
    }
?>

<?php get_header(); ?>

<div class="wrapper">
    <div class="content row">
        <div class="col col-md-8 content__info">
            <div class="content__info--notes">

                <div class="content__info--notes--add">
                    <h2>Create New Note</h2>
                    <input type="text" placeholder="Title" id="new-note-title">
                    <textarea placeholder="Your note here..." id="new-note-body"></textarea>
                    <span class="create-note">Create Note</span>
                    <span class="note-limit">Note limit reached.</span>
                </div>

                

                <div class="content__info--notes__container">
                    <?php
                        $notes = new WP_Query(array(
                            'post_type' => 'note',
                            'post_per_page' => -1,
                            'author' => get_current_user_id()
                        ));

                        if ($notes->have_posts()) {
                            while ($notes->have_posts()) {
                                $notes->the_post();
                    ?>
                    
                    <div class="content__info--notes__content" data-id="<?php the_ID(); ?>">
                        <input readonly value="<?php echo str_replace('Private: ','',esc_attr(get_the_title())); ?>">
                        <span class="edit-note"><i class="fas fa-edit"></i> Edit</span>
                        <span class="delete-note"><i class="fas fa-trash-alt"></i> Delete</span>
                        <textarea readonly><?php echo esc_textarea(get_the_content()); ?></textarea>
                        <span class="update-note"><i class="fas fa-arrow-right"></i> Save</span>
                    </div>

                    <?php
                            }
                        }else echo '<h4>You dont\'t have any notes</h4>';
                    ?>
                </div>

                
            </div>
        </div>

        <div class="col col-md-4 content__sidebar">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>