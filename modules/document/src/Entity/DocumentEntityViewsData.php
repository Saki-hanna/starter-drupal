<?php

namespace Drupal\document\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Document entity entities.
 */
class DocumentEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
