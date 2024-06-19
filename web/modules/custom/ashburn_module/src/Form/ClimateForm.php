<?php

namespace Drupal\ashburn_module\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\ashburn_module\services\ClimateService;

class ClimateForm extends FormBase {

  protected $messenger;
  protected array $climate;

  public static function create(ContainerInterface $container) {
   return new static($container->get('messenger'), $container->get('ashburn_service_climate'));
  }
  public function __construct(MessengerInterface $messenger, ClimateService $climate) {
    $this->messenger = $messenger;
    $this->climate = $climate->getClimate('test');
  }

  public function getFormId() {
    // TODO: Implement getFormId() method.
    return 'climate_form';
  }



  public function buildForm(array $form, FormStateInterface $form_state) {
    // TODO: Implement buildForm() method.
    $form['personal']= [
      '#type' => 'textfield',
      '#title' => $this->t('Personal information'),
      '#required' => TRUE,
      '#maxlength' => 20,
    ];
    $form['city']= [
      '#type' => 'select',
      '#title' => $this->t('City'),
      '#options' => ['0'=>'ashburn', '1'=> 'scottsdale', '2'=>'dullas'],
      '#required' => TRUE,
    ];
    $form['submit']= [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement submitForm() method.
    $personal = $form_state->getValue('personal');
    $city = $form_state->getValue('city');
    $city_val = $form['city']['#options'][$city];
    var_dump($city_val);exit;
    $this->messenger->addMessage($this->t('Personal information submitted.'));

  }

}
