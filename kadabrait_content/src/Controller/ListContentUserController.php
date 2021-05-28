<?php

/**
 * @file
 * Contains \Drupal\kadabrait_content\Controller\ListContentUserController
 *
 */
namespace Drupal\kadabrait_content\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\kadabrait_content\Service\KadabraItContent;

/**
 * Controller routines.
 */
class ListContentUserController extends ControllerBase {

  /**
   * @var \Drupal\kadabrait_content\Service\KadabraItContent
   */
  protected $KadabraItContent;

  /**
   * ListContentUserController Constructor.
   *
   * @param \Drupal\kadabrait_content\Service\KadabraItContent $kadabra_it_content
   */
  public function __construct(KadabraItContent $kadabra_it_content) {
    $this->KadabraItContent = $kadabra_it_content;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('kadabrait_content.list_content'),
    );
  }

  /**
   * Constructs a final page to the Enroll Process.
   *
   * The router _controller callback, maps the path
   *
   * _controller callbacks return a renderable array for the content area of the
   * page. The theme system will later render and surround the content.
   *
   * Depending the response service, the output will have the specific theme.
   */
  public function view() {
    $content = $this->KadabraItContent->getEntityStorage();
    if ($content) {
      return $output = [
        '#content' => $content,
        '#theme' => 'kadabrait_content',
      ];
    }

    return [
      '#type' => 'markup',
      '#markup' => $this->t('It is not possible to show content for anonymous users, please register'),
    ];

    return $output;

  }

}
