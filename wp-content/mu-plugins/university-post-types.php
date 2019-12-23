<?php

function university_post_types(){
    register_post_type('departament',array(
        'labels' => array(
            'name' => 'Departament',
            'singular_name' => 'Departament',
            'add_new_item' => 'Add Departament',
            'edit_item' => 'Edit Departament',
            'all_items' => 'All Departaments'
        ),
        'public' => true,
        'supports' => array('title'),
        // 'has_archive' => true,
        'menu_icon' => 'dashicons-welcome-learn-more'
    ));


    register_post_type('subject',array(
        'labels' => array(
            'name' => 'Subject',
            'singular_name' => 'Subject',
            'add_new_item' => 'Add Subject',
            'edit_item' => 'Edit Subject',
            'all_items' => 'All Subjects'
        ),
        'public' => true,
        'supports' => array('title'),
        // 'has_archive' =>true,
        'menu_icon' => 'dashicons-category'
    ));


    register_post_type('chapter',array(
        'labels' => array(
            'name' => 'Chapter',
            'singular_name' => 'Chapter',
            'add_new_item' => 'Add Chapter',
            'edit_item' => 'Edit Chapter',
            'all_items' => 'All Chapters'
        ),
        'public' => true,
        'supports' => array('title'),
        // 'has_archive' =>true,
        'menu_icon' => 'dashicons-book'
    ));


    register_post_type('lecture',array(
        'labels' => array(
            'name' => 'Lecture',
            'singular_name' => 'Lecture',
            'add_new_item' => 'Add Lecture',
            'edit_item' => 'Edit Lecture',
            'all_items' => 'All Lectures'
        ),
        'public' => true,
        'supports' => array('title','editor','thumbnail'),
        'has_archive' => true,
        'menu_icon' => 'dashicons-welcome-write-blog'
    ));


    register_post_type('professor',array(
        'labels' => array(
            'name' => 'Professor',
            'singular_name' => 'Professor',
            'add_new_item' => 'Add Professor',
            'edit_item' => 'Edit Professor',
            'all_items' => 'All Professors'
        ),
        'public' => true,
        'supports' => array('title','editor','thumbnail'),
        // 'has_archive' => true,
        'menu_icon' => 'dashicons-admin-users'
    ));


    // register_post_type('campus',array(
    //     'labels' => array(
    //         'name' => 'Campus',
    //         'singular_name' => 'Campus',
    //         'add_new_item' => 'Add Campus',
    //         'edit_item' => 'Edit Campus',
    //         'all_items' => 'All Campuss'
    //     ),
    //     'public' => true,
    //     'supports' => array('title','editor','excerpt'),
    //     'has_archive' => true,
    //     'menu_icon' => 'dashicons-location-alt'
    // ));

    register_post_type('note',array(
        'labels' => array(
            'name' => 'Note',
            'singular_name' => 'Note',
            'add_new_item' => 'Add Note',
            'edit_item' => 'Edit Note',
            'all_items' => 'All Notes'
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'capability_type' => 'note',
        'map_meta_cap' => true,
        'supports' => array('title','editor'),
        'has_archive' => true,
        'menu_icon' => 'dashicons-welcome-write-blog'
    ));

    register_post_type('like', array(
        'supports' => array('title'),
        'public' => false,
        'show_ui' => true,
        'labels' => array(
          'name' => 'Likes',
          'add_new_item' => 'Add New Like',
          'edit_item' => 'Edit Like',
          'all_items' => 'All Likes',
          'singular_name' => 'Like'
        ),
        'menu_icon' => 'dashicons-heart'
    ));

}

add_action('init', 'university_post_types');