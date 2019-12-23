 <div class="content__sidebar--upcoming-events">
    <div class="content__sidebar--header">
        <h5>upcoming lectures</h5>
    </div>

        <?php
            $upcomingLectures=new WP_Query(array(
                'posts_per_page' => -1,
                'post_type' => 'lecture',
                'order' => 'ASC',
                'orderby' => 'meta_value_num',
                'meta_key' => 'lecture_date',
                'meta_query' => array(
                    array(
                    'key' => 'lecture_date',
                    'compare' => '>=',
                    'value' => date('Ymd'),
                    'type' => 'numeric'
                    )
                )
            ));

            $lectureData = array();
            $months = array();

            while($upcomingLectures->have_posts()){
                $upcomingLectures->the_post();
                
                $lectureID = get_the_ID();
                $lectureTtitle = get_the_title();

                $lecture_date =  DateTime::createFromFormat('d/m/Y',get_field('lecture_date'));

                array_push($months,$lecture_date->format('F'));

                $relatedChapter = get_field('related_chapter');
                
                if ($relatedChapter) {
                    foreach ($relatedChapter as $chapter) {
                        $chapterQuery = new WP_Query(array(
                            'posts_per_page' => -1,
                            'post_type' => 'chapter',
                            'p' => $chapter->ID
                        ));
                
                        if ($chapterQuery) {
                            while ($chapterQuery->have_posts()) {
                                $chapterQuery->the_post();
                                
                                $chapterTitle = get_the_title();
                                $relatedSubject = get_field('related_subjects');

                                foreach ($relatedSubject as $subject) {

                                    array_push($lectureData,array(
                                        'id' => $lectureID,
                                        'lectureTitle' => $lectureTtitle,
                                        'dayText' => $lecture_date->format('D'),
                                        'dayTextFull' => $lecture_date->format('l'),
                                        'dayNumber' => $lecture_date->format('d'),
                                        'monthText' => $lecture_date->format('M'),
                                        'monthTextFull' => $lecture_date->format('F'),
                                        'chapter' => $chapterTitle,
                                        'subject' => get_the_title($subject)
                                    ));

                                }
                            }wp_reset_postdata();
                        }

                    }
                }
                
            }wp_reset_postdata();

            $monthsUnique = array_unique($months);

            foreach ($monthsUnique as $month) {
            echo '<div class="content__sidebar--upcoming-events-content">'; 
                echo '<h3 class="content__sidebar--upcoming-events-content__month">' . $month . '</h3>';
                
                echo '<div class="content__sidebar--upcoming-events-content__lecture--container">';
                foreach ($lectureData as $lecture) {
                    if ($month == $lecture['monthTextFull']) {
                    echo '<div class="content__sidebar--upcoming-events-content__lecture ' . $lecture['subject'] . ' row" data-id="' . $lecture['id'] . '">';
                        echo '<div class="content__sidebar--upcoming-events-content__lecture--date col col-xs-2">'; 
                            echo '<h5>' . $lecture['dayText'] . '</h5>';
                            echo '<h5>' . $lecture['dayNumber'] . '</5>';
                            echo '<h5>' . $lecture['monthText'] . '</5>';
                        echo '</div>';

                        echo '<div class="content__sidebar--upcoming-events-content__lecture--text col col-xs-10">';
                            echo '<h2>' . $lecture['subject'] . '</h2>';
                            echo '<h3>' . $lecture['lectureTitle'] . '</h3>';
                        echo '</div>';
                    echo '</div>';

                    echo '<div class="content__sidebar--upcoming-events-content__extra content__sidebar--upcoming-events-content__extra--id-'.$lecture['id'].'">';
                        echo '<div class="content__sidebar--upcoming-events-content__extra--day">';
                            echo '<h2>TIME</h2>';
                            echo '<h3>' . $lecture['dayTextFull'] . '</h3>';
                        echo '</div>';

                        echo'<div class="content__sidebar--upcoming-events-content__extra--chapter">';
                            echo '<div class="data">';
                                echo '<h2>CHAPTER</h2>';
                                echo '<h3>' . $lecture['chapter'] . '</h3></div>';
                                echo '<div class="toggle" data-id="' . $lecture['id'] . '">';
                                    echo '<i class="fas fa-chevron-up"></i>';
                                echo'</div>';
                        echo '</div>';
                    echo'</div>';
                    }
                
                }
                echo'</div>';

                echo '</div>';
            }
        ?>
 </div>

 <div class="content__sidebar--blog">
    <div class="content__sidebar--header">
        <h5>latest blog posts</h5>
    </div>
    
    <?php
        $categories = get_categories(array(
                'post_type' => 'post'
            )
        );

        echo '<div class="content__sidebar--blog__posts">';
        foreach ($categories as $category) {
          echo '<section>';
            echo '<a href="'. get_category_link($category->term_id) . '"><i class="arrow right"></i>' . $category->name.'</a>';

            $posts = get_posts(array('posts_per_page' => 2,'cat' => $category->term_id));

            foreach ($posts as $post) {
                echo '<a href="' . get_the_permalink() .'">'.get_the_title().'</a>';
            }
          echo '</section>';  
        }
        echo '</div>';
    ?>
 </div>