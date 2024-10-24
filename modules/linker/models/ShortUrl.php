<?php

namespace app\modules\linker\models;

use app\components\db\CoreActiveRecord;
use app\enums\Tables;
use Ramsey\Uuid\Uuid;
use Yii;
use yii\base\Exception;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * @property string $id
 * @property string $url
 * @property string $short_url
 * @property string $created_at
 * @property string $created_by
 *
 * @property-read array|ShortUrlView[] $views
 */
class ShortUrl extends CoreActiveRecord
{
    public static function tableName(): string
    {
        return Tables::SHORT_URL->value;
    }

    public function behaviors(): array
    {
        return [
            'TimeStamp' => [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
                'value' => date('Y-m-d H:i:s'),
            ],
            'Blameable' => [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false,
            ],
        ];
    }

    public function rules(): array
    {
        $length = Yii::$app->params['linker.shortUrlLength'];
        return [
            [['url'], 'required'],
            ['url', 'url'],

            [
                'id',
                'default',
                'value' => Uuid::uuid7(),
            ],
            [
                'short_url',
                'default',
                'value' => $this->generateShortUrl($length),
            ],
        ];
    }

    public function generateShortUrl(int $length): string
    {
        do {
            $shortUrl = Yii::$app->security->generateRandomString($length);
        } while (ShortUrl::find()->where(['short_url' => $shortUrl])->exists());

        return $shortUrl;
    }

    public static function create(string $url): ShortUrl
    {
        return (new static(['url' => $url]))->saveOrPanic();
    }

    public
    function getViews(): ActiveQuery
    {
        return $this->hasMany(ShortUrlView::class, ['short_url_id' => 'id']);
    }
}