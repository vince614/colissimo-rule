<?php
/**
 * Colissimo Rule Module
 *
 * @author    Magentix
 * @copyright Copyright © 2019 Magentix. All rights reserved.
 * @license   https://www.magentix.fr/en/licence.html Magentix Software Licence
 * @link      https://colissimo.magentix.fr/
 */
namespace Colissimo\Rule\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface RuleSearchResultsInterface
 */
interface RuleSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get rules
     *
     * @return \Colissimo\Rule\Api\Data\RuleInterface[]
     */
    public function getItems();

    /**
     * Set rules
     *
     * @param \Colissimo\Rule\Api\Data\RuleInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null);
}
