<?php

// look up for the path
require_once( dirname( dirname(__FILE__) ) . '/sv-config.php');

define('URL_CONTENT_PLUGIN', WP_CONTENT_URL . '/plugins/');



// check for rights
if ( !is_user_logged_in() || !current_user_can('edit_posts') ) 
	wp_die(__("You are not allowed to be here"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Add Smart Links</title>
	<script language="javascript" type="text/javascript" src="<?php echo SMARTLINKS_URLPATH ?>tinymce/jquery.min.js?v=1.7"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo SMARTLINKS_URLPATH ?>tinymce/tinymce.js?v=1.5"></script>
	
</head>
<body id="smartlink" onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';document.getElementById('auto_url').focus();" style="display: none">
<form onsubmit="return false;" action="#" id="formNewLinks">
	
	
	<div class="tabs">
		<ul>
			<li id="automatic_tab" class="current"><span><a href="javascript:mcTabs.displayTab('automatic_tab','automatic_panel');" onmousedown="return false;">{#SmartLinks.newlinks_title}</a></span></li>
			<li id="mannual_tab"><span><a href="javascript:mcTabs.displayTab('mannual_tab','manual_panel');loadListSmartLinks()" onmousedown="return false;">{#SmartLinks.listlinks_title}</a></span></li>
			<!--  <li id="flash_tab"><span><a href="javascript:mcTabs.displayTab('flash_tab','flash_panel');" onmousedown="return false;">{#SmartLinks.flash_title}</a></span></li> -->
		</ul>
	</div>

	<div class="panel_wrapper">
	

		<div id="automatic_panel" class="panel current" style="height:auto;">
          
          <div id="resultSmartLinks"></div>
          <table border="0" cellpadding="4" cellspacing="0" id="new_smart_links">
          
          
          <tr>
          <td class="nowrap" style="width: 100px"><label for="description">{#SmartLinks.field_description}</label></td>
          <td colspan="4">
          	<input id="description" name="description" type="text" class="mceFocus" value="Links Rápidos" style="width: 100px" onfocus="try{this.select();}catch(e){}" />
          </td>
          </tr>
          
          <tr>
          <td class="nowrap" style="width: 100px"><label for="newsmartlink_url">{#SmartLinks.field_url}</label></td>
          <td class="nowrap" style="width: 100px"><label for="newsmartlink_name">{#SmartLinks.field_name}</label></td>
          <td class="nowrap" style="width: 100px"><label for="newsmartlink_target">{#SmartLinks.field_target}</label></td>
          <td class="nowrap" style="width: 100px"><label for="newsmartlink_rel">{#SmartLinks.field_rel}</label></td>
          <td class="nowrap" style="width: 100px">&nbsp;</td>
          </tr>

          <tr id="field_default">
          
          <td>
          	<input id="newsmartlink_url" name="url[]" type="text" class="mceFocus" value="" style="width: 100px" onfocus="try{this.select();}catch(e){}" />
          </td>
          <td>
          	<input id="newsmartlink_name" name="name[]" type="text" class="mceFocus" value="" style="width: 100px" onfocus="try{this.select();}catch(e){}" />
          </td>
          <td>
            <select id="newsmartlink_target" name="target[]" class="mceFocus" style="width: 100px" onfocus="try{this.select();}catch(e){}">
              <option value="_blank" >{#SmartLinks.target_new_window}</option>
              <option value="_self" >{#SmartLinks.target_self_window}</option>
            </select>
          </td>
          <td>
            <select id="newsmartlink_rel" name="rel[]" class="mceFocus" style="width: 100px" onfocus="try{this.select();}catch(e){}">
              <option value="nofollow" >nofollow</option>
              <option value="" selected="selected" >none</option>
              <option value="alternate" >alternate</option>
              <option value="stylesheet" >stylesheet</option>
              <option value="start" >start</option>
              <option value="next" >next</option>
              <option value="prev" >prev</option>
              <option value="contents" >contents</option>
              <option value="index" >index</option>
              <option value="glossary" >glossary</option>
              <option value="copyright" >copyright</option>
              <option value="chapter" >chapter</option>
              <option value="section" >section</option>
              <option value="subsection" >subsection</option>
              <option value="appendix" >appendix</option>
              <option value="help" >help</option>
              <option value="bookmark" >bookmark</option>
              <option value="license" >license</option>
              <option value="tag" >tag</option>
              <option value="friend" >friend</option>
            </select>
          </td>
          <td>
          	<input type="button" name="more_field" id="more_field" value="+"  onclick="addMoreFields()"/>
          </td>
          
          </tr>
          <tr id="field_default_null"></tr>
          
          </table>
		</div>
		
		
		
		
		<div id="manual_panel" class="panel" style="height:auto;">
		<div id="listSmartLinks"></div>
		<!-- 
		<table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td class="nowrap"><label for="href">{#SmartLinks.site_list}</label></td>
            <td>
			  <select id="tag_list" name="tag_list">
			    <option value="youtube">Youtube</option>
			    <option value="vimeo">Vimeo</option>
			  </select>
			</td> 
          </tr>
          <tr>
            <td class="nowrap"><label for="href">{#SmartLinks.manual_id}</label></td>
            <td><input id="manual_id" name="href" type="text" class="mceFocus" value="" style="width: 100px" onfocus="try{this.select();}catch(e){}" /></td> 
          </tr>
		  <tr>
			<td><label for="link_list">{#SmartLinks.width}</label></td>
			<td><input id="manual_width" name="href" type="text" class="mceFocus" value="" style="width: 50px" onfocus="try{this.select();}catch(e){}" /> ({#SmartLinks.blank})</td>
		  </tr>
		  <tr>
			<td><label id="targetlistlabel" for="targetlist">{#SmartLinks.height}</label></td>
			<td><input id="manual_height" name="href" type="text" class="mceFocus" value="" style="width: 50px" onfocus="try{this.select();}catch(e){}" /> ({#SmartLinks.blank})</td>
		  </tr>
        </table>
        -->
        
		</div>
		
		<!--  
		<div id="flash_panel" class="panel" style="height:100px;">

		<table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td class="nowrap"><label for="href">{#SmartLinks.flash_url}</label></td>
            <td><input id="flash_url" name="href" type="text" class="mceFocus" value="" style="width: 100px" onfocus="try{this.select();}catch(e){}" /></td> 
          </tr>
		  <tr>
			<td><label for="link_list">{#SmartLinks.width}</label></td>
			<td><input id="flash_width" name="href" type="text" class="mceFocus" value="" style="width: 50px" onfocus="try{this.select();}catch(e){}" /> ({#SmartLinks.blank})</td>
		  </tr>
		  <tr>
			<td><label id="targetlistlabel" for="targetlist">{#SmartLinks.height}</label></td>
			<td><input id="flash_height" name="href" type="text" class="mceFocus" value="" style="width: 50px" onfocus="try{this.select();}catch(e){}" /> ({#SmartLinks.blank})</td>
		  </tr>
        </table>
		</div>
		
		-->
	</div>

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
		</div>

		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="{#insert}" onclick="insertSmartLinks();" />
		</div>
	</div>
	
	<input type="hidden" name="path" id="path" value="<?php echo URL_CONTENT_PLUGIN ?>" ></input>
</form>
</body>
</html>
