<?php

namespace craft\commerce\elements\db;

use craft\commerce\elements\Product;
use craft\db\Query;
use craft\elements\db\ElementQuery;
use craft\helpers\Db;

/**
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  3.0
 */
class VariantQuery extends ElementQuery
{

    public $sku;
    public $product;
    public $productId;
    public $isDefault;
    public $stock;
    public $hasStock;

    public function sku($value)
    {
        $this->sku = $value;

        return $this;
    }

    public function product($value)
    {
        $this->product = $value;

        return $this;
    }

    public function productId($value)
    {
        $this->productId = $value;

        return $this;
    }

    public function isDefault($value)
    {
        $this->isDefault = $value;

        return $this;
    }

    public function stock($value)
    {
        $this->stock = $value;

        return $this;
    }

    public function hasStock($value)
    {
        $this->hasStock = $value;

        return $this;
    }



    // Protected Methods
    // =========================================================================
    /**
     * @inheritdoc
     */
    protected function beforePrepare(): bool
    {
        $this->joinElementTable('commerce_variants');

        $this->query->select([
            'commerce_variants.id',
            'commerce_variants.productId',
            'commerce_variants.isDefault',
            'commerce_variants.sku',
            'commerce_variants.price',
            'commerce_variants.sortOrder',
            'commerce_variants.width',
            'commerce_variants.height',
            'commerce_variants.length',
            'commerce_variants.weight',
            'commerce_variants.stock',
            'commerce_variants.unlimitedStock',
            'commerce_variants.minQty',
            'commerce_variants.maxQty'
        ]);

        if ($this->sku) {
            $this->subQuery->andWhere(Db::parseParam('commerce_variants.sku', $this->sku));
        }

        if ($this->product) {
            if ($this->product instanceof Product) {
                $this->subQuery->andWhere(Db::parseParam('commerce_variants.productId', $this->product->id));
            } else {
                $this->subQuery->andWhere(Db::parseParam('commerce_variants.productId', $this->product));
            }
        }

        if ($this->productId) {
            $this->subQuery->andWhere(Db::parseParam('commerce_variants.productId', $this->productId));
        }

        if ($this->isDefault) {
            $this->subQuery->andWhere(Db::parseParam('commerce_variants.isDefault', $this->isDefault));
        }

        if ($this->stock) {
            $this->subQuery->andWhere(Db::parseParam('commerce_variants.stock', $this->stock));
        }

        if (null !== $this->hasStock && $this->hasStock === true) {
            $hasStockCondition = ['or', '(commerce_variants.stock > 0 AND commerce_variants.unlimitedStock != 1)', 'commerce_variants.unlimitedStock = 1'];
            $this->subQuery->andWhere($hasStockCondition);
        }

        if (null !== $this->hasStock && $this->hasStock === false) {
            $hasStockCondition = ['and', 'commerce_variants.stock < 1', 'commerce_variants.unlimitedStock != 1'];
            $this->subQuery->andWhere($hasStockCondition);
        }

        if (!$this->orderBy) {
            $this->orderBy = 'sortOrder desc';
        }

        return parent::beforePrepare();
    }

    /**
     * @inheritDoc IElementType::getEagerLoadingMap()
     *
     * @param BaseElementModel[] $sourceElements
     * @param string             $handle
     *
     * @return array|false
     */
    public function getEagerLoadingMap($sourceElements, $handle)
    {
        if ($handle == 'product') {
            // Get the source element IDs
            $sourceElementIds = [];

            foreach ($sourceElements as $sourceElement) {
                $sourceElementIds[] = $sourceElement->id;
            }

            $map = (new Query())
                ->select('id as source, productId as target')
                ->from('commerce_variants')
                ->where(['in', 'id', $sourceElementIds])
                ->all();

            return [
                'elementType' => Product::class,
                'map' => $map
            ];
        }

        return parent::getEagerLoadingMap($sourceElements, $handle);
    }


}