<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head(); ?>
</head>
<body>

<header class="site-header">
    <div class="site-header__top-nav">
        <div class="wrapper">
            <ul class="site-header__top-nav__links">
                <li><a href="<?php echo site_url(); ?>">Home</a></li>
                <li><a href="<?php echo site_url('/about'); ?>">About</a></li>
                <li><a href="<?php echo site_url('/contact'); ?>">Contact Us</a></li>
                <li><a href="#" class="search"><i class="fa fa-search"></i></a></li>
            </ul>
        </div>
    </div>

    <div class="site-header__logo">
        <div class="wrapper">
            <a href="<?php echo site_url(); ?>"><img src="<?php echo get_theme_file_uri('/img/logo.jpg'); ?>" alt="Logo"></a>
        </div>
    </div>

    <div class="wrapper">
        <nav class="site-header__nav">

            <ul class="site-header__nav--links">
                <li><a href="<?php echo get_post_type_archive_link('lecture'); ?>">lectures</a></li>
                
               <?php
                    $departament = new WP_Query(array(
                        'posts_per_page' => -1,
                        'post_type' => 'departament'
                    ));
                    
                    while($departament->have_posts()){
                        $departament->the_post();
               ?>

                <li><a href="#" class="site-header__nav--links__subjects"><?php the_title(); ?></a>
                    <ul>
                        <?php
                            $relatedSubjects = get_field('related_subjects');

                            if ($relatedSubjects) {
                                foreach ($relatedSubjects as $subject) { ?>  
                                    <li><a href="<?php echo get_the_permalink($subject) ?>" ><?php echo get_the_title($subject); ?></a></li>
                                <?php
                                }
                            }
                        ?>
                    </ul>    
                </li>
                <?php }?>
                
            </ul>
            <ul class="site-header__nav--credentials-search">
             <?php if(is_user_logged_in()) { ?>
                <li><a href="<?php echo site_url('/my-notes'); ?>"><i class="fas fa-clipboard"></i> my notes</a></li>
                <li><a href="<?php echo wp_logout_url(); ?>"><i class="fas fa-sign-out-alt"></i> log out</a></li>
             <?php }else{ ?>   
                <li><a href="<?php echo wp_login_url(); ?>"><i class="fa fa-sign-in-alt"></i> log in</a></li>
                <li><a href="<?php echo wp_registration_url(); ?>"><i class="fa fa-user-plus"></i> sign up</a></li>
             <?php } ?>   
                <li><a href="#" class="search"><i class="fa fa-search"></i></a></li>
            </ul>
        </nav>


        <!-- MOBILE MENU -->
        <select name="mobile_navigation" id="mobile_navigation">
            <option value="#">Navigate to ...</option>
            <option value="<?php echo get_post_type_archive_link('lecture'); ?>">Lectures</option>
        <?php
            $departament = new WP_Query(array(
                   'posts_per_page' => -1,
                   'post_type' => 'departament'
            ));
               
               while($departament->have_posts()){
                   $departament->the_post();

                   echo '<option value="#">' . get_the_title() . '</option>';

                    $relatedSubjects = get_field('related_subjects');    
                    if ($relatedSubjects) {
                        foreach ($relatedSubjects as $subject) {
                            echo '<option value="' . get_the_permalink($subject) .'">- ' . get_the_title($subject) . '</option>';
                        }
                    }
                }?>
                
                <?php if(is_user_logged_in()) { ?>
                    <option value="<?php echo site_url('/my-notes'); ?>">My Notes</option>
                    <option value="<?php echo wp_logout_url(); ?>">Log Out</option>
                <?php }else{ ?>
                    <option value="<?php echo wp_login_url(); ?>">Log In</option>
                    <option value="<?php echo wp_login_url(); ?>">Sign Up</option>

                <?php } ?>  
        </select>

    </div>
</header>