<?php

namespace Drupal\demotest\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DemoConfig extends ConfigFormBase {

  protected $currentUser;

  public function __construct(AccountInterface $current_user) {

    $this->currentUser = $current_user;
  }

  public static function create(ContainerInterface $container) {
    return new static($container->get('current_user'));
  }

  protected function getEditableConfigNames() {
    // TODO: Implement getEditableConfigNames() method.
    return ['demotest.configuration'];
  }

  public function getFormId() {
    // TODO: Implement getFormId() method.
    return 'demotest_configuration_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] =[
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#required' => TRUE,
      '#default_value' => $this->config('demotest.configuration')->get('name'),
    ];
    $form['userid'] =[
      '#type' => 'number',
      '#title' => $this->t('UserId'),
      '#disabled' => TRUE,
      '#default_value' => $this->currentUser->id(),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('demotest.configuration');
    $config->set('name', $form_state->getValue('name'));
    $config->save();
    \Drupal::logger('demotest')->notice('Demo configuration updated');
    \Drupal::messenger()->addMessage($this->t('Name in Configuration saved.'));
  }

}
