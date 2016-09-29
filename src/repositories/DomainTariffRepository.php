<?php

namespace hipanel\modules\domain\repositories;

use hipanel\modules\finance\models\DomainResource;
use hipanel\modules\finance\models\Tariff;
use Yii;
use yii\base\InvalidConfigException;

class DomainTariffRepository
{
    /**
     * Returns the tariff for the domain operations
     * Caches the API request for 3600 seconds and depends on client id and seller login.
     * @throws \yii\base\InvalidConfigException
     * @return Tariff
     */
    public function getTariff()
    {
        if (Yii::$app->user->isGuest) {
            if (isset(Yii::$app->params['seller'])) {
                $params = [
                    Yii::$app->params['seller'],
                    null
                ];
            } else throw new InvalidConfigException('"seller" is must be set');
        } else {
            $params = [
                Yii::$app->user->identity->seller,
                Yii::$app->user->id,
            ];
        }

        return Yii::$app->getCache()->getTimeCached(3600, $params, function ($seller, $client_id) {
            return Tariff::find(['scenario' => 'get-available-info'])
                ->joinWith('resources')
                ->andFilterWhere(['type' => 'domain'])
                ->andFilterWhere(['seller' => $seller])
                ->one();
        });
    }

    /**
     * @param Tariff $tariff
     * @param string $type
     * @return array
     */
    public function getZones($tariff, $type = DomainResource::TYPE_DOMAIN_REGISTRATION)
    {
        if ($tariff === null || !$tariff instanceof Tariff) {
            return [];
        }

        return array_filter((array)$tariff->resources, function ($resource) use ($type) {
            return $resource->zone !== null && $resource->type === $type;
        });
    }

    public function getAvailableZones()
    {
        $tariff = $this->getTariff();

        return $this->getZones($tariff);
    }
}
