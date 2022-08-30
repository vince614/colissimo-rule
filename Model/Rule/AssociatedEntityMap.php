<?php
/**
 * Colissimo Rule Module
 *
 * @author    Magentix
 * @copyright Copyright © 2019 Magentix. All rights reserved.
 * @license   https://www.magentix.fr/en/licence.html Magentix Software Licence
 * @link      https://colissimo.magentix.fr/
 */
namespace Colissimo\Rule\Model\Rule;

use Magento\Framework\DataObject;

/**
 * Class AssociatedEntityMap
 */
class AssociatedEntityMap extends DataObject
{

    /**
     * AssociatedEntityMap constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $data = [
            'website' => [
                'associations_table' => 'colissimo_rule_website',
                'rule_id_field'      => 'rule_id',
                'entity_id_field'    => 'website_id',
            ],
            'customer_group' => [
                'associations_table' => 'colissimo_rule_customer_group',
                'rule_id_field'      => 'rule_id',
                'entity_id_field'    => 'customer_group_id',
            ]
        ];
        parent::__construct($data);
    }
}
