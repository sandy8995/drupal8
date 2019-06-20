<?php

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
     */
    public function settingsSummary() {
        $summary = [];
        $summary[] = $this->t('Displays the first record from Giphy API.');
        return $summary;
    }

    /**
     * {@inheritdoc}
     */
    public function viewElements(FieldItemListInterface $items, $langcode) {
        $element = [];
        foreach ($items as $delta => $item) {
            // Render each element as markup.
            $revisedString = str_replace(" ", "+", $item->value);
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
        return $element;
    }

}
