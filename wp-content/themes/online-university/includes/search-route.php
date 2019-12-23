<?php

add_action('rest_api_init', 'searchRoute');

function searchRoute(){
    register_rest_route('searchroute/v1','search',array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'searchResults'
    ));
}

function searchResults($data){
    $mainQuery = new WP_Query(array(
        'post_type' => array('post','page','lecture','chapter','subject','professor'),
        's' => sanitize_text_field($data['keyword']),
        // 'posts_per_page' => -1
    ));

    $results = array(
        'postsPages' => array(),
        'lectures' => array(),
        'chapters' => array(),
        'subjects' => array(),
        'professors' => array()
    );

    
    while ($mainQuery->have_posts()) {
        $mainQuery->the_post();

        if (get_post_type() == 'post' || get_post_type() == 'page') {
            array_push($results['postsPages'],array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'postType' => get_post_type(),
                'authorName' => get_the_author()
            ));
        }

        if (get_post_type() == 'lecture') {
            $lectureDate = DateTime::createFromFormat('d/m/Y',get_field('lecture_date'));

            array_push($results['lectures'],array(
                'title' => wp_trim_words(get_the_title(), 7,''),
                'content' => wp_trim_words(get_the_content(), 20),
                'permalink' => get_the_permalink(),
                'month' => $lectureDate->format('M'),
                'day' => $lectureDate->format('d')
            ));
        }
        
        if (get_post_type() == 'chapter') {
            $relatedSubjects = get_field('related_subjects');

            if ($relatedSubjects) {
                foreach ($relatedSubjects as $subject) {
                    array_push($results['subjects'],array(
                        'title' => get_the_title($subject)
                    ));           
                }
            }

            array_push($results['chapters'],array(
                'title' => get_the_title(),
                'id' => get_the_ID()
            ));
        }

        if (get_post_type() == 'subject') {
            array_push($results['subjects'],array(
                'title' => get_the_title(),
                'id' => get_the_ID()
            ));
        }

        if (get_post_type() == 'professor') {
            $subjectsTaught = get_field('subjects_taught');

            if ($subjectsTaught) {
                foreach ($subjectsTaught as $subject) {
                    array_push($results['subjects'],array(
                        'title' => get_the_title($subject)
                    ));           
                }
            }

            array_push($results['professors'],array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0,'thumbnail')
            ));
        }
    }

    $results['subjects'] = array_values(array_unique($results['subjects'],SORT_REGULAR));



    if($results['chapters']){
        $metaQuery = array('relation' => 'OR');

        foreach ($results['chapters'] as $lecture) {
            array_push($metaQuery,array(
                'key' => 'related_chapter',
                'compare' => 'LIKE',
                'value' => $lecture['id']
            ));
        }

        $chapterMetaQuery = new WP_Query(array(
            'post_type' => 'lecture',
            'meta_query' => $metaQuery
        ));

        while ($chapterMetaQuery->have_posts()) {
            $chapterMetaQuery->the_post();

            $lectureDate = DateTime::createFromFormat('d/m/Y',get_field('lecture_date'));

            array_push($results['lectures'],array(
                'title' => wp_trim_words(get_the_title(), 7,''),
                'content' => wp_trim_words(get_the_content(), 20),
                'permalink' => get_the_permalink(),
                'month' => $lectureDate->format('M'),
                'day' => $lectureDate->format('d')
            ));
        }
    }

    $results['lectures'] = array_unique($results['lectures'],SORT_REGULAR);

    return $results;
}