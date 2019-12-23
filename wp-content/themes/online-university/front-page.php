<?php get_header(); ?>


<div class="wrapper">
    <div class="content row">
        <div class="col col-md-8 content__info">
            
           <div class="col-info">
                <div class="content__info--hero">
                    <img src="<?php echo get_theme_file_uri('/img/hero.jpg') ?>" alt="Hero" class="content__info--hero__img">
                    <div class="content__info--hero__text">
                        <h3>Free Online Lectures</h3>
                        <h6>Lorem ipsum dolor sit amet consectetur.</h6>
                    </div>
                </div><!-- /HERO -->

                <div class="content__info--subjects row">
                    <?php
                        $departament = new WP_Query(array(
                            'posts_per_page' => -1,
                            'post_type' => 'departament'
                        ));
                        
                        while($departament->have_posts()){
                            $departament->the_post();
                        ?>
                        <div class="content__info--subjects__subject col col-xs-6">
                            <?php
                                echo '<h1>' . get_the_title() . '</h1>';
                            
                                $relatedSubjects = get_field('related_subjects');
                                if ($relatedSubjects) {
                                    foreach ($relatedSubjects as $subject) {
                                        echo '<h2><a href="' . get_the_permalink($subject) . '">' . get_the_title($subject) . '</a></h2>';
                                    }
                                }
                            ?>
                        </div>
                    <?php
                        }wp_reset_postdata();
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