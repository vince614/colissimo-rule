<?php
/**
 * Colissimo Rule Module
 *
 * @author    Magentix
 * @copyright Copyright © 2019 Magentix. All rights reserved.
 * @license   https://www.magentix.fr/en/licence.html Magentix Software Licence
 * @link      https://colissimo.magentix.fr/
 */
namespace Colissimo\Rule\Block\Widget\Form\Element;

use Magento\Backend\Block\Widget\Form\Element\Dependence as FormDependence;
use Magento\Backend\Block\Context;
use Magento\Framework\Json\EncoderInterface;
use Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory;

/**
 * Class Dependence
 */
class Dependence extends FormDependence
{
    /**
     * @param Context $context
     * @param EncoderInterface $jsonEncoder
     * @param FieldFactory $fieldFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        EncoderInterface $jsonEncoder,
        FieldFactory $fieldFactory,
        array $data = []
    ) {
        parent::__construct($context, $jsonEncoder, $fieldFactory, $data);
    }

    /**
     * {@inheritdoc}
     * @phpcs:disable
     */
    protected function _toHtml()
    {
        if (!$this->_depends) {
            return '';
        }

        return '<script>
            require(["uiRegistry", "mage/adminhtml/form"], function(registry) {
                var controller = new FormElementDependenceController(' .
                $this->_getDependsJson() .
                ($this->_configOptions ? ', ' .
                $this->_jsonEncoder->encode(
                    $this->_configOptions
                ) : '') . ');
                registry.set("formDependenceController", controller);
            });
            </script>';
    }
}
