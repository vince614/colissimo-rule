<?php
/**
 * Colissimo Rule Module
 *
 * @author    Magentix
 * @copyright Copyright © 2019 Magentix. All rights reserved.
 * @license   https://www.magentix.fr/en/licence.html Magentix Software Licence
 * @link      https://colissimo.magentix.fr/
 */
namespace Colissimo\Rule\Block\Adminhtml\Colissimo\Rule\Edit;

use Colissimo\Rule\Model\RegistryConstants;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var UrlInterface $urlBuilder
     */
    protected $urlBuilder;

    /**
     * Registry
     *
     * @var Registry $registry
     */
    protected $registry;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        Registry $registry
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->registry = $registry;
    }

    /**
     * Return the current Rule Id.
     *
     * @return int|null
     */
    public function getRuleId()
    {
        $rule = $this->registry->registry(RegistryConstants::CURRENT_COLISSIMO_RULE);

        return $rule ? $rule->getId() : null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }

    /**
     * Check where button can be rendered
     *
     * @param string $name
     * @return string
     */
    public function canRender($name)
    {
        return $name;
    }
}
