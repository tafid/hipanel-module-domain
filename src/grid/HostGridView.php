<?php

namespace hipanel\modules\domain\grid;

use hipanel\grid\BoxedGridView;
use hipanel\modules\domain\controllers\DomainController;
use Yii;
use yii\helpers\Html;

class HostGridView extends BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'host' => [
                'class' => 'hipanel\grid\MainColumn',
                'filterAttribute' => 'host_like',
            ],
            'bold_host' => [
                'format'    => 'html',
                'attribute' => 'host',
                'value'     => function ($model) {
                    return Html::tag('b', $model->host);
                }
            ],
            'domain' => [
                'format' => 'html',
                'filterAttribute' => 'domain_like',
                'value' => function ($model) {
                    $domain = explode('.', $model->host,2)[1];
                    return $model->domain_id
                        ? Html::a($domain, DomainController::getActionUrl('view',$model->domain_id))
                        : Html::tag('b', $domain)
                    ;
                }
            ],
            'ips' => [
                'class' => 'hiqdev\xeditable\grid\XEditableColumn',
                'pluginOptions' => [
                    'url' => 'update',
                ],
            ]

        ];
    }
}