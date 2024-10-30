<?php
/*
Plugin Name: Lazy Blog Stats
Plugin URI: http://www.ashsky.com/2010/04/lazy-blog-stats/
Description: A simple plugin that shows a count of how many posts, comments and users your blog has
Version: 1.0
Author: Gavin Mannion
Author URI: http://www.ashsky.com/
License: GPL2
*/
add_action('admin_init', 'LazyBlogStats_init' );
add_action('admin_menu', 'LazyBlogStats_add_page');

function ShowBlogStats() {
global $wpdb;
$options = get_option('LazyBlogStats'); 

if ($options['showComment'] == 1)
{
  $numcomms = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = '1'");
  if (0 < $numcomms) $numcomms = number_format($numcomms);
}
if ($options['showUser'] == 1) {
  $user_count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->users;");
  if (0 < $user_count) $user_count = number_format($user_count);
}

if( $options['showArticle'] == 1) {
  $published_posts = wp_count_posts()->publish;
  if (0 < $published_posts) $published_posts = number_format($published_posts);
}
?>
<table class="<?php echo $options['tableclass']; ?>">
 <?php if( $options['showArticle'] == 1) {?>
  <tr>
    <td><span class="<?php echo $options['textclass']; ?>">Posts:&nbsp;</span>
    <span class="<?php echo $options['valueclass']; ?>"><?php echo $published_posts?></span>
<div class="br"></div>
<?php }
if ($options['showComment'] == 1) {?>
    <span class="<?php echo $options['textclass']; ?>" align="right">Comments:&nbsp;</span>
    <span class="<?php echo $options['valueclass']; ?>"><?php echo $numcomms?></span>
<?php }
if ($options['showUser'] == 1) {?>
  <div class="br"></div>
  <span class="<?php echo $options['textclass']; ?>" align="right">Users:&nbsp;</span>
    <span class="<?php echo $options['valueclass']; ?>"><?php echo $user_count ?></span>
   </td>
  </tr>
<?php } ?>
</table>

<?php
}

// Add menu page
function LazyBlogStats_add_page() {
	add_options_page('Lazy Blog Stats Options', 'Lazy Blog Stats', 'manage_options', 'LazyBlogStatsOptions', 'LazyBlogStats_do_page');
}


function LazyBlogStats_init(){
    register_setting( 'LazyBlogStats_options', 'LazyBlogStats' );
}

      // Draw the menu page itself
function LazyBlogStats_do_page() { ?>
   <div class="wrap">
     <h2>Lazy Blog Stats Options</h2>
        <form method="post" action="options.php">
            <?php settings_fields('LazyBlogStats_options'); ?>
                 <?php $options = get_option('LazyBlogStats'); ?>
                     <table class="form-table">
                         <tr valign="top">
                           <th scope="row">Heading</th>
                           <td><input type="text" name="LazyBlogStats[TableHeading]" value="<?php echo $options['TableHeading']; ?>"/></td>
                         </tr>
                         <tr>
                           <th scope="row">Show Total Articles?</th>
                           <td><input type="checkbox" value="1" name="LazyBlogStats[showArticle]" <?php if($options['showArticle'] == 1) {echo 'checked';}?>/></td>
                         </tr>
                         <tr>
                           <th scope="row">Show Total Comments?</th>
                           <td><input type="checkbox" value="1" name="LazyBlogStats[showComment]" <?php if($options['showComment'] == 1) {echo 'checked';}?>/></td>
                         </tr>
                         <tr>
                           <th scope="row">Show Total Users?</th>
                           <td><input type="checkbox" value="1" name="LazyBlogStats[showUser]" <?php if($options['showUser'] == 1) {echo 'checked';}?>/></td>
                         </tr>
                         <tr valign="top">
                           <th scope="row">Header Class</th>
                           <td><input type="text" name="LazyBlogStats[headerclass]" value="<?php echo $options['headerclass']; ?>"/>&nbsp;(The CSS class to assign excluding the #)</td>
                         </tr>
                         <tr valign="top">
                           <th scope="row">Table Class</th>
                           <td><input type="text" name="LazyBlogStats[tableclass]" value="<?php echo $options['tableclass']; ?>"/>&nbsp;(The CSS class to assign excluding the #)</td>
                         </tr>
                         <tr valign="top">
                           <th scope="row">Text Class</th>
                           <td><input type="text" name="LazyBlogStats[textclass]" value="<?php echo $options['textclass']; ?>"/>&nbsp;(The CSS class to assign excluding the #)</td>
                         </tr>
                         <tr valign="top"><th scope="row">Value Class</th>
                           <td><input type="text" name="LazyBlogStats[valueclass]" value="<?php echo $options['valueclass']; ?>" />&nbsp;(The CSS class to assign excluding the #)</td>
                         </tr>
                    </table>
                <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                  </p>
              </form>
          </div>
          <?php   
      }

/*  Copyright 2010 Gavin Mannion  (email : gavin@lazygamer.co.za
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
