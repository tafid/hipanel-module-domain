<?php

namespace hipanel\modules\domain\cart;

use hipanel\modules\domain\models\Domain;
use hipanel\modules\finance\cart\AbstractCartPosition;
use Yii;

abstract class AbstractPremiumProduct extends AbstractCartPosition
{
    /**
     * @var Domain
     */
    protected $_model;

    /**
     * @var string the operation name
     */
    protected $_operation;

    /** {@inheritdoc} */
    protected $_calculationModel = PremiumCalculation::class;

    /** {@inheritdoc} */
    public function getIcon()
    {
        return '<i class="fa fa-globe"></i>';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
        ];
    }

    /** {@inheritdoc} */
    public function getQuantityOptions()
    {
        $result = [];

        for ($n = 1; $n <= 10; ++$n) {
            $result[$n] = Yii::t('hipanel:domain', '{0, plural, one{# year} other{# years}}', $n);
        }

        return $result;
    }

    /** {@inheritdoc} */
    public function getCalculationModel($options = [])
    {
        return parent::getCalculationModel(array_merge([
            'type' => $this->_operation,
            'domain' => $this->name,
        ], $options));
    }
}
