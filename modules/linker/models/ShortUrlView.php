<?php

namespace app\modules\linker\models;

use app\components\db\CoreActiveRecord;
use app\enums\Tables;
use Ramsey\Uuid\Uuid;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;


/**
 * @property string $id
 * @property string $short_utl_id
 * @property string $ip
 * @property string $created_at
 *
 * @property-read ShortUrl $shortUrl
 */
class ShortUrlView extends CoreActiveRecord
{
    public static function tableName(): string
    {
        return Tables::SHORT_URL_VIEW->value;
    }

    public function behaviors(): array
    {
        return [
            'TimeStamp' => [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [
                'id',
                'default',
                'value' => Uuid::uuid7(),
            ],
            [
                'ip',
                'default',
                'value' => Yii::$app->getRequest()->getUserIP(),
            ],
            [
                'short_url_id',
                'validateUuid',
            ],
        ];
    }

    public static function create(ShortUrl $shortUrl): ShortUrlView
    {
        return (new ShortUrlView(['short_url_id' => $shortUrl->id]))->saveOrPanic();
    }

    public function getShortUrl(): ActiveQuery
    {
        return $this->hasOne(ShortUrl::class, ['id' => 'short_url_id']);
    }
}