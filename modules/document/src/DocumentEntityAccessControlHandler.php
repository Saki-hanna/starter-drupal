<?php

namespace Drupal\document;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Document entity entity.
 *
 * @see \Drupal\document\Entity\DocumentEntity.
 */
class DocumentEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\document\Entity\DocumentEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished document entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published document entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit document entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete document entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add document entity entities');
  }

}
