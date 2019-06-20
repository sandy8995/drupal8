<?php

/**
 * @file
 * Contains \Drupal\formatter\Plugin\field\formatter\Formatter.
 */

namespace Drupal\formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'youtube_link' formatter.
 *
 * @FieldFormatter(
 *   id = "youtube_link",
 *   label = @Translation("YouTube Formatter"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class Formatter extends FormatterBase {

    /**
     * {@inheritdoc}
     */
    public function viewElements(FieldItemListInterface $items) {
        $elements = array();

        foreach ($items as $delta => $item) {
            $url = $item->url;
            $elements[$delta] = array(
                '#theme' => 'formatter',
                '#url' => $url,
            );
        }

        return $elements;
    }

}
