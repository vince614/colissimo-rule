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

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface RuleInterface
 */
interface RuleInterface extends ExtensibleDataInterface
{
    const KEY_RULE_ID = 'rule_id';
    const KEY_NAME = 'name';
    const KEY_DESCRIPTION = 'description';
    const KEY_FROM_DATE = 'from_date';
    const KEY_TO_DATE = 'to_date';
    const KEY_IS_ACTIVE = 'is_active';
    const KEY_SORT_ORDER = 'sort_order';
    const KEY_SHIPPING_METHOD = 'shipping_method';
    const KEY_SHIPPING_ACTION = 'shipping_action';
    const KEY_SHIPPING_AMOUNT = 'shipping_amount';
    const KEY_WEBSITES = 'website_ids';
    const KEY_CUSTOMER_GROUPS = 'customer_group_ids';
    const KEY_CART_RULE_ID = 'cart_rule_id';

    /**
     * Return rule id
     *
     * @return int|null
     */
    public function getRuleId();

    /**
     * Set rule id
     *
     * @param int $ruleId
     * @return $this
     */
    public function setRuleId($ruleId);

    /**
     * Get rule name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set rule name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * Get a list of websites the rule applies to
     *
     * @return int[]
     */
    public function getWebsiteIds();

    /**
     * Set the websites the rule applies to
     *
     * @param int[] $websiteIds
     * @return $this
     */
    public function setWebsiteIds(array $websiteIds);

    /**
     * Get ids of customer groups that the rule applies to
     *
     * @return int[]
     */
    public function getCustomerGroupIds();

    /**
     * Set the customer groups that the rule applies to
     *
     * @param int[] $customerGroupIds
     * @return $this
     */
    public function setCustomerGroupIds(array $customerGroupIds);

    /**
     * Get the start date when the coupon is active
     *
     * @return string|null
     */
    public function getFromDate();

    /**
     * Set the star date when the coupon is active
     *
     * @param string $fromDate
     * @return $this
     */
    public function setFromDate($fromDate);

    /**
     * Get the end date when the coupon is active
     *
     * @return string|null
     */
    public function getToDate();

    /**
     * Set the end date when the coupon is active
     *
     * @param string $fromDate
     * @return $this
     */
    public function setToDate($fromDate);

    /**
     * Whether the coupon is active
     *
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsActive();

    /**
     * Set whether the coupon is active
     *
     * @param bool $isActive
     * @return bool
     */
    public function setIsActive($isActive);

    /**
     * Get Shipping method
     *
     * @return string
     */
    public function getShippingMethod();

    /**
     * Set Shipping Method
     *
     * @param string $shippingMethod
     * @return $this
     */
    public function setShippingMethod($shippingMethod);

    /**
     * Get Shipping action
     *
     * @return string
     */
    public function getShippingAction();

    /**
     * Set Shipping Action
     *
     * @param string $shippingAction
     * @return $this
     */
    public function setShippingAction($shippingAction);

    /**
     * Get Shipping Amount
     *
     * @return float
     */
    public function getShippingAmount();

    /**
     * Set Shipping Amount
     *
     * @param float $shippingAmount
     * @return $this
     */
    public function setShippingAmount($shippingAmount);

    /**
     * Get sort order
     *
     * @return int
     */
    public function getSortOrder();

    /**
     * @param int $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder);

    /**
     * Set Cart Rule Id
     *
     * @param int setCartRuleId
     * @return $this
     */
    public function setCartRuleId($cartRuleId);

    /**
     * Get Cart Rule Id
     *
     * @return int
     */
    public function getCartRuleId();
}
