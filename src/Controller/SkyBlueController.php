<?php

declare(strict_types=1);

namespace Drupal\skyblue\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Logger\LoggerChannelInterface;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\skyblue\SkyBlue;

/**
 * Returns responses for Drupalsky routes.
 */
final class SkyBlueController extends ControllerBase {

  /**
   * The controller constructor.
   */
  public function __construct(
    private LoggerChannelInterface $loggerChannelDefault,
    private SkyBlue $service,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('logger.channel.default'),
      $container->get('skyblue.service'),
    );
  }

	/**
	 * Profile
	 *
	 */
	public function profile() {

		$profile = $this->service->getProfile();    		

		return [
			'#theme'    => 'profile',
			'#profile'  => $profile,
			];
 } 

	/**
   * feed
   * Return a render array
   */
  public function feed(){
	 $feed = $this->service->getTimeline();
 
		return [
			'#theme' => 'feed',
			'#feed'  => $feed,
		];
  }





	/**
   * followers
   * Return a render array
   */
  public function followers(){
  	$followers = $this->service->getFollowers();
  	
  	return [
      '#theme' => 'followers',
      '#followers'  => $followers,
    ];
  }

	/**
   * following
   * Return a render array
   *
   * Not yet exposed in the SDK
   */
  public function following(){
  	$follows = $this->service->getFollows();
  	
  	return [
      '#theme' => 'followers',
      '#followers'  => $follows,
    ];
  }


	/**
	 * Posts
	 *
	 * Return a render array
   */
  public function posts(){
   
    $feed = $this->service->getPosts();
 
    return [
      '#theme' => 'feed',
      '#feed'  => $feed,
    ];
  }


// End of class
}
