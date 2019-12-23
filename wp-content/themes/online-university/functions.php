<?php

//Scripts and styles
function university_files(){
    wp_enqueue_style( 'main_styles', get_stylesheet_uri() );
    wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Montserrat|Raleway&display=swap' );
    wp_enqueue_style( 'font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css' );
    wp_enqueue_script('modernizr', get_theme_file_uri('/js/Vendor/modernizr.js'));
    wp_enqueue_script( 'mobile-menu', get_theme_file_uri('/js/mobile-menu.js'), NULL, '1.0' , true );
    wp_enqueue_script( 'lectures-count', get_theme_file_uri('/js/lectures-count.js'), NULL, '1.0' , true );
    wp_enqueue_script( 'my-notes', get_theme_file_uri('/js/my-notes.js'), array('jquery'), '1.0' , true );
    wp_localize_script('my-notes', 'data', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ));
    wp_enqueue_script( 'like-professor', get_theme_file_uri('/js/like-professor.js'), array('jquery'), '1.0' , true );
    wp_enqueue_script( 'search', get_theme_file_uri('/js/search.js'), array('jquery'), '1.0' , true );
    wp_enqueue_script( 'lecture-extra-content', get_theme_file_uri('js/lecture-extra-content.js'), NULL, '1.0', true );
}

add_action('wp_enqueue_scripts','university_files');


//Featuers
function university_features(){
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'university_features');


//Adjust queries
function university_adjust_queries($query){
    if (!is_admin() && is_post_type_archive('lecture') && $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('posts_per_page', 4);
        $query->set('meta_key','lecture_date');
        $query->set('orderby','meta_value_num');
        $query->set('order','DESC');
        $query->set('meta_query',array(
           'key' => 'lecture_date',
           'compare' => '<=',
           'value' => $today,
           'type' => 'DATE'
        ));
    }

    if (!is_admin() && is_post_type_archive('subject') && $query->is_main_query()) {
        $query->set('posts_per_page', -1);
        $query->set('orderby','title');
        $query->set('order','ASC');        
    }
}

add_action('pre_get_posts', 'university_adjust_queries');


function lecturesLoop($singleLecture = NULL){?>
<div class="wrapper">
    <div class="content row">
        <div class="col col-md-8 content__info">
            <div class="content__info--lectures">
                <?php if (!$singleLecture) {?>
                
                <h1 class="content__info--lectures__header">All Lectures</h1>
                
                <?php
                }
                
                    while (have_posts()) {
                        the_post();
                        
                        $lecture_date =  DateTime::createFromFormat('d/m/Y',get_field('lecture_date'));
                        $month = $lecture_date->format('F');
                        $day = $lecture_date->format('d');
                        $year = $lecture_date->format('Y');


                        $monthNumber = $lecture_date->format('m');
                        $futureDateLecture = $year.$monthNumber.$day;
                        if($futureDateLecture > date('Ymd')){
                            echo '<script>location.href="' . site_url('/') . '"</script>';
                        }


                        $relatedChapter = get_field('related_chapter');
                        if ($singleLecture) {
                            echo '<h1 class="content__info--lectures__header">' . $relatedChapter[0]->post_title . '</h1>';
                        }
                ?>

                    <div class="content__info--lectures__content">
                            
                        <?php
                            
                            foreach ($relatedChapter as $chapter) {
                                if ($singleLecture) {
                                    echo '<h1 class="content__info--lectures__content--chapter">'.get_the_title().'</h1>';
                                } else {
                                    echo '<h1 class="content__info--lectures__content--chapter">'.get_the_title($chapter).'</h1>';
                                }
                                
                                    $chapterQuery = new WP_Query(array(
                                        'posts_per_page' => -1,
                                        'post_type' => 'chapter',
                                        'p' => $chapter->ID
                                    ));
                            
                                    if ($chapterQuery->have_posts()) {
                                        while ($chapterQuery->have_posts()) {
                                            $chapterQuery->the_post();
                                            
                                            $relatedSubject = get_field('related_subjects');
                
                                            foreach ($relatedSubject as $subject) {
                                                
                                                $subjectTitle = $subject->post_title;
                                                $subjectPermalink = $subject->guid;
                                                
                                                $professorQuery = new WP_Query(array(
                                                    'post_type' => 'professor',
                                                    'posts_per_page' => -1,
                                                    'meta_key' => 'subjects_taught',
                                                    'meta_query' => array(
                                                        array(
                                                            'key' => 'subjects_taught',
                                                            'compare' => 'like',
                                                            'value' => $subject->ID
                                                        )
                                                    )
                                                ));

                                                $professors = array();

                                                if ($professorQuery->have_posts()) {
                                                    while ($professorQuery->have_posts()) {
                                                        $professorQuery->the_post();
                                                        array_push($professors,array(
                                                            'title' => wp_trim_words(get_the_title(),1,''),
                                                            'permalink' => get_the_permalink()
                                                        ));
                                                    }wp_reset_postdata();
                                                       echo '<div class="content__info--lectures__content--professors-date">';
                                                        foreach ($professors as $professor) {                                                      
                                                            echo '<a href="'.$professor['permalink'].'">Professor '.$professor['title'].'</a>';
                                                        }
                                                        echo '<span class="content__info--lectures__content--professors-date__separator">&verbar;</span>';
                                                        echo '<span>' . $month .' ' .$day . ', ' . $year;
                                                       echo'</div>';
                                                }
                                            }
                                            
                                        }wp_reset_postdata();
                                    }
                
                            }?>
                            
                            <div class="content__info--lectures__content--loop">
                                <?php if($singleLecture) the_post_thumbnail('medium_large'); ?>
                                <div class="content__info--lectures__content--loop__description-permalink">

                                      <?php 
                                        if ($singleLecture) {
                                            the_content();
                                            
                                            echo '<div class="prev-next">';
                                                echo '<div>';
                                                previous_post_link('%link','&laquo; Previous');
                                                echo '</div>';
                                                
                                                echo '<div>';  
                                                next_post_link('%link','Next &raquo;');
                                                echo '</div>';
                                            echo '</div>';

                                            echo '<span class="single"><strong>Subject</strong>: <a href="' . $subjectPermalink . '">' . $subjectTitle . '</a></span>';
                                        } else {
                                            the_excerpt();
                                        }
                                        
                                        if(!$singleLecture){ ?>
                                        <a href="<?php the_permalink(); ?>" class="archive">continue reading</a>
                                    <?php  } ?>    
                                </div>
                                
                            </div>
                    </div> 
                        
                        <?php }wp_reset_postdata();
                            $args=array(
                                'prev_text' => __('<'),
	                            'next_text' => __('>')
                            );
                            echo '<div class="content__info--lectures__pagination">' . paginate_links($args) . '</div>';
                        ?>
            </div>
        </div>

        <div class="col col-md-4 content__sidebar">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php }

add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );

function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}


//Redirect subscriber accounts to front-end
add_action('admin_init', 'redirectSubs');

function redirectSubs(){
    $currentUser = wp_get_current_user();
    if (count($currentUser->roles) == 1 AND $currentUser->roles[0] == 'subscriber') {
        wp_redirect( site_url('/') );
        exit;
    }
}


add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar(){
    $currentUser = wp_get_current_user();
    if (count($currentUser->roles) == 1 AND $currentUser->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}


//Customize login screen
add_filter('login_headerurl', 'headerUrl');

function headerUrl(){
    return esc_url(site_url('/'));
}


add_filter('login_headertitle', 'loginTitle');

function loginTitle(){
    return get_bloginfo('name');
}


add_action('login_enqueue_scripts', 'loginCSS');

function loginCSS(){
    wp_enqueue_style('main_styles', get_stylesheet_uri());
}


//Make note private
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

function makeNotePrivate($data, $postArr){
    if ($data['post_type'] == 'note') {
        if(count_user_posts(get_current_user_id(), 'note') > 5 AND !$postArr['ID']) {
          die("You have reached your note limit.");
        }
    }

    if($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {
        $data['post_status'] = "private";
      }
      
      return $data;
}


function university_custom_rest() {
    // register_rest_field('post', 'authorName', array(
    //   'get_callback' => function() {return get_the_author();}
    // ));
  
    register_rest_field('note', 'userNoteCount', array(
      'get_callback' => function() {return count_user_posts(get_current_user_id(), 'note');}
    ));
  }
  
  add_action('rest_api_init', 'university_custom_rest');


  require get_theme_file_path('/includes/like-route.php');
  require get_theme_file_path('/includes/search-route.php');