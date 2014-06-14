<?php

/**
 * @file
 * template.php
 */

/**
 * Implements template_preprocess_html().
 *
 */
function haproductions_bs_preprocess_html(&$variables) {
  $variables['classes_array'][] = 'light';
}

/**
 * Implements template_preprocess_node
 *
 */
function haproductions_bs_preprocess_node(&$variables) {

  // Add node--node_type--view_mode.tpl.php suggestions.
  $variables['theme_hook_suggestions'][] = 'node__' . $variables['type'] . '__' . $variables['view_mode'];

  // Add node--view_mode.tpl.php suggestions.
  $variables['theme_hook_suggestions'][] = 'node__' . $variables['view_mode'];

  $variables['title_attributes_array']['class'][] = 'node-title';

  // Add a class for the view mode.
  if (!$variables['teaser']) {
    $variables['classes_array'][] = 'view-mode-' . $variables['view_mode'];
  }

  if($variables['type'] == 'video'){
    if($variables['view_mode'] == 'full' || $variables['view_mode'] == 'search_result'){
      if($variables['node']->is_legacy){
        $variables['classes_array'][] = 'legacy';
      }
      if($variables['node']->non_anime){
        $variables['classes_array'][] = 'non-anime';
      }
    }
  }
}

/**
 * Implements hook_preprocess_block()
 */
function haproductions_bs_preprocess_block(&$variables) {
  $variables['content_attributes_array']['class'][] = 'block-content';

  if($variables['block']->region == 'sidebar_second'){
    $variables['title_attributes_array']['class'][] = 'panel';
    $variables['content_attributes_array']['class'][] = 'panel';
  }
}

/**
 * Implements template_preprocess_field()
 */
function haproductions_bs_preprocess_field(&$variables) {
  switch ($variables['element']['#field_name']) {
    case 'field_images':
      $variables['item_count'] = count($variables['items']);
      if($variables['item_count'] == 3){
        $variables['bs_columns'] = 4;
      }
      else if($variables['item_count'] == 2){
        $variables['bs_columns'] = 6;
      }
      else{
        $variables['bs_columns'] = 12;
      }
      break;
  }
}
