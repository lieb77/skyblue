<?php

declare(strict_types=1);

namespace Drupal\skyblue\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\skyblue\SkyBlue;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a DrupalSky form.
 */
final class SearchForm extends FormBase {


	/**
   * The controller constructor.
   */
  public function __construct(private SkyBlue $service) 
  {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('skyblue.service'),
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'skyblue_search';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['top']['keyword'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Keyword'),
      '#required' => TRUE,
    ];

    $form['top']['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Search'),
      ],
    ];
    
    // Show results of last query
    if ($posts = $form_state->get('posts')) {
			$build = [
				'#theme' => 'feed',
				'#feed'  => $posts,
			];
			$output = \Drupal::service('renderer')->render($build);
			$form['posts'] = [
				'#type'   =>  'item',
				'#markup' => $output,
			];
		}

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
   
		if (mb_strlen($form_state->getValue('keyword')) < 2) {
			$form_state->setErrorByName('keyword',
			$this->t('Keyword should be at least 2 characters.'),
			);
		}
	}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
  
  	if (!isset($this->service)){
  		$this->service = \Drupal::service('skyblue.service');
  	}
  
    $keyword = $form_state->getValue('keyword');
    $posts = $this->service->searchPosts($keyword);
    //dpm($posts);
		$form_state->set('posts', $posts);  
		$form_state->setRebuild(TRUE);
  }

}
