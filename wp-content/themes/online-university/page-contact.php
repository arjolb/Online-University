<?php get_header(); ?>

<div class="wrapper">
    <div class="content row">
        <div class="col col-md-8 content__info">
            <div class="content__info--page-post">
                <div class="content__info--page-post">
                    <div class="content__info--page-post__content content__info--page-post__content--contact">
                        <?php
                            while (have_posts()) {
                                the_post();
                        ?>
                        <h1 class="content__info--page-post__header"><?php the_title(); ?></h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque at dictum diam, id congue erat. Fusce elementum ex ut laoreet lacinia. Cras aliquet tincidunt lacinia.</p>
                        <?php } ?>

                        <div class="content__info--page-post__content--form">
                            <div class="content__info--page-post__content--form__name">
                                <label for="name">Name <span>&ast;</span></label>
                                <input type="text" id="name">
                            </div>
                            <div class="content__info--page-post__content--form__email">
                                <label for="email">Your E-mail Address <span>&ast;</span></label>
                                <input type="email" id="email">
                            </div>
                            <div class="content__info--page-post__content--form__subject">
                                <label for="subject">Subject <span>&ast;</span></label>
                                <input type="text" id="subject">
                            </div>
                            <div class="content__info--page-post__content--form__textarea">
                                <label for="message">Message <span>&ast;</span></label>
                                <textarea name="" id="message" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col col-md-4 content__sidebar">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>