<?php
/*
 Plugin Name: Smart Links - 1.0.1
 Plugin URI: http://www.wezo.com.br/
 Description: <strong>Plugin Smart Links by Wezo Alves </strong>inserts formatted block of links in the post ex: <strong>[smartlink id="1"]</strong>
 Version: 1.0
 Author: Wezo Alves
 Author URI: http://www.wezo.com.br
 License: GPL
 */


define('SMARTLINKS_URLPATH', WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__) ) . '/');
include_once (dirname(__FILE__) . '/tinymce/tinymce.php');

add_action('init','wezo_smartlinks');
add_action('init','smartlinks_install');
add_action('init','smartlinks_install_data');

function wezo_smartlinks()
{
  return "";
}


/*
 * Shortcode API - http://codex.wordpress.org/Shortcode_API
 */

function smartlinks_func( $atts )
{
  global $wpdb;
  $table_name = $wpdb->prefix . "smartlinks";

  extract( shortcode_atts( array(
  		'id' => 1,
  ), $atts ) );

  $sql = "SELECT * FROM $table_name WHERE `id` = $id LIMIT 1";

  $result_smartlinks = $wpdb->get_results($sql , 'ARRAY_A' );

  $data = json_decode($result_smartlinks[0]['data']);
  
  if($data == null){
    return false;
  }
  
  return _writeTagHtml($data , $result_smartlinks[0]['description']);

}

add_shortcode( 'smartlinks', 'smartlinks_func' );

/*
 * Creating Tables - http://codex.wordpress.org/Creating_Tables_with_Plugins
 */

function smartlinks_install ()
{
  global $wpdb;
  global $smartlinks_db_version;
  $smartlinks_db_version = "1.0.1";
  $table_name = $wpdb->prefix . "smartlinks";

  $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
	  description tinytext NOT NULL,
      data text NOT NULL,
      created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      UNIQUE KEY id (id)
	);";

  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);

  add_option("smartlinks_db_version", $smartlinks_db_version );
}

function smartlinks_install_data()
{
  global $wpdb;
  $table_name = $wpdb->prefix . "smartlinks";
   
  $array_data[] = array(
    'url'	  =>  'http://www.wezo.com.br',
    'name'	  =>  'Development by Wezo Alves',
    'target'  =>  '_blank',
  );
  $description_data = 'Plugin Instaled';

  $array_data = json_encode($array_data);

  $rows_affected = $wpdb->insert(
  $table_name, array( 'id' => '1' , 'description' => $description_data , 'data' => $array_data  , 'created_at' => current_time('mysql') )
  );

}


/*
 * Personal Functions
 * Write Links ul li a
 */
function _writeTagHtml($data_json , $title)
{
  $html  = '<ul>';
  $html .= '<li class="smartlink_title">'.$title.'</li>'; 
  
  foreach ($data_json as $link_data){
    $html .= '<li class="smartlink_action"><a href="'.$link_data->url.'"  target="'.$link_data->target.'"  alt="'.$link_data->name.'" rel="'.$link_data->rel.'"  >'.$link_data->name.'</a></li>';
  }
  
  $html .= '</ul>'; 

  return '<div id="smartlink_container"> '.$html.' </div>';
}

// gets included in the site header
function header_style() {
    $css = '
    <style type="text/css">
        #header {
            background: url(<?php header_image(); ?>);
        }
    </style>';
    return $css;
}

