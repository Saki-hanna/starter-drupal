<?php

/**
 * @file
 * Contains document_entity.page.inc.
 *
 * Page callback for Document entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Document entity templates.
 *
 * Default template: document_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_document_entity(array &$variables) {
  // Fetch DocumentEntity Entity Object.
  $document_entity = $variables['elements']['#document_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
