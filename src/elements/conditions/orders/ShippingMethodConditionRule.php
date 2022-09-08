<?php

namespace craft\commerce\elements\conditions\orders;

use Craft;
use craft\base\conditions\BaseMultiSelectConditionRule;
use craft\commerce\elements\db\OrderQuery;
use craft\elements\conditions\ElementConditionRuleInterface;
use craft\base\ElementInterface;
use craft\elements\db\ElementQueryInterface;
use craft\helpers\ArrayHelper;
use yii\db\QueryInterface;
use craft\commerce\Plugin;

/**
 * Element status condition rule.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 4.2.0
 */
class ShippingMethodConditionRule extends BaseMultiSelectConditionRule implements ElementConditionRuleInterface
{
	/**
	 * @inheritdoc
	 */
	public function getLabel(): string
	{
		return Craft::t('app', 'Shipping Method');
	}

	/**
	 * @inheritdoc
	 */
	public function getExclusiveQueryParams(): array
	{
		return [];
	}

	/**
	 * @inheritdoc
	 */
	protected function options(): array
	{
        return ArrayHelper::map(Plugin::getInstance()->getShippingMethods()->getAllShippingMethods(), 'handle', 'name');
	}

	/**
	 * @inheritdoc
	 */
	public function modifyQuery(QueryInterface $query): void
	{
		/** @var OrderQuery $query */
		$query->shippingMethodHandle($this->paramValue());
	}

	/**
	 * @inheritdoc
	 */
	public function matchElement(ElementInterface $element): bool
	{
		return $this->matchValue($element->shippingMethod->handle);
	}
}
