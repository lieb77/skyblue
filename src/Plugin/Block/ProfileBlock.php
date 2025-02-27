<?php

namespace Drupal\skyblue\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\drupalsky\DrupalSky;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'Hello' Block.
 */

#[Block(
  id: "skyblue_profile_block",
  admin_label: new TranslatableMarkup("Bluesky Profile"),
  category: new TranslatableMarkup("SkyBlue block")
)]
class ProfileBlock extends BlockBase {

/*
	public function __construct(
	 		array $configuration,
      $plugin_id,
      $plugin_definition,
      protected DrupalSky $service) {
	 parent::__construct($configuration, $plugin_id, $plugin_definition);
	
	
	}
*/

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, 
  				array $configuration, 
  				$plugin_id, 
  				$plugin_definition): static {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
  	$instance->skyService = $container->get('skyblue.service');
    return $instance;
  }



  /**
   * {@inheritdoc}
   */
  public function build() {
  
  	if (!isset($this->skyService)){
  		$this->skyService = \Drupal::service('skyblue.service');
  	}
  
  
  	$profile = $this->skyService->getProfile();    		
    
     $render_array = [
      '#theme'    => 'profile',
      '#profile'  => $profile,
    ];
    
    return $render_array;
  
  }

}
