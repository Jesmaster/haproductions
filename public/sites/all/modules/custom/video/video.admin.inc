<?php

function video_settings_form($form,&$form_state){
	$form['cloudfront_domain'] = array(
		'#title' => 'Cloudfront Domain',
		'#type' => 'textfield',
		'#default_value' => variable_get('cloudfront_domain',''),
	);

	return system_settings_form($form);
}