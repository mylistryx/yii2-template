<?php

namespace app\modules\linker\search;

use app\modules\linker\models\ShortUrl;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class ShortUrlSearch extends ShortUrl
{
    public function rules(): array
    {
        return [];
    }

    public function search(?array $params = []): DataProviderInterface
    {
        $query = ShortUrl::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params,'');
        $this->validate();

        return $dataProvider;
    }
}
