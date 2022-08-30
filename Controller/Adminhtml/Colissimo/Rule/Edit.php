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
use Colissimo\Rule\Model\RuleFactory;
use Colissimo\Rule\Api\RuleRepositoryInterface;
use Colissimo\Rule\Model\RegistryConstants;
use Colissimo\Rule\Controller\Adminhtml\Colissimo\Rule as AbstractRule;
use Colissimo\Rule\Model\ResourceModel\Rule as RuleResourceModel;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Stdlib\DateTime\Filter\Date;

/**
 * Class Edit
 */
class Edit extends AbstractRule
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Colissimo_Rule::rule';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param FileFactory $fileFactory
     * @param Date $dateFilter
     * @param PageFactory $resultPageFactory
     * @param RuleFactory $ruleFactory
     * @param RuleRepositoryInterface $ruleRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        FileFactory $fileFactory,
        Date $dateFilter,
        PageFactory $resultPageFactory,
        RuleFactory $ruleFactory,
        RuleRepositoryInterface $ruleRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;

        parent::__construct(
            $context,
            $coreRegistry,
            $fileFactory,
            $dateFilter,
            $ruleFactory,
            $ruleRepository
        );
    }

    /**
     * Colissimo rule edit action
     *
     * @return void
     * @throws \Exception
     */
    public function execute()
    {
        $ruleId = $this->getRequest()->getParam('id');

        /** @var Rule $rule */
        $rule = $this->ruleFactory->create();

        if ($ruleId) {
            $rule = $this->ruleRepository->getById($ruleId);

            if (!$rule->getId()) {
                $this->messageManager->addErrorMessage(__('This rule no longer exists'));
                $this->_redirect('colissimo_rule/*');

                return;
            }

            $rule->getConditions()->setFormName('colissimo_rule_form');
            $rule->getConditions()->setJsFormObject(
                $rule->getConditionsFieldSetId($rule->getConditions()->getFormName())
            );
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getPageData(true);
        if (!empty($data)) {
            $rule->addData($data);
        }

        $this->coreRegistry->register(RegistryConstants::CURRENT_COLISSIMO_RULE, $rule);

        $this->initAction();

        $this->_addBreadcrumb(
            $ruleId ? __('Edit Rule') : __('New Rule'),
            $ruleId ? __('Edit Rule') : __('New Rule')
        );

        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $rule->getRuleId() ? $rule->getName() : __('New Colissimo Rule')
        );

        $this->_view->renderLayout();
    }
}
