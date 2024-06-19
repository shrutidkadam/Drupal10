<?php
/**
 * @file
 * Contains \Drupal\custom_migration\Form\FieldCollectionData.
 */
namespace Drupal\custom_migration\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\block\Entity\Block;


class FieldResearchAreaPriorityGrid extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'field_collection_data';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['csv_upload'] = array(
      '#type' => 'managed_file',
      '#title' => $this->t('Upload CSV for Field collection'),
      '#upload_location' => 'public://og',
      '#upload_validators' => [
        'file_validate_extensions' => ['csv'],
      ],
    );

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Upload'),
      '#button_type' => 'primary',
    );
    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    /* Fetch the array of the file stored temporarily in database */
    $csv_file = $form_state->getValue('csv_upload');

    /* Load the object of the file by it's fid */
    $file = File::load( $csv_file[0] );

    /* Set the status flag permanent of the file object */
    $file->setPermanent();

    /* Save the file in database */
    $file->save();

    // You can use any sort of function to process your data. The goal is to get each 'row' of data into an array
    // If you need to work on how data is extracted, process it here.
    $data = $this->csvtoarray($file->getFileUri(), ',');
    $connection = \Drupal::database();

    foreach($data as $key => $row) {
      //for video card
      // Create paragraphs for each row
      $paragraph = Paragraph::create([
        'type' => 'research_three_cards',
        'field_research_card_image' => array(
          'target_id' =>  $row['File ID'],
        ),
        'field_research_card_heading' => array(
          "value"  =>  $row['Research card heading'],
        ),
        'field_research_card_desc' => [
          "value"  =>  $row['Research card desc'],
          "format" => "full_html"
        ]
      ]);
      $paragraph->save();
      $para_id = $paragraph->id();


      // For multiple fields delta will increment
      $delta = 0;
      $sql = "SELECT delta FROM {block_content__field_research_three_cards} WHERE entity_id = :entity_id";
      $block_exist = $connection->query($sql, [':entity_id' => $row['Fieldable pane ID']]);
      if ($block_exist) {
        while ($resexist = $block_exist->fetchAssoc()) {

          $delta = $resexist['delta']+1;

        }
      }
      // insert entity ref field
      $result2 = $connection->insert('block_content__field_research_three_cards')
        ->fields([
          'bundle' =>  $row['Bundle'],
          'deleted' => 0,
          'entity_id' =>  $row['Fieldable pane ID'],
          'revision_id' =>  $row['Fieldable pane ID'],
          'field_research_three_cards_target_id' => $para_id,
          'langcode' => 'und',
          'delta' => $delta,
          'field_research_three_cards_target_revision_id' =>  $para_id,
        ])
        ->execute();

      if( $result2){
        \Drupal::messenger()->addMessage('Paragraphs are created');
      }

    }

  }

  /**
   * Get csv to array
   */

  public function csvtoarray($filename, $delimiter){

    if(!file_exists($filename) || !is_readable($filename)) return FALSE;
    $header = NULL;
    $data = array();

    if (($handle = fopen($filename, 'r')) !== FALSE ) {
      while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
      {
        if(!$header){
          $header = $row;
        }else{
          $data[] = array_combine($header, $row);
        }
      }
      fclose($handle);
    }

    return $data;
  }

}
