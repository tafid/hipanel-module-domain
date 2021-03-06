<?php

namespace hipanel\modules\domain\grid;

use hipanel\grid\GridView;
use yii\base\InvalidConfigException;

abstract class AbstractPremiumGrid extends GridView
{
    /**
     * @var string
     */
    public $domain;

    /**
     * @var boolean|null
     */
    public $is_premium;

    public $layout = "<div class=\"table-responsive\">{items}</div>";

    public $tableOptions = ['class' => 'table'];

    public $options = [];

    public function init()
    {
        parent::init();
        if (!$this->domain) {
            throw new InvalidConfigException('Attribute `domain` is not set.');
        }
    }

    public function columns()
    {
        return array_merge(parent::columns(), [
            'actions' => [
                'class' => PremiumActionColumn::class,
                'is_premium' => $this->is_premium,
            ],
        ]);
    }
}
