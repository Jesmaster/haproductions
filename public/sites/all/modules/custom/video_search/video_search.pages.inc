<?php

function video_search_page_callback(){
	$render = array();

	libraries_load('typewatch');
	drupal_add_js(drupal_get_path('module', 'video_search').'/video_search.js');

	$render['form'] = drupal_get_form('video_quicksearch_form');
	$render['results'] = array(
		'#prefix' => '<div id="video-quicksearch-results">',
		'#suffix' => '</div>',
	);

	return $render;
}

function video_quicksearch_form($form,&$form_state){
	$form['search'] = array(
		'#title' => 'Type anything to search for videos:',
		'#type' => 'textfield',
	);

	$form['submit'] = array(
		'#type' => 'submit',
		'#value' => 'Search',
		'#ajax' => array(
			'callback' => 'video_search_quicksearch_ajax_callback',
			'wrapper' => 'video-quicksearch-results',
		),
	);

	return $form;
}

function video_search_quicksearch_ajax_callback($form,&$form_state){
	return video_search_quicksearch($form_state['values']['search']);
}