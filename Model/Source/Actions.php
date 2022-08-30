<?php
/**
 * Colissimo Rule Module
 *
 * @author    Magentix
 * @copyright Copyright © 2019 Magentix. All rights reserved.
 * @license   https://www.magentix.fr/en/licence.html Magentix Software Licence
 * @link      https://colissimo.magentix.fr/
 */
namespace Colissimo\Rule\Model\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Actions
 */
class Actions implements ArrayInterface
{
    const ACTION_APPLY_CUSTOM_PRICE = 'price';

    const ACTION_HIDE_SHIPPING_METHOD = 'hide';

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return [
            ['label' => __('Apply custom price'),   'value' => self::ACTION_APPLY_CUSTOM_PRICE],
            ['label' => __('Hide shipping method'), 'value' => self::ACTION_HIDE_SHIPPING_METHOD]
        ];
    }
}
