<?php

$classic_root = dirname(dirname(dirname(dirname(__FILE__)))) . '/' ;

require_once( $classic_root . '/wp-load.php');



if(isset($_GET['show'])):

  if($_GET['show'] == 'linksSmartLinks'){
  
  global $wpdb;
  $table_name = $wpdb->prefix . "smartlinks";

  $smartLinksDatas = $wpdb->get_results(
               $wpdb->prepare( "SELECT * FROM $table_name WHERE id != '1'")
             );
  
  $html = '<ul>';
 
  
  
  foreach ($smartLinksDatas as $smartLink){
      $description  = $smartLink->description;
      $id           = $smartLink->id;
      $data         = json_decode($smartLink->data);
      
      $html_tr = '<table border="0" cellpadding="4" cellspacing="0" style="display:none">';
      foreach ($data as $link){
        $html_tr .= " <tr> <td>$link->name</td>  <td>$link->url</td>  </tr> ";
      }
      $html_tr .= '</table>';
      $html .= "<li> $smartLink->description <a href='javascript:void(0)' onclick='insertIntoFrame($smartLink->id)'> #$smartLink->id </a><br> $html_tr  </li>";
  }           

  $html .= '</ul>';

  echo($html);
  }


endif;


if(isset($_GET['insert'])):


  smarlinks_submit();


endif;




function smarlinks_submit()
{
 $data = $_POST;

  global $wpdb;
  $table_name = $wpdb->prefix . "smartlinks";

  for ($i = 0; $i < count($data['url']); $i++) {
    $array_data[$i] = array(
      	'url'     => $data['url'][$i],
          'name'    => $data['name'][$i],
          'target'  => $data['target'][$i],
          'rel'     => $data['rel'][$i],
    );
  }

  $description_data = $data['description'];

  $array_data = json_encode($array_data);
  
  if(!$array_data){
    return false;
  }

  $dataNow = date('Y-m-d H:i:s');

  $rows_affected = $wpdb->insert($table_name, array(
    'description'  => $description_data ,
    'data'         => $array_data,
    'created_at'   => $dataNow,
  ));

  echo $wpdb->insert_id;
}


