<?php
/**
 * Colissimo Rule Module
 *
 * @author    Magentix
 * @copyright Copyright © 2019 Magentix. All rights reserved.
 * @license   https://www.magentix.fr/en/licence.html Magentix Software Licence
 * @link      https://colissimo.magentix.fr/
 */
namespace Colissimo\Rule\Controller\Adminhtml\Colissimo;

use Colissimo\Rule\Model\RuleFactory;
use Colissimo\Rule\Model\RegistryConstants;
use Colissimo\Rule\Api\RuleRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Stdlib\DateTime\Filter\Date;

/**
 * Class Rule
 */
abstract class Rule extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Colissimo_Rule::rule';

    /**
     * Core registry
     *
     * @var Registry $coreRegistry
     */
    protected $coreRegistry = null;

    /**
     * @var FileFactory $fileFactory
     */
    protected $fileFactory;

    /**
     * @var Date $dateFilter
     */
    protected $dateFilter;

    /**
     * @var RuleRepositoryInterface $ruleRepository
     */
    protected $ruleRepository;

    /**
     * @var RuleFactory $ruleFactory
     */
    protected $ruleFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param FileFactory $fileFactory
     * @param Date $dateFilter
     * @param RuleFactory $ruleFactory
     * @param RuleRepositoryInterface $ruleRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        FileFactory $fileFactory,
        Date $dateFilter,
        RuleFactory $ruleFactory,
        RuleRepositoryInterface $ruleRepository
    ) {
        $this->coreRegistry   = $coreRegistry;
        $this->fileFactory    = $fileFactory;
        $this->dateFilter     = $dateFilter;
        $this->ruleFactory    = $ruleFactory;
        $this->ruleRepository = $ruleRepository;

        parent::__construct($context);
    }

    /**
     * Initiate action
     *
     * @return $this
     */
    protected function initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Colissimo_Rule::colissimo_rule')->_addBreadcrumb(__('Colissimo'), __('Offers'));

        return $this;
    }
}
