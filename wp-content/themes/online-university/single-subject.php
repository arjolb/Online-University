<?php get_header(); ?>   
    
<div class="wrapper">
    <div class="content row">
        <div class="col col-md-8 content__info">
            <div class="content__info--lectures">
                <?php
                    while (have_posts()) {
                        the_post();

                        $professor = new WP_Query(array(
                            'post_type' => 'professor',
                            'posts_per_page' => -1,
                            'meta_query' => array(
                                array(
                                    'key' => 'subjects_taught',
                                    'compare' => 'LIKE',
                                    'value' => get_the_ID()
                                )
                            )
                        ));
                ?>
                
                <h1 class="content__info--lectures__header subject"><?php the_title('', ' Lessons'); ?>
                    <p>
                        <span><i class="fas fa-user-tie"></i>
                            <?php
                                if ($professor->have_posts()) {
                                    $count = $professor->found_posts;
                                    if ($count == 1) {
                                        echo $count . ' Professor:';
                                    } else {
                                        echo $count . ' Professors:';
                                    }
                                    
                                    
                                    while ($professor->have_posts()) {
                                        $professor->the_post();
                                        
                                        echo ' <a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
                                    }
                                }wp_reset_postdata();
                            ?>
                        </span>
                    </p>
                </h1>


                <div class="content__info--lectures__content">
                    <?php
                        $relatedChapter = new WP_Query(array(
                            'post_type' => 'chapter',
                            'posts_per_page' => -1,
                            'meta_query' => array(
                                array(
                                    'key' => 'related_subjects',
                                    'compare' => 'LIKE',
                                    'value' => get_the_ID()
                                )
                            )
                        ));
                        if ($relatedChapter->have_posts()) {
                            while ($relatedChapter->have_posts()) {
                                $relatedChapter->the_post();
                    ?>
                    
                    <h1 class="content__info--lectures__content--chapter subject"><?php the_title();?></h1>

                    <?php   
                        $relatedLecture = new WP_Query(array(
                            'post_type' => 'lecture',
                            'posts_per_page' => -1,
                            'meta_query' => array(
                                array(
                                    'key' => 'related_chapter',
                                    'compare' => 'LIKE',
                                    'value' => get_the_ID()
                                )
                            )
                        ));

                        if ($relatedLecture->have_posts()) {
                            $index=0;
                            while ($relatedLecture->have_posts()) {
                                $relatedLecture->the_post();
                                $index++;
                            ?>
                            <div class="content__info--lectures__content--single-subject">
                                <div class="thumbnail">
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                </div>
                                <div class="title-permalink">
                                  <?php  
                                    echo '<h5>' . get_the_title() . '</h5>';
                                    echo '<a href="' . get_the_permalink() . '">' . wp_trim_words(get_the_content(), 13, '..') . '</a>';
                                   ?>
                                </div>
                            </div>
                          <?php 
                            }
                        }echo '<span class="lectures-count">' . $index . '</span>';

                        }}wp_reset_postdata();} 
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