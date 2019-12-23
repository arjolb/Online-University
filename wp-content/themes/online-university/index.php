<?php get_header(); ?>


<div class="wrapper">
    <div class="content">
        <div class="content__info content__info--general">
            <?php
                while(have_posts()){
                    the_post();
                    echo '<h1>'.get_the_title().'</h1>';
                    echo '<p>'.get_the_content().'</p>';
                }
            ?>
        </div>
        <div class="content__sidebar">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>


<?php get_footer(); ?>