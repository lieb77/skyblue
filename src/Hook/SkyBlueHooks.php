<?php

declare(strict_types=1);

namespace Drupal\skyblue\Hook;

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Hook\Attribute\Hook;

/**
 *
 */
class SkyBlueHooks {

  /**
   * Implements hook_help().
   */
  #[Hook('help')]
  public function help($route_name, RouteMatchInterface $route_match) {
    switch ($route_name) {
      case 'help.page.drupalsky':
        $output  = "<h2>DrupalSky Help</h2>";
        return $output;
    }
  }
      
  /**
   * Implements hook_theme()
   */
  #[Hook('theme')]
  public function theme() {    
    $templates['profile'] =  [
      'render element' => 'children',
      'variables' => [   
        'profile' => [
          'displayName' => 'displayName',
          'handle'      => 'handle',
          'avatar'      => 'avatar',
          'description' => 'description',
          'banner'      => 'banner',
          'followers'   => 'followersCount',
          'follows'     => 'followsCount',
          'posts'       => 'postsCount',
        ],
      ],
    ];
    
    $templates['followers'] =  [
      'render element' => 'children',
      'variables' => [   
        'followers' => [
        	'follower' => [
						'displayName' => 'displayName',
						'handle'      => 'handle',
						'avatar'      => 'avatar',
						'description' => 'description',
					],
        ],
      ],
    ];
    
    
    $templates['feed'] =  [
      'render element' => 'children',
      'variables' => [   
        'feed' => [
        	'post' => [
	        	'handle' => 'handle',
  	        'name'   => 'avatar',
    	      'text' 	 => 'text',
    	      'date'	 => 'date',
    	      'ext'	   => [
    	      	'uri'     		=> 'uri',
    	      	'title'   		=>  'title',
    	      	'description' => 'description',
    	      	'thumb'				=> 'thumbnail',    	      
    	      ],
        	],
        ],
      ],
    ];   
     
    $templates['bskyform'] = [
   	 'render element' => 'form',
      'variables' => [  
      	'form' => 'form',
      ], 
    ];
    
    return $templates;
  }

  // End of class.
}
