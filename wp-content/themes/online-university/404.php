<?php get_header(); ?>

<div class="wrapper">
    <div class="content row">
        <div class="col col-md-8 content__info">
            <h1 class="content__info--lectures__header not-found">Sorry ... Page Not Found</h1>
            <p class="content__info--not-found">I'm sorry, but the page you're looking for could not be found.</p>
            <!-- <div class="content__info--not-found__links"> -->
                <?php
                    // $query = new WP_Query(
                        // array(
                        //   'post_type' => array('post', 'page', 'lecture'),
                        //   'posts_per_page' => 10
                        // )
                    // );

                    // while ($query->have_posts()) {
                        // $query->the_post();
                        // echo '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
                    // }
                ?>
            <!-- </div> -->
        </div>

        <div class="col col-md-4 content__sidebar">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>