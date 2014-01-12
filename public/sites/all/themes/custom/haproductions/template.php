<?php

/**
 * Implements template_preprocess_html().
 *
 */
function haproductions_preprocess_html(&$variables) {
  $variables['classes_array'][] = 'light';
}

/**
 * Implements template_preprocess_page
 *
 */
//function haproductions_preprocess_page(&$variables) {
//}

/**
 * Implements template_preprocess_node
 *
 */
function haproductions_preprocess_node(&$variables) {
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
function haproductions_preprocess_block(&$variables) {
  $variables['content_attributes_array']['class'][] = 'block-content';

  if($variables['block']->region == 'content_sidebar'){
    $variables['title_attributes_array']['class'][] = 'panel';
    $variables['content_attributes_array']['class'][] = 'panel';
  }
}

//function haproductions_preprocess_views_view(&$variables) {
//}

/**
 * Implements template_preprocess_panels_pane().
 *
 */
//function haproductions_preprocess_panels_pane(&$variables) {
//}

/**
 * Implements template_preprocess_views_views_fields().
 *
 */
//function haproductions_preprocess_views_view_fields(&$variables) {
//}

/**
 * Implements theme_form_element_label()
 * Use foundation tooltips
 */
//function haproductions_form_element_label($variables) {
//  if (!empty($variables['element']['#title'])) {
//    $variables['element']['#title'] = '<span class="secondary label">' . $variables['element']['#title'] . '</span>';
//  }
//  if (!empty($variables['element']['#description'])) {
//    $variables['element']['#description'] = ' <span data-tooltip="top" class="has-tip tip-top" data-width="250" title="' . $variables['element']['#description'] . '">' . t('More information?') . '</span>';
//  }
//  return theme_form_element_label($variables);
//}

/**
 * Implements hook_preprocess_button().
 */
//function haproductions_preprocess_button(&$variables) {
//  $variables['element']['#attributes']['class'][] = 'button';
//  if (isset($variables['element']['#parents'][0]) && $variables['element']['#parents'][0] == 'submit') {
//    $variables['element']['#attributes']['class'][] = 'secondary';
//  }
//}

/**
 * Implements hook_form_alter()
 * Example of using foundation sexy buttons
 */
//function haproductions_form_alter(&$form, &$form_state, $form_id) {
//  // Sexy submit buttons
//  if (!empty($form['actions']) && !empty($form['actions']['submit'])) {
//    $form['actions']['submit']['#attributes'] = array('class' => array('primary', 'button', 'radius'));
//  }
//}

// Sexy preview buttons
//function haproductions_form_comment_form_alter(&$form, &$form_state) {
//  $form['actions']['preview']['#attributes']['class'][] = array('class' => array('secondary', 'button', 'radius'));
//}


/**
 * Implements template_preprocess_panels_pane().
 */
// function zurb_foundation_preprocess_panels_pane(&$variables) {
// }

/**
* Implements template_preprocess_views_views_fields().
*/
/* Delete me to enable
function THEMENAME_preprocess_views_view_fields(&$variables) {
 if ($variables['view']->name == 'nodequeue_1') {

   // Check if we have both an image and a summary
   if (isset($variables['fields']['field_image'])) {

     // If a combined field has been created, unset it and just show image
     if (isset($variables['fields']['nothing'])) {
       unset($variables['fields']['nothing']);
     }

   } elseif (isset($variables['fields']['title'])) {
     unset ($variables['fields']['title']);
   }

   // Always unset the separate summary if set
   if (isset($variables['fields']['field_summary'])) {
     unset($variables['fields']['field_summary']);
   }
 }
}

// */

/**
 * Implements theme_field__field_type().
 */
function haproductions_field__taxonomy_term_reference($variables) {
  $output = '';

  // Render the label, if it's not hidden.
  if (!$variables['label_hidden']) {
    $output .= '<h4 class="field-label">' . $variables['label'] . ': </h4>';
  }

  // Render the items.
  $output .= ($variables['element']['#label_display'] == 'inline') ? '<ul class="links inline">' : '<div class="links">';
  foreach ($variables['items'] as $delta => $item) {
    $output .= '<div class="taxonomy-term-reference-' . $delta . '"' . $variables['item_attributes'][$delta] . '>' . drupal_render($item) . '</div>';
  }
  $output .= '</div>';

  // Render the top-level DIV.
  $output = '<div class="' . $variables['classes'] . (!in_array('clearfix', $variables['classes_array']) ? ' clearfix' : '') . '">' . $output . '</div>';

  return $output;
}

/**
 * Implements hook_css_alter().
 */
function haproductions_css_alter(&$css) {
  // Always remove base theme CSS.
  $theme_path = drupal_get_path('theme', 'zurb_foundation');

  foreach($css as $path => $values) {
    if(strpos($path, $theme_path) === 0) {
      unset($css[$path]);
    }
  }
}

/**
 * Implements hook_js_alter().
 */
function haproductions_js_alter(&$js) {
  // Always remove base theme JS.
  $theme_path = drupal_get_path('theme', 'zurb_foundation');

  foreach($js as $path => $values) {
    if(strpos($path, $theme_path) === 0) {
      unset($js[$path]);
    }
  }
}

/**
 * Theme function to render a single top bar menu link.
 */
function haproductions_zurb_foundation_menu_link($variables) {
  $link = $variables['link'];
  if($link['#href'] == 'videos'){
    if($node = menu_get_object()){
      if($node->type == 'video'){
        $link['#localized_options']['attributes']['class'][] = 'active';
      }
    }
    else if(arg(0) == 'videos'){
      $link['#localized_options']['attributes']['class'][] = 'active';
    }
  }

  return l($link['#title'], $link['#href'], $link['#localized_options']);
}

/**
 * Implements hook_page_alter().
 */
function haproductions_page_alter(&$page) {
  //Check if the page has the video quicksearch form
  if(isset($page['content']['system_main']['form']['#form_id']) && $page['content']['system_main']['form']['#form_id'] == 'video_quicksearch_form'){
    $page['content']['system_main']['#prefix'] = '<div class="row">';
    $page['content']['system_main']['#suffix'] = '</div>';
  }
}

/**
 * Implements hook_form_alter().
 */
function haproductions_form_alter(&$form, &$form_state, $form_id) {
  switch ($form_id) {
    case 'video_quicksearch_form':
      $form['#prefix'] = '<div class="small-8 columns">';
      $form['#suffix'] = '</div><div class="small-2 columns"><button class="small" id="show-all-videos">Show All</button></div>';

      $form['search']['#prefix'] = '<div class="row collapse"><div class="small-11 columns">';
      $form['search']['#suffix'] = '</div>';
      $form['search']['#theme_wrappers'] = array();

      $form['submit']['#attributes'] = array('style' => 'display:none');
      $form['submit']['#prefix'] = '<div class="small-1 columns"><button id="search-videos" class="postfix fi-magnifying-glass">&nbsp;</button>';
      $form['submit']['#suffix'] = '</div></div>'; 
      break;
  }
}