<?php
/*
Plugin Name:  SysOps Post of the Day
Plugin URI:   https://artsysops.com
Description:  Display random featured post on your website homepage. Motivate readers to visit your site for a random selection of your interesting posts. 
Version:      1.0.0
Author:       Wallace Mwabini
Author URI:   https://w.mwabini.co.ke
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined("ABSPATH") ){
    exit;
}

function post_of_the_day_enqueue_styles() {
    $bootstrap_url = 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css'; 
    wp_enqueue_style('post-of-the-day-bootstrap', $bootstrap_url, array(), '5.2.3', 'all');
  }

  add_action('wp_enqueue_scripts', 'post_of_the_day_enqueue_styles');

function fetch_all_posts(){

    if(is_front_page()){
        $args = array(
            'post_type' => 'post',
            'orderby' => 'rand',
            'post_per_page' => 1,
        );

        $date_today = date('l d M, Y');
    
        $query = new WP_Query( $args );
    
        if ( $query->have_posts() ){
            while ( $query->have_posts() ){
                $query->the_post();
                
                $todays_post_url = get_permalink( $query->the_post_id );
                $todays_post_title = get_the_title( $query->the_post_id );
    
                printf(
                    '<div class="text-center alert alert-primary alert-dismissible fade show"  role="alert">
                        <div class="">
                            <small>&#9824; Editor\'s Pick for  %s &#9824; </small>
                            <strong class="mr-auto">%s <a class="btn btn-sm btn-danger" href="%s" target="_blank">Read More</a></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>', 
                    $date_today, $todays_post_title, $todays_post_url
                );
                break;
            }
        }

    }    
}
add_action( 'wp_head', 'fetch_all_posts' );