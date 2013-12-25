<?php

function video_search_page_callback($keywords = ''){
	$render = array();
	
	libraries_load('jquery_cycle');
	libraries_load('isotope');
	drupal_add_js(drupal_get_path('module', 'video_search').'/video_search.js');

	$render['#prefix'] = '<div class="row">';
	$render['#suffix'] = '</div>';

	$render['form'] = drupal_get_form('video_quicksearch_form', $keywords);
	$render['show_all'] = array(
		'#markup' => '<div class="small-3 columns"><button class="small" id="show-all-videos">Show All</button></div>',
	);
	$render['results'] = video_search_quicksearch();

	return $render;
}

function video_quicksearch_form($form,&$form_state,$keywords){
	$form = array(
		'#prefix' => '<div class="small-6 columns">',
		'#suffix' => '</div>',
	);

	$form['search'] = array(
		'#title' => 'Video Search:',
		'#default_value' => str_replace('-',' ',$keywords), 
		'#type' => 'textfield',
		'#prefix' => '<div class="row collapse"><div class="small-10 columns">',
		'#suffix' => '</div>',
		'#theme_wrappers' => array(),
	);

	$form['submit'] = array(
		'#type' => 'submit',
		'#value' => 'Search',
		'#ajax' => array(
			'callback' => 'video_search_quicksearch_ajax_callback',
			'wrapper' => 'video-quicksearch-results',
		),
		'#attributes' => array('style' => array('display:none')),
		'#prefix' => '<div class="small-2 columns"><button id="search-videos" class="postfix fi-magnifying-glass">Search</button>',
		'#suffix' => '</div></div>',
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