<?php

namespace Drupal\ashburn_module\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @Block(
 *    id = "custom_block",
 *    admin_label = @Translation("User Block"),
 *  )
 */


class UserBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $currentUser;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountInterface $current_user) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $current_user;
  }

  public function build() {
    $build = [];

    // Add content to the block.
    $build['content'] = [
      '#markup' => $this->t('Hello, @username!', ['@username' => $this->currentUser->getDisplayName()]),
    ];

    // Set cache metadata based on user context.
    $cache_metadata = new CacheableMetadata();
    $cache_metadata->setCacheContexts(['user']);
    $build['#cache'] = [
      'tags' => $cache_metadata->getCacheTags(),
      'contexts' => $cache_metadata->getCacheContexts(),
      'max-age' => $cache_metadata->getCacheMaxAge(),
    ];

    return $build;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    // TODO: Implement create() method.
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user')
    );
  }

}
