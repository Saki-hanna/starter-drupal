<?php

namespace Drupal\document\Controller;

use Drupal\Core\Controller\ControllerBase;

class DocumentController extends ControllerBase
{

    public function hello()
    {
        return [
            '#theme' => 'world',
            '#texte' => $this->t('Hello world !'),
        ];

    }

    public function listDocument()
    {
        return [
            '#theme' => 'listDocument'
        ];

    }
}