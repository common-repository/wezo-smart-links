function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function insertSmartLinks() {
	
	var tagtext = "";
	
	var automatic = document.getElementById('automatic_panel');
	var manual = document.getElementById('manual_panel');
	var path_plugin = document.getElementById('path').value;

	// who is active ?
	if (automatic.className.indexOf('current') != -1) {

		jQuery.ajax({
			  type: 'POST',
			  url: path_plugin +'/wezo-smart-links/process.php?insert=true',
			  data: jQuery('#formNewLinks').serialize(),
			  success: function(data) {
				   var id_links = data;

				   tagtext = "[smartlinks id=\"" + id_links + "\" ]";

				   window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
				   
				   tinyMCEPopup.close();
			 }
		});

		
	}

	
	if (manual.className.indexOf('current') != -1) {

		

	}
	

	if(tagtext != "" && window.tinyMCE) {
		//TODO: For QTranslate we should use here 'qtrans_textarea_content' instead 'content'
		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
		//Repaints the editor. Sometimes the browser has graphic glitches. 
		//tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	return;
}

function addMoreFields(){
	
	var field = jQuery('#field_default').clone();

	var num_elements = jQuery('#new_smart_links tr').length;
	
	if(num_elements == 7){
		alert('maximum number of fields is 4');
		return false;
	}
	jQuery(field).find('input:text').val('');
	
	jQuery(field).removeAttr('id').attr('id' , 'el_'+num_elements);
	
	jQuery(field).find('#more_field').removeAttr('onclick').attr('onclick' , 'removeThis('+num_elements+')').val('-');

	jQuery(field).insertBefore('#field_default_null');

}

function removeThis(el_for_remove){
	jQuery('#el_'+el_for_remove).remove();
}

function loadListSmartLinks(){
	var path_plugin = document.getElementById('path').value;
	jQuery('#listSmartLinks').load(path_plugin+'/wezo-smart-links/process.php?show=linksSmartLinks');
	
}
function insertIntoFrame(numberLink){
	tagtext = "[smartlinks id=\"" + numberLink + "\" ]";
	window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
	tinyMCEPopup.close();
}
