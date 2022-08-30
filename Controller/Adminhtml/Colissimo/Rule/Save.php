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

use Colissimo\Rule\Model\Rule;
use Colissimo\Rule\Controller\Adminhtml\Colissimo\Rule as AbstractRule;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\DataObject;
use Exception;

/**
 * Class Save
 */
class Save extends AbstractRule
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Colissimo_Rule::rule';

    /**
     * Colissimo Rule save action
     *
     * @return void
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            try {
                $this->_eventManager->dispatch(
                    'adminhtml_controller_colissimo_rule_prepare_save',
                    ['request' => $this->getRequest()]
                );
                $data = $this->getRequest()->getPostValue();

                $dates = ['from_date', 'to_date'];
                foreach ($dates as $field) {
                    if (!isset($data[$field])) {
                        continue;
                    }
                    if (!$data[$field]) {
                        continue;
                    }
                    $data[$field] = $this->dateFilter->filter($data[$field]);
                }

                $ruleId = $this->getRequest()->getParam('rule_id');

                /** @var Rule $model */
                $model = $this->ruleFactory->create();

                if ($ruleId) {
                    $model = $this->ruleRepository->getById($ruleId);

                    if ($ruleId !== $model->getId()) {
                        throw new LocalizedException(__('The wrong rule is specified.'));
                    }
                }

                $session = $this->_objectManager->get('Magento\Backend\Model\Session');

                $validateResult = $model->validateData(new DataObject($data));
                if ($validateResult !== true) {
                    foreach ($validateResult as $errorMessage) {
                        $this->messageManager->addErrorMessage($errorMessage);
                    }
                    $session->setPageData($data);
                    $this->_redirect('colissimo_rule/*/edit', ['id' => $model->getId()]);

                    return;
                }

                if (isset($data['rule']['conditions'])) {
                    $data['conditions'] = $data['rule']['conditions'];
                }

                unset($data['rule']);

                $model->loadPost($data);
                $session->setPageData($model->getData());

                $this->ruleRepository->save($model);

                $this->messageManager->addSuccessMessage(__('You saved the rule.'));
                $session->setPageData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('colissimo_rule/*/edit', ['id' => $model->getId()]);
                    return;
                }
                $this->_redirect('colissimo_rule/*/');
                return;
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $ruleId = (int)$this->getRequest()->getParam('rule_id');
                if (!empty($ruleId)) {
                    $this->_redirect('colissimo_rule/*/edit', ['id' => $ruleId]);
                } else {
                    $this->_redirect('colissimo_rule/*/new');
                }
                return;
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('Something went wrong while saving the rule data. Please review the error log.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_redirect('colissimo_rule/*/edit', ['id' => $this->getRequest()->getParam('rule_id')]);
                return;
            }
        }
        $this->_redirect('colissimo_rule/*/');
    }
}
