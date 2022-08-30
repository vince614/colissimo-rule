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

use Magento\Shipping\Model\Config\Source\Allmethods;
use Colissimo\Rule\Model\Rule;

/**
 * Class Method
 */
class Methods extends Allmethods
{
    /**
     * Return array of options as value-label pairs
     *
     * @param bool $isActiveOnlyFlag
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray($isActiveOnlyFlag = false)
    {
        $options = parent::toOptionArray($isActiveOnlyFlag);

        $output = [];

        if (isset($options[Rule::RULE_SHIPPING_CODE]['value'])) {
            $output = $options[Rule::RULE_SHIPPING_CODE]['value'];
        }

        return $output;
    }
}
