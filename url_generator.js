// JavaScript Document
jQuery(document).ready(function(){
//== global variables====
	var words =[],bracket_inside =[];
	var pluginUrl = front_urlGenerator_url.pluginUrl;
//== template=====
	jQuery('#template').keyup(function(){
		var bracket_inside =[], key, word='', longest='', array_longests=[],char_length,char;
		var reg = /\(([^\)]+)\)/g, match;
		char = jQuery(this).val(); 				//console.log(char);
		while(match = reg.exec(char)) {
		//	if(jQuery.inArray(match[1], bracket_inside)== -1) {
			bracket_inside.push(match[1]);
		//	}
		}
		char = char.replace(/\((.*?)\)/g,'');
		char_length = char.length;		//  clear string length
		if (bracket_inside.length >0){
			
			for(key in bracket_inside) {
				words[key] = bracket_inside[key].split('|');
				for (var k in words[key]) {
					word = 	words[key][k] = words[key][k].replace(/\s+/g, '');
						if(word.length > longest.length) {
							longest = word;
						}
				}
				char_length = char_length + longest.length; // added longest length
				array_longests.push(longest); // array of longest for each ()
				longest='';										
			}		
		}
		jQuery('#urlG_info_smbl > span').text(char_length); // addede into node
					
	});
	
//=== post link ========	
	jQuery('#url_btn').click(function(){
		var link = jQuery('#url_link').val();
		jQuery('.ajax_loader').empty();
	// === ajax ==== 
		var data_post = {
		action: 'fronturlGeneratoraction',
		url: link
	};
	
	jQuery.ajax({
    url: front_urlGeneratorajax.ajaxurl, 
    type: 'post',
    data:	data_post,
	dataType: 'json', 
	beforeSend: function(){
		
		jQuery('.ajax_loader').append('<img src="'+pluginUrl+'/url_generator/ajax-loader.gif">');
	}, 
    success: function( data ){
		jQuery('.ajax_loader').empty();
		if(data != 'error'){
		jQuery('#urlG_info_title ').text(data.title);
		jQuery('#urlG_info_desc ').text(data.desc);
		jQuery('#urlG_info_h1 ').text(data.h1);
		} else {
			jQuery('.ajax_loader').empty();
			jQuery('#urlG_info_title ').text('Ошибка');
			jQuery('#urlG_info_desc ').text('Ошибка');
			jQuery('#urlG_info_h1 ').text('Ошибка');
		}
	},
		error: function() {
			jQuery('.ajax_loader').empty();	
			jQuery('#urlG_info_title ').text('Ошибка');
			jQuery('#urlG_info_desc ').text('Ошибка');
			jQuery('#urlG_info_h1 ').text('Ошибка');
		}
	});
		
	});
	
//========== create anons ====================
	jQuery('#create_btn').click(function(){
		jQuery('#result').val('');
		var char = jQuery('#template').val();
		var random_variant =[];
		for(var key in words) {
			random_variant.push(words[key][Math.floor(Math.random()*words[key].length |0)]);
		}
		for(var k in random_variant){
			char = char.replace(/\((.*?)\)/, random_variant[k]);
		}
									//console.log(random_variant);
		jQuery('#result').val(char);

	});
//========= copy result =========================
	jQuery('#copy_result_btn').click(function(){
		var copyText = document.getElementById("result");
		copyText.select();
		document.execCommand("copy");
		
	});
//========= copy total =========================
	jQuery('#copy_total_btn').click(function(){
		var copyText = document.getElementById("total");
		copyText.select();
		document.execCommand("copy");
		
	});
//==== utm =====================================
	jQuery('.socbtn button').click(function(){
		var txt = jQuery(this).text(); 
		var link = jQuery('#url_link').val(); 
		var utm = link;					//console.log(utm);
		var last_slash = utm.lastIndexOf('/');
		utm = utm.substring(last_slash+1); //console.log(utm);
		var utm_content;
		var last_dot = utm.lastIndexOf('html'); //console.log(last_dot);
		if (last_dot > 0) {
			utm_content = utm.slice(0, last_dot -1);// console.log(utm_content);
		} else {
			utm_content = utm;
		}
		var utm_source='', utm_medium='',utm_campaign='',extention='';
			//console.log(txt);
	if(txt == 'URL') {
		extention='utm_content='+utm_content+'&utm_source='+utm_source+'&utm_medium='+utm_medium+'&utm_campaign='+utm_campaign;
		//console.log(extention);
	}
	if(txt == 'Вконтакте') {
				utm_source = 'vk';
		extention='utm_source='+utm_source;
	};
	if(txt == 'OK'){
				utm_source = 'ok';
				extention='utm_source='+utm_source;
	};
	if(txt == 'FaceBook'){
				utm_source = 'fb';
				extention='utm_source='+utm_source;
	};
	if(txt == 'Instagram'){
				utm_source = 'instagram';
				extention='utm_source='+utm_source;
	};
	if(txt == 'Twitter'){
				utm_source = 'twitter';
				extention='utm_source='+utm_source;
			
				  }
		link = link +'?'+extention;
		jQuery('#total').val(link);
	});
	
});