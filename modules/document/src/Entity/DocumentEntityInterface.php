<?php

namespace Drupal\document\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Document entity entities.
 *
 * @ingroup document
 */
interface DocumentEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface
{

    // Add get/set methods for your configuration properties here.

    /**
     * Gets the Document entity name.
     *
     * @return string
     *   Name of the Document entity.
     */
    public function getName();

    /**
     * Sets the Document entity name.
     *
     * @param string $name
     *   The Document entity name.
     *
     * @return \Drupal\document\Entity\DocumentEntityInterface
     *   The called Document entity entity.
     */
    public function setName($name);

    /**
     * Gets the Document entity creation timestamp.
     *
     * @return int
     *   Creation timestamp of the Document entity.
     */
    public function getCreatedTime();

    /**
     * Sets the Document entity creation timestamp.
     *
     * @param int $timestamp
     *   The Document entity creation timestamp.
     *
     * @return \Drupal\document\Entity\DocumentEntityInterface
     *   The called Document entity entity.
     */
    public function setCreatedTime($timestamp);

    /**
     * Returns the Document entity published status indicator.
     *
     * Unpublished Document entity are only visible to restricted users.
     *
     * @return bool
     *   TRUE if the Document entity is published.
     */
    public function isPublished();

    /**
     * Sets the published status of a Document entity.
     *
     * @param bool $published
     *   TRUE to set this Document entity to published, FALSE to set it to unpublished.
     *
     * @return \Drupal\document\Entity\DocumentEntityInterface
     *   The called Document entity entity.
     */
    public function setPublished($published);

    public function getPublishDate();

    public function setPublishDate($publishDate);

    public function getPdfFile();

    public function setPdfFile($pdfFile);

}
