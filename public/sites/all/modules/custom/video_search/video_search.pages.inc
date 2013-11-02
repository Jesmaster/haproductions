<?php

function video_search_page_callback($keywords = ''){
	$render = array();

	libraries_load('typewatch');
	libraries_load('jquery_cycle');
	libraries_load('isotope');
	drupal_add_js(drupal_get_path('module', 'video_search').'/video_search.js');

	$render['form'] = drupal_get_form('video_quicksearch_form', $keywords);
	$render['results'] = video_search_quicksearch();

	return $render;
}

function video_quicksearch_form($form,&$form_state,$keywords){
	$form['search'] = array(
		'#title' => 'Type anything to search for videos:',
		'#default_value' => str_replace('-',' ',$keywords), 
		'#type' => 'textfield',
	);

	$form['show_all'] = array(
		'#markup' => '<button id="show-all-videos">Show All</button>',
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
	return array(
		'#type' => 'ajax',
		'#commands' => array(
			array('command' => 'video_search_results', 'data' => video_search_quicksearch($form_state['values']['search']))
		),
	);
}