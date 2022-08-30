<?php
/**
 * Colissimo Rule Module
 *
 * @author    Magentix
 * @copyright Copyright © 2019 Magentix. All rights reserved.
 * @license   https://www.magentix.fr/en/licence.html Magentix Software Licence
 * @link      https://colissimo.magentix.fr/
 */
namespace Colissimo\Rule\Observer;

use Colissimo\Rule\Model\ResourceModel\Rule\CollectionFactory as RuleCollectionFactory;
use Colissimo\Rule\Model\Utility as ValidatorUtility;
use Colissimo\Rule\Model\Source\Actions;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\Method;

/**
 * Class UpdateShippingAddressObserver
 */
class UpdateShippingObserver implements ObserverInterface
{
    /**
     * @var RuleCollectionFactory $ruleCollectionFactory
     */
    protected $ruleCollectionFactory;

    /**
     * @var ValidatorUtility $validatorUtility
     */
    protected $validatorUtility;

    /**
     * @param RuleCollectionFactory $ruleCollectionFactory
     * @param ValidatorUtility $validatorUtility
     */
    public function __construct(
        RuleCollectionFactory $ruleCollectionFactory,
        ValidatorUtility $validatorUtility
    ) {
        $this->ruleCollectionFactory = $ruleCollectionFactory;
        $this->validatorUtility = $validatorUtility;
    }

    /**
     * Avoid address update for pickup delivery
     *
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        /** @var $request RateRequest */
        $request = $observer->getEvent()->getRequest();

        /** @var $method Method */
        $method = $observer->getEvent()->getMethod();

        $shippingMethod = $method->getCarrier() . '_' . $method->getMethod();

        $items = $request->getAllItems();

        if (!isset($items[0])) {
            return $this;
        }

        /** @var \Magento\Quote\Model\Quote\Item $item */
        $item = $items[0];

        /** @var \Magento\Quote\Model\Quote\Address $address */
        $address = $item->getAddress();

        $rules = $this->ruleCollectionFactory->create()
            ->addWebsiteGroupMethodDateFilter(
                $request->getWebsiteId(),
                $address->getQuote()->getCustomerGroupId(),
                $shippingMethod,
                $address->getQuote()->getAppliedRuleIds()
            );

        if ($rules->getSize()) {
            /** @var \Colissimo\Rule\Model\Rule $rule */
            foreach ($rules as $rule) {
                if ($this->validatorUtility->canProcessRule($rule, $address)) {
                    if ($rule->getShippingAction() == Actions::ACTION_APPLY_CUSTOM_PRICE) {
                        $method->setPrice($rule->getShippingAmount());
                    }

                    if ($rule->getShippingAction() == ACTIONS::ACTION_HIDE_SHIPPING_METHOD) {
                        $method->setHideMethod(true);
                    }
                }
            }
        }

        return $this;
    }
}
