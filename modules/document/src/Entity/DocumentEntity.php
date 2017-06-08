<?php

namespace Drupal\document\Entity;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Entity\Annotation\ContentEntityType;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Document entity entity.
 *
 * @ingroup document
 *
 * @ContentEntityType(
 *   id = "document_entity",
 *   label = @Translation("Document entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\document\DocumentEntityListBuilder",
 *     "views_data" = "Drupal\document\Entity\DocumentEntityViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\document\Form\DocumentEntityForm",
 *       "add" = "Drupal\document\Form\DocumentEntityForm",
 *       "edit" = "Drupal\document\Form\DocumentEntityForm",
 *       "delete" = "Drupal\document\Form\DocumentEntityDeleteForm",
 *     },
 *     "access" = "Drupal\document\DocumentEntityAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\document\DocumentEntityHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "document_entity",
 *   admin_permission = "administer document entity entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/document_entity/{document_entity}",
 *     "add-form" = "/admin/structure/document_entity/add",
 *     "edit-form" = "/admin/structure/document_entity/{document_entity}/edit",
 *     "delete-form" = "/admin/structure/document_entity/{document_entity}/delete",
 *     "collection" = "/admin/structure/document_entity",
 *   },
 *   field_ui_base_route = "document_entity.settings"
 * )
 */
class DocumentEntity extends ContentEntityBase implements DocumentEntityInterface
{

    use EntityChangedTrait;

    /**
     * {@inheritdoc}
     */
    public static function preCreate(EntityStorageInterface $storage_controller, array &$values)
    {
        parent::preCreate($storage_controller, $values);
        $values += [
            'user_id' => \Drupal::currentUser()->id(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->get('name')->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->set('name', $name);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedTime()
    {
        return $this->get('created')->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedTime($timestamp)
    {
        $this->set('created', $timestamp);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOwner()
    {
        return $this->get('user_id')->entity;
    }

    /**
     * {@inheritdoc}
     */
    public function getOwnerId()
    {
        return $this->get('user_id')->target_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setOwnerId($uid)
    {
        $this->set('user_id', $uid);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setOwner(UserInterface $account)
    {
        $this->set('user_id', $account->id());
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isPublished()
    {
        return (bool)$this->getEntityKey('status');
    }

    /**
     * {@inheritdoc}
     */
    public function setPublished($published)
    {
        $this->set('status', $published ? TRUE : FALSE);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
    {
        $fields = parent::baseFieldDefinitions($entity_type);

        $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
            ->setLabel(t('Authored by'))
            ->setDescription(t('The user ID of author of the Document entity entity.'))
            ->setRevisionable(TRUE)
            ->setSetting('target_type', 'user')
            ->setSetting('handler', 'default')
            ->setTranslatable(TRUE)
            ->setDisplayOptions('view', [
                'label' => 'hidden',
                'type' => 'author',
                'weight' => 0,
            ])
            ->setDisplayOptions('form', [
                'type' => 'entity_reference_autocomplete',
                'weight' => 5,
                'settings' => [
                    'match_operator' => 'CONTAINS',
                    'size' => '60',
                    'autocomplete_type' => 'tags',
                    'placeholder' => '',
                ],
            ])
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['name'] = BaseFieldDefinition::create('string')
            ->setLabel(t('Name'))
            ->setDescription(t('The name of the Document entity entity.'))
            ->setSettings([
                'max_length' => 50,
                'text_processing' => 0,
            ])
            ->setDefaultValue('')
            ->setDisplayOptions('view', [
                'label' => 'above',
                'type' => 'string',
                'weight' => -4,
            ])
            ->setDisplayOptions('form', [
                'type' => 'string_textfield',
                'weight' => -4,
            ])
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['status'] = BaseFieldDefinition::create('boolean')
            ->setLabel(t('Publishing status'))
            ->setDescription(t('A boolean indicating whether the Document entity is published.'))
            ->setDefaultValue(TRUE)
            ->setDisplayOptions(
                'form',
                [
                    'type'   => 'checkbox',
                    'weight' => 10,
                ]
            );

        $fields['created'] = BaseFieldDefinition::create('created')
            ->setLabel(t('Created'))
            ->setDescription(t('The time that the entity was created.'));

        $fields['changed'] = BaseFieldDefinition::create('changed')
            ->setLabel(t('Changed'))
            ->setDescription(t('The time that the entity was last edited.'));

        $fields['publish_date'] = BaseFieldDefinition::create('datetime')
            ->setLabel(t('Publish Date'))
            ->setRequired(TRUE)
            ->setDisplayOptions(
                'form',
                [
                    'type'   => 'date',
                    'weight' => 20,
                ]
            );


        $fields['pdf_file'] = BaseFieldDefinition::create('file')
            ->setLabel(t('pdf File'))
            ->setSettings([
                'file_extensions' => 'pdf'
            ])
            ->setDisplayOptions(
                'form',
                [
                    'type'   => 'file',
                    'weight' => 30,
                ]
            );

        return $fields;
    }

    public function getPublishDate()
    {
        return $this->get('publish_date')->value;
    }

    public function setPublishDate($publishDate)
    {
        $this->set('publish_date', $publishDate);
        return $this;
    }

    public function getPdfFile()
    {
        return $this->get('pdf_file')->entity;
    }

    public function getPdfFileId()
    {
        return $this->get('pdf_file')->target_id;
    }

    public function setPdfFile($pdfFile)
    {
        $this->set('pdf_file', $pdfFile);
        return $this;
    }
}
