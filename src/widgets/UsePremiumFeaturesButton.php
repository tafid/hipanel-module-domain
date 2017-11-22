<?php

namespace hipanel\modules\domain\widgets;

use hipanel\modules\domain\models\Domain;
use Yii;
use yii\base\Widget;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use yii\web\View;

class UsePremiumFeaturesButton extends Widget
{
    /**
     * @var Domain
     */
    public $model;

    /**
     * @var string font-awesome icon
     */
    public $icon;

    /**
     * @var string
     */
    public $text;

    /**
     * @var array|string|null the URL for the hyperlink tag. This parameter will be processed by [[Url::to()]]
     */
    public $url;

    /**
     * @var array the tag options in terms of name-value pairs
     */
    public $options = [];

    /**
     * @var string
     */
    public $modalContent;

    protected $modalId;

    public function init()
    {
        $this->modalId = 'premium-package-is-not-activated_' . $this->modalId;
        $this->view->on(View::EVENT_END_BODY, function () {
            Modal::begin([
                'id' => $this->modalId,
                'header' => Html::tag('h4', Yii::t('hipanel:domain', 'The premium package not activated'), ['class' => 'modal-title']),
                'toggleButton' => false,
                'footer' => Html::a(Yii::t('hipanel:domain', 'Active premium package'), '#premium', [
                    'class' => 'btn btn-success',
                    'data' => [
                        'toggle' => 'tab',
                        'dismiss' => 'modal',
                    ],
                ]),
            ]);

            echo $this->modalContent ?: Yii::t('hipanel:domain', 'The premium package is to be activated to enable this action.');

            Modal::end();
        });
    }

    public function run()
    {
        return $this->model->is_premium ? $this->buildPremiumLink() : $this->buildPopUp();
    }

    private function buildPremiumLink()
    {
        return Html::a($this->getText(), $this->url, $this->options);
    }

    private function buildPopUp()
    {
        return Html::button($this->getText(), array_merge([
            'data' => [
                'toggle' => 'modal',
                'target' => '#' . $this->modalId,
            ],
        ], $this->options));
    }

    private function getText()
    {
        return $this->icon ? Html::tag('i', null, ['class' => 'fa ' . $this->icon . ' fa-fw']) . ' ' . Html::encode($this->text) : Html::encode($this->text);
    }
}
