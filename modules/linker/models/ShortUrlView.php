<?php

namespace app\modules\linker\models;

use app\components\db\CoreActiveRecord;
use app\enums\Tables;
use yii\behaviors\TimestampBehavior;


/**
 * @property string $id
 * @property string $short_utl_id
 * @property string $created_at
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
                'short_url_id',
                'exist',
                'targetClass' => ShortUrl::class,
                'targetAttribute' => ['short_url_id' => 'id'],
            ],
        ];
    }

    public static function create(string $shortUrlId): ShortUrlView
    {
        return (new ShortUrlView([['short_url_id' => $shortUrlId]]))->saveOrPanic();
    }
}