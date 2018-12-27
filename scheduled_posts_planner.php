<?php
/**
	* Plugin Name: Scheduled Posts Planner
	* Plugin URI: http://www.webinsights.ca
	* Description: This plugin clearly displays your last 3 scheduled posts, total scheduled posts and 'view all' posts so that you can easily plan from the post page.
	* Author: Matthew Schonewille - Webinsights
	* Version: 1.0.0
	* Tested up to: 5.0.1
	* License: GPLv2 or later
*/

/** =====================================
* Action and function the executes the add meta box hook and function.
* =======================================
* add_meta_box - importat note is the priority is set to:
* --> 'post' to show up only on post pages
* --> 'side' where to have th meta box show up
* --> 'high' to have it go on top of the  publish meta box
* =======================================
*/

add_action( 'add_meta_boxes', 'add_custom_meta_box');

function add_custom_meta_box()
{
    add_meta_box('demo-meta-box', 'Recent Scheduled Posts', 'webins_meta_box_markup', 'post', 'side', 'high');
}

/** =====================================
* Function that creates the content for the meta box
* =======================================
* @param array $args is the array data that defines the data needed
* @param var $count_posts is to give a post count
* @param var $future_posts is the variable that represents the post count
*/

function webins_meta_box_markup(){

      // The Query
      $args = array(
         'post_type' => 'post',
         'post_status' => 'future',
         'posts_per_page' => 3,
         'orderby' => 'date',
      );

      $query = new WP_Query( $args );
      $count_posts = wp_count_posts();
      $future_posts = $count_posts->future;


    // The Loop to gather the data listed in the array
        if ( $query->have_posts() ) {

        	while ( $query->have_posts() ) {
        		      $query->the_post();

    // The table that will contain the data - the 3 lastest scheduled posts
          ?><table><?php
          /*<img src="<?php the_field('event_thumbnail'); ?>" /> Eventual code to put an icon for each post */
        		echo '<tr><th style="text-align: left; color:#21759b; font-weight: normal; "><a href="' . get_permalink() . '" style="text-decoration:none;">'; echo get_the_title( get_the_ID() ) . '</a></th></tr>';

            echo '<tr><th style="text-align: left; ">'. get_the_time( 'M d, Y @ h:m a' ) .'</th></tr>';
        } ?>
        </table>

   <!--The table that will contain the data - the 'view all' button and post total icon -->
        <table>
          <tr>
            <th><p class="textright"><a href="edit.php?post_status=future" class="button"><?php _e('View all'); ?></a></p></th>

            <th><button class="button button4" disabled="disabled">Total Scheduled: <?php echo $future_posts; ?></button></th>
          </tr>
        </table>

      <?php
  	// Restore original Post Data
          wp_reset_postdata();

        } else {

    // If there are no scheduled posts show this message
        	echo 'No scheduled posts found.';

        }
      }

?>
