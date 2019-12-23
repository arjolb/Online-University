<?php get_header(); ?>

<div class="wrapper">
    <div class="content row">
        <div class="col col-md-8 content__info">
            <div class="content__info--page-post">
                <?php
                    while (have_posts()) {
                        the_post();
                ?>
                <h1 class="content__info--page-post__header"><?php the_title(); ?></h1>
                <div class="content__info--page-post__content"><?php the_content(); ?></div>
                <?php } ?>
            </div>
        </div>

        <div class="col col-md-4 content__sidebar">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>