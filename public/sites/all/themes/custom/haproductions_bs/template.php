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