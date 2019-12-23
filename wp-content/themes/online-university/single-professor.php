<?php get_header(); ?>

<div class="wrapper">
    <div class="content row">
        <div class="col col-md-8 content__info">
            <?php
                while (have_posts()) {
                    the_post();
            ?>

            <h1 class="content__info--lectures__header"><?php the_title('Professor '); ?></h1>

            <div class="content__info--professor">
                <div class="thumbnail col-md-9">
                    <?php the_post_thumbnail('thumbnail'); ?>
                </div>
                <div class="bio col-md-3">
                    <?php the_content(); ?>
                </div>
            </div>

            <div class="content__info--professor__subjects">
                <div class="col col-xs-10">
                    <?php
                        echo '<h4>Subject(s) Taught: ';

                        $subjectsTaught = get_field('subjects_taught');
                        foreach ($subjectsTaught as $subject) {
                            echo '<a href="' . get_the_permalink($subject) . '">' . get_the_title($subject) . '</a>';
                        }

                        echo '</h4>';
                    ?>
                </div>
                <div class="col col-xs-2">
                        <?php
                            $likeCount = new WP_Query(array(
                                'post_type' => 'like',
                                'meta_query' => array(
                                    array(
                                        'key' => 'like_professor_id',
                                        'compare' => '=',
                                        'value' => get_the_ID()
                                    )
                                )
                            ));

                            $liked = 'no';

                            if (is_user_logged_in()) {
                                $likedProfessor = new WP_Query(array(
                                'author' => get_current_user_id(),
                                'post_type' => 'like',
                                'meta_query' => array(
                                    array(
                                        'key' => 'like_professor_id',
                                        'compare' => '=',
                                        'value' => get_the_ID()
                                        )
                                    )
                                ));

                                if ($likedProfessor->found_posts) {
                                    $liked = 'yes';
                                }
                            }
                        ?>
                        <span class="like-professor" data-like="<?php echo $likedProfessor->posts[0]->ID; ?>" data-liked="<?php echo $liked; ?>" data-professor="<?php the_ID(); ?>">
                            <i class="far fa-heart"></i>
                            <i class="fa fa-heart"></i> 
                            <span class="like-professor-count"><?php echo $likeCount->found_posts; ?></span>
                        </span>
                </div>
            </div>

            <?php
                }
            ?>
        </div>

        <div class="col col-md-4 content__sidebar">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>