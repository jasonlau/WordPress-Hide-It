<?php
/**
 * @package Hide It
 * @version 1.0.0 
 * @author Jason Lau
 * @link http://jasonlau.biz
 * @copyright 2011
 * @license GNU/GPL 3+
 * @uses WordPress
 
Plugin Name: Hide It
Plugin URI: http://jasonlau.biz
Description: This plugin allows you to toggle visibility of any objects from within a post or page using shorttags and CSS class name or id attribute selectors. Example: [hideit hide=".widget-1, #header-div" show=".widget-2"]. A .dot indicates this is a class name, a #hash mark indicates this is an id attribute, and a comma separates each object. Easy enough. You can get an object's id or class name by viewing the source code for your webpage.
Author: Jason Lau
Version: 1.0.0
Author URI: http://jasonlau.biz
*/

if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    exit('Please don\'t access this file directly.');
}

function hideit_manager(){
?>
<div class="wrap">
<div id="icon-tools" class="icon32"><br /></div>
<h2>Hide It</h2>
<hr />
<p><strong>Hide It</strong> allows you to toggle visibility of any objects from within a post or page using shorttags and CSS class name or id attribute selectors.</p>
<p><strong>Hide It</strong> requires no additional settings.</p>
<p><strong>Instructions:</strong><br />
Include the Hide It short tag in your post or page content.
</p>
<strong>Examples:</strong><br />
<code>[hideit hide=".widget-1, #header-div" show=".widget-2"]</code><br />
<strong>Or more advanced: </strong><br />
<code>[hideit hide="#content .post:first, p:contains('Lorem ipsum dolor sit amet')" show="li[class='page-item-31'], p:not(p:[rel~='something'])"]</code>
<p><strong>FYI:</strong> A <code>.dot</code> indicates this is a class name (i.e. <code>.myclass</code>), a <code>#hash</code> mark indicates this is an id attribute (i.e. <code>#my-id</code>), and if there is no preceding character(i.e. <code>input:[name='submit']</code>), it indicates this is a HTML tag. Easy enough. You can get an object's id or class name by viewing the source code for the webpage.</p>
<p>This plugin supports any of the <a href="http://api.jquery.com/category/selectors/" target="_blank">selectors supported by jQuery</a>.</p>
<br />
<hr />
<a href="http://www.gnu.org/licenses/gpl.html" target="_blank"><img src="http://www.gnu.org/graphics/gplv3-127x51.png" alt="GNU/GPL" border="0" /></a><em><strong>Share And Share-Alike!</strong></em><br />
<code><strong>Another <em><strong>Quality</strong></em> Work From  <a href="http://JasonLau.biz" target="_blank">JasonLau.biz</a></strong> - &copy;2011 Jason Lau</code>
</div>
<?php
}


function hideit_hook($atts, $content) {
    $hide_objects = explode(",", $atts['hide']);
    $show_objects = explode(",", $atts['show']);
    $output = "\n\n<!-- HIDE IT -->\n"
             ."<script type=\"text/javascript\">\n"
             ."jQuery(function(){\n";
    if(count($hide_objects) > 0)
    foreach($hide_objects as $hide):
    $output .= "jQuery(\"" . trim($hide) . "\").hide();\n";
    endforeach;
    foreach($show_objects as $show):
    $output .= "jQuery(\"" . trim($show) . "\").show();\n";
    endforeach;                
    $output .= "});\n"
              ."</script>\n"
              ."<!-- HIDE IT -->\n\n";
    return $content.$output;    
}

function hideit_admin_menu(){
    add_submenu_page('tools.php', 'Hide It', 'Hide It', 'update_plugins', 'hide-it', 'hideit_manager');
}

function hideit_install(){
   add_option('_data', '');
}

function hideit_deactivate(){
    delete_option('_data');
}

function hideit_init() {
    wp_enqueue_script('jquery');            
} 
   
add_shortcode('hideit', 'hideit_hook');
add_action('init', 'hideit_init');
add_action('admin_menu', 'hideit_admin_menu');
register_activation_hook(__FILE__, 'hideit_install');
register_deactivation_hook(__FILE__, 'hideit_deactivate');
?>