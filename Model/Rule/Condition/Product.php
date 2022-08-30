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

use Magento\Rule\Model\Condition\Product\AbstractProduct;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Product
 */
class Product extends AbstractProduct
{
    /**
     * Add special attributes
     *
     * @param array $attributes
     * @return void
     * @phpcs:disable
     */
    protected function _addSpecialAttributes(array &$attributes)
    {
        parent::_addSpecialAttributes($attributes);

        $attributes['quote_item_qty'] = __('Quantity in cart');
        $attributes['quote_item_price'] = __('Price in cart');
        $attributes['quote_item_row_total'] = __('Row total in cart');
    }

    /**
     * Validate Product Rule Condition
     *
     * @param AbstractModel $model
     * @return bool
     * @throws
     */
    public function validate(AbstractModel $model)
    {
        $product = $model->getProduct();
        if (!$product instanceof \Magento\Catalog\Model\Product) {
            $product = $this->productRepository->getById($model->getProductId());
        }

        $product->setQuoteItemQty(
            $model->getQty()
        )->setQuoteItemPrice(
            $model->getPrice()
        )->setQuoteItemRowTotal(
            $model->getBaseRowTotal()
        );

        return parent::validate($product);
    }
}
