<?php
/**
 * Colissimo Rule Module
 *
 * @author    Magentix
 * @copyright Copyright © 2019 Magentix. All rights reserved.
 * @license   https://www.magentix.fr/en/licence.html Magentix Software Licence
 * @link      https://colissimo.magentix.fr/
 */
namespace Colissimo\Rule\Block\Adminhtml\Colissimo;

use Magento\Backend\Block\Widget\Grid\Container;

/**
 * Class Rule
 */
class Rule extends Container
{
    /**
     * Constructor
     *
     * @return void
     * @phpcs:disable
     */
    protected function _construct()
    {
        $this->_controller = 'colissimo_rule';
        $this->_headerText = __('Colissimo Rules');
        $this->_addButtonLabel = __('Add New Rule');
        parent::_construct();
    }
}
