<?php

add_action('rest_api_init', 'likeRoutes');

function likeRoutes(){
    register_rest_route('likeroute/v2', 'manageLike', array(
        'methods' => 'POST',
        'callback' => 'createLike'
    ));

    register_rest_route( 'likeroute/v2', 'manageLike', array(
        'methods' => 'DELETE',
        'callback' => 'deleteLike'
    ));
}

function createLike($data){
    if (is_user_logged_in()) {
        $professorID = sanitize_text_field($data['professorID']);

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

        if ($likedProfessor->found_posts == 0 AND get_post_type($professorID) == 'professor') {
            return wp_insert_post(array(
                'post_type' => 'like',
                'post_status' => 'publish',
                'meta_input' => array(
                    'like_professor_id' => $professorID
                )
            ));
        }else {
            die("Invalid professor id");
          }

    } else {
        die('Only logged in users can like a professor');
    }
    
}

function deleteLike($data){
    $likeId = sanitize_text_field($data['like']);
    if (get_current_user_id() == get_post_field('post_author', $likeId) AND get_post_type($likeId) == 'like') {
        wp_delete_post($likeId, true);
        return 'Congrats, like deleted.';
    } else {
        die("You do not have permission to delete that.");
    }
}