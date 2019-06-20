<?php

/*Defining the namespaces */

namespace Drupal\custom\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'Custom_field' formatter.
 *
 * @FieldFormatter(
 *   id = "Custom_field",
 *   label = @Translation("Giphy text"),
 *   field_types = {
 *     "string"
 *   },
 *   quickedit = {
 *     "editor" = "plain_text"
 *   }
 * )
 */
class CustomFieldFormatter extends FormatterBase {

    /**
     * {@inheritdoc}
     * Implement The Settings Form which appears infront of formatter in Manage Display screen
     */
    public function settingsSummary() {
        $summary = [];
        $summary[] = $this->t('Displays the first record from Giphy API.');
        return $summary;
    }

    /**
     * {@inheritdoc}
     * Displaying And Rendering Data (In this method we can retrieve data and render data.)
     * @items contains the string value of plain text 
     */
    public function viewElements(FieldItemListInterface $items, $langcode) {
        $element = [];
        foreach ($items as $delta => $item) {
            // Render each element as markup.
            $revisedString = str_replace(" ", "+", $item->value);
            //curl for getting the very first record from Giphy
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, "http://api.giphy.com/v1/gifs/search?q=$revisedString&api_key=MH7eHOoVlQTNYe88qtF887lfEujQXNxW");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            $result = json_decode($result, true);
            $url = $result['data'][0]['images']['fixed_width']['url'];
            $element[$delta] = ['#markup' => $url];
        }
        //output
        return $element;
    }

}
