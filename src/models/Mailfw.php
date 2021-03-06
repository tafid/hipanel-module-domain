<?php

namespace hipanel\modules\domain\models;

use Yii;
use hipanel\helpers\StringHelper;
use yii\validators\EmailValidator;

class Mailfw extends \hipanel\base\Model
{
    use PaidFeatureForwardingTrait;

    public $status = 'new';

    public $typename = 'email';

    public function rules()
    {
        return [
            [['id', 'domain_id', 'dns_id', 'type_id'], 'integer'],
            [['name', 'value', 'type', 'type_label', 'status', 'typename'], 'string'],
            [['name', 'value'], 'required'],
            [['name'], 'match', 'pattern' => '@^[a-zA-Z0-9._*]+$@'],
            [
                ['value'],
                function ($attribute, $params) {
                    $validator = new EmailValidator();
                    $emails = StringHelper::mexplode($this->{$attribute}, '/[\s,]+/', true, true);
                    foreach ($emails as $email) {
                        if (!$validator->validate($email, $error)) {
                            $this->addError($attribute, $error);
                        }
                    }
                },
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('hipanel.domain.premium', 'User name'),
            'value' => Yii::t('hipanel.domain.premium', 'Forwarding addresses'),
        ];
    }
}
