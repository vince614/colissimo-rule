<?php
/**
 * Colissimo Rule Module
 *
 * @author    Magentix
 * @copyright Copyright © 2019 Magentix. All rights reserved.
 * @license   https://www.magentix.fr/en/licence.html Magentix Software Licence
 * @link      https://colissimo.magentix.fr/
 */
namespace Colissimo\Rule\Model\Rule\Condition;

use Magento\Rule\Model\Condition\AbstractCondition;
use Magento\Directory\Model\Config\Source\Country;
use Magento\Directory\Model\Config\Source\Allregion;
use Magento\Shipping\Model\Config\Source\Allmethods as ShippingSourceAllmethods;
use Magento\Payment\Model\Config\Source\Allmethods as PaymentSourceAllmethods;
use Magento\Rule\Model\Condition\Context;
use Magento\Framework\Model\AbstractModel;
use Magento\Quote\Model\Quote\Address as QuoteAddress;
use Magento\Framework\Module\Manager;

/**
 * Class Address
 */
class Address extends AbstractCondition
{
    /**
     * @var Country $directoryCountry
     */
    protected $directoryCountry;

    /**
     * @var Allregion $directoryAllregion
     */
    protected $directoryAllregion;

    /**
     * @var ShippingSourceAllmethods $shippingAllmethods
     */
    protected $shippingAllmethods;

    /**
     * @var PaymentSourceAllmethods $paymentAllmethods
     */
    protected $paymentAllmethods;

    /**
     * @var Manager $moduleManager
     */
    protected $moduleManager;

    /**
     * @param Context $context
     * @param Country $directoryCountry
     * @param Allregion $directoryAllregion
     * @param ShippingSourceAllmethods $shippingAllmethods
     * @param PaymentSourceAllmethods $paymentAllmethods
     * @param Manager $moduleManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        Country $directoryCountry,
        Allregion $directoryAllregion,
        ShippingSourceAllmethods $shippingAllmethods,
        PaymentSourceAllmethods $paymentAllmethods,
        Manager $moduleManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->directoryCountry = $directoryCountry;
        $this->directoryAllregion = $directoryAllregion;
        $this->shippingAllmethods = $shippingAllmethods;
        $this->paymentAllmethods = $paymentAllmethods;
        $this->moduleManager = $moduleManager;
    }

    /**
     * Load attribute options
     *
     * @return $this
     */
    public function loadAttributeOptions()
    {
        $attributes = [
            'base_subtotal' => __('Subtotal excl. tax'),
            'base_subtotal_with_discount' => __('Subtotal excl. tax with discount'),
            'base_subtotal_total_incl_tax' => __('Subtotal incl. tax'),
            'base_subtotal_total_incl_tax_with_discount' => __('Subtotal incl. tax with discount'),
            'total_qty' => __('Total Items Quantity'),
            'weight' => __('Total Weight'),
            'postcode' => __('Shipping Postcode'),
            'region' => __('Shipping Region'),
            'region_id' => __('Shipping State/Province'),
            'country_id' => __('Shipping Country'),
        ];

        $this->setAttributeOption($attributes);

        return $this;
    }

    /**
     * Get attribute element
     *
     * @return $this
     */
    public function getAttributeElement()
    {
        $element = parent::getAttributeElement();
        $element->setShowAsText(true);
        return $element;
    }

    /**
     * Get input type
     *
     * @return string
     */
    public function getInputType()
    {
        switch ($this->getAttribute()) {
            case 'base_subtotal':
            case 'subtotal_incl_tax':
            case 'weight':
            case 'total_qty':
                return 'numeric';

            case 'shipping_method':
            case 'payment_method':
            case 'country_id':
            case 'region_id':
                return 'select';
        }
        return 'string';
    }

    /**
     * Get value element type
     *
     * @return string
     */
    public function getValueElementType()
    {
        switch ($this->getAttribute()) {
            case 'shipping_method':
            case 'payment_method':
            case 'country_id':
            case 'region_id':
                return 'select';
        }
        return 'text';
    }

    /**
     * Get value select options
     *
     * @return array|mixed
     */
    public function getValueSelectOptions()
    {
        if (!$this->hasData('value_select_options')) {
            switch ($this->getAttribute()) {
                case 'country_id':
                    $options = $this->directoryCountry->toOptionArray();
                    break;

                case 'region_id':
                    $options = $this->directoryAllregion->toOptionArray();
                    break;

                case 'shipping_method':
                    $options = $this->shippingAllmethods->toOptionArray();
                    break;

                case 'payment_method':
                    $options = $this->paymentAllmethods->toOptionArray();
                    break;

                default:
                    $options = [];
            }
            $this->setData('value_select_options', $options);
        }
        return $this->getData('value_select_options');
    }

    /**
     * Validate Address Rule Condition
     *
     * @param AbstractModel $model
     * @return bool
     */
    public function validate(AbstractModel $model)
    {
        $address = $model;

        if (!$address instanceof QuoteAddress) {
            if ($model->getQuote()->isVirtual()) {
                $address = $model->getQuote()->getBillingAddress();
            } else {
                $address = $model->getQuote()->getShippingAddress();
            }
        }

        if ('payment_method' == $this->getAttribute() && !$address->hasPaymentMethod()) {
            $address->setPaymentMethod($model->getQuote()->getPayment()->getMethod());
        }

        if ($this->getAttribute() == 'base_subtotal_total_incl_tax_with_discount') {
            $subtotalInclTax = $address->getQuote()->getGrandTotal() - ($address->getShippingAmount() + $address->getShippingTaxAmount());
            if ($this->moduleManager->isEnabled('Magento_CustomerBalance')) {
                $subtotalInclTax += $address->getData('customer_balance_amount');
            }

            $address->setData('base_subtotal_total_incl_tax_with_discount', $subtotalInclTax);
        }

        return parent::validate($address);
    }
}
