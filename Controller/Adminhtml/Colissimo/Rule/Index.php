<?php
/**
 * Colissimo Rule Module
 *
 * @author    Magentix
 * @copyright Copyright © 2019 Magentix. All rights reserved.
 * @license   https://www.magentix.fr/en/licence.html Magentix Software Licence
 * @link      https://colissimo.magentix.fr/
 */
namespace Colissimo\Rule\Controller\Adminhtml\Colissimo\Rule;

use Colissimo\Rule\Controller\Adminhtml\Colissimo\Rule as AbstractRule;

/**
 * Class Index
 */
class Index extends AbstractRule
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Colissimo_Rule::rule';

    /**
     * Index action
     *
     * @return void
     */
    public function execute()
    {
        $this->initAction()->_addBreadcrumb(__('Colissimo'), __('Rules'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(join(' > ', [__('Colissimo'), __('Offers')]));
        $this->_view->renderLayout();
    }
}
