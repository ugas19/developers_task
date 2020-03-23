<?php

namespace Drupal\cdp_statistics\Plugin\Block;

use Drupal\cdp_tasks\Entity\Tasks;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;

/**
 * Provides a 'statistics' Block.
 *
 * @Block(
 *   id = "statistics_block",
 *   admin_label = @Translation("statistics block"),
 *   category = @Translation("statistics"),
 * )
 */
class StatisticsBlock extends BlockBase implements BlockPluginInterface {

  /**
   * @inheritDoc
   */
  public function build() {
$stats = [];
$nids = \Drupal::entityQuery('tasks')
  ->condition('developer',\Drupal::currentUser()->id())->execute();

foreach($nids as $nid){

  $data = Tasks::load($nid);

  $stats[] = [$data->get('planned_time')->value,$data->get('actual_time')->value];

}
//    $build['#markup'] = '<h1>Statistics</h1>';
    $build['#attached']['drupalSettings']['myvar'] = $stats;
    $build['#attached']['library'][] = 'cdp_statistics/chart';
    return $build;
  }

}