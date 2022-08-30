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
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Delete
 */
class Delete extends AbstractRule
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Colissimo_Rule::rule';

    /**
     * Delete Rule action
     *
     * @return void
     */
    public function execute()
    {
        $ruleId = $this->getRequest()->getParam('id');

        if ($ruleId) {
            try {
                $this->ruleRepository->deleteById($ruleId);

                $this->messageManager->addSuccessMessage(__('You deleted the rule.'));
                $this->_redirect('colissimo_rule/*/');

                return;
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('We can\'t delete the rule right now.')
                );
                $this->_redirect('colissimo_rule/*/edit', ['id' => $ruleId]);

                return;
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a rule to delete.'));

        $this->_redirect('colissimo_rule/*/');
    }
}
