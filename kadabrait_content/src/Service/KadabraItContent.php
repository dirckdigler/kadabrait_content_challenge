<?php

namespace Drupal\kadabrait_content\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\Entity\User;

/**
 * Class KadabraItContent.
 */
class KadabraItContent {

  /**
   * Get the current user.
   */
  protected $currentUser;

  /**
   * Constructs a \Drupal\kadabrait_content\Service\KadabraItContent.
   */
  public function __construct() {
    $this->currentUser = \Drupal::currentUser();
  }

  /**
   * Retrieve ten latest content of the User logged in.
   *  
   * @param array $data
   * @return array
   * 
   */
  public function getEntityStorage() {
    $reponse = [];
    $user = User::load($this->currentUser->id());
    if ($this->currentUser->isAnonymous()) {
      return FALSE;
    }

    $entity = \Drupal::entityTypeManager()->getStorage('node');
    $query = $entity->getQuery();
    $ids = $query->condition('status', 1)
      ->condition('uid', $user->id())
      ->sort('created', 'DESC')
      ->pager(10)
      ->execute();
    
    $node_entities =$entity->loadMultiple($ids);
    if (!empty($node_entities)) {
      foreach ($node_entities as $entity) {
        $reponse[$entity->id()] = $entity->title->value;
      }
    }

    return $reponse;

  }

}
