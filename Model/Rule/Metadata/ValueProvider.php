<?php
/**
 * Colissimo Rule Module
 *
 * @author    Magentix
 * @copyright Copyright © 2019 Magentix. All rights reserved.
 * @license   https://www.magentix.fr/en/licence.html Magentix Software Licence
 * @link      https://colissimo.magentix.fr/
 */
namespace Colissimo\Rule\Model\Rule\Metadata;

use Colissimo\Rule\Model\Rule;
use Colissimo\Rule\Model\Source\Actions;
use Magento\Store\Model\System\Store;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\SalesRule\Api\RuleRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Convert\DataObject;

/**
 * Class ValueProvider
 */
class ValueProvider
{
    /**
     * @var Store $store
     */
    protected $store;

    /**
     * @var GroupRepositoryInterface $groupRepository
     */
    protected $groupRepository;

    /**
     * @var RuleRepositoryInterface $salesRuleRepository
     */
    protected $salesRuleRepository;

    /**
     * @var SearchCriteriaBuilder searchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var DataObject $objectConverter
     */
    protected $objectConverter;

    /**
     * @var Actions $actions
     */
    protected $actions;

    /**
     * Initialize dependencies.
     *
     * @param Store $store
     * @param GroupRepositoryInterface $groupRepository
     * @param RuleRepositoryInterface $salesRuleRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param DataObject $objectConverter
     * @param Actions $actions
     */
    public function __construct(
        Store $store,
        GroupRepositoryInterface $groupRepository,
        RuleRepositoryInterface $salesRuleRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        DataObject $objectConverter,
        Actions $actions
    ) {
        $this->store = $store;
        $this->groupRepository = $groupRepository;
        $this->salesRuleRepository = $salesRuleRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->objectConverter = $objectConverter;
        $this->actions = $actions;
    }

    /**
     * Get metadata for sales rule form. It will be merged with form UI component declaration.
     *
     * @return array
     * @throws
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function getMetadataValues()
    {
        $customerGroups = $this->groupRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        $groups = $this->objectConverter->toOptionArray($customerGroups, 'id', 'code');

        $cartRules = $this->salesRuleRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        $rules = array_merge(
            [
                [
                    'label' => __('None'),
                    'value' => 0
                ]
            ],
            $this->objectConverter->toOptionArray($cartRules, 'rule_id', 'name')
        );

        return [
            'rule_information' => [
                'children' => [
                    'website_ids' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => $this->store->getWebsiteValuesForForm(),
                                ],
                            ],
                        ],
                    ],
                    'is_active' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => [
                                        ['label' => __('Active'), 'value' => '1'],
                                        ['label' => __('Inactive'), 'value' => '0']
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'customer_group_ids' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => $groups,
                                ],
                            ],
                        ],
                    ],
                    'cart_rule_id' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => $rules,
                                ],
                            ],
                        ],
                    ],
                ]
            ],
            'actions' => [
                'children' => [
                    'shipping_action' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'options' => $this->actions->toOptionArray(),
                                ],
                            ],
                        ],
                    ],
                    'shipping_amount' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'value' => '0',
                                ],
                            ],
                        ],
                    ],
                ]
            ],
        ];
    }
}
