<?php

use app\modules\linker\search\ShortUrlSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\web\View;

/**
 * @var View $this
 * @var ShortUrlSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = 'Short urls list';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="short-url-list">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'short_url',
            'url:url',
        ],
    ]) ?>
</div>
