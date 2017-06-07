<?php
namespace Drupal\document\Controller;

use Drupal\Core\Controller\ControllerBase;

class DocumentController extends ControllerBase
{

    public function hello()
    {
        return array(
            '#theme' => 'world',
            '#texte' => $this->t('Hello world !'),
        );

    }
}