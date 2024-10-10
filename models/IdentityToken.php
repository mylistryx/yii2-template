<?php

namespace app\models;

use app\components\db\CoreActiveRecord;
use app\enums\IdentityTokenType;
use app\enums\Tables;
use Ramsey\Uuid\Uuid;
use Throwable;
use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * @property string $id string(36) UUIDv7
 * @property string $identity_id string(36) UUIDv7
 * @property string $token string(64)
 * @property-read int $token_type int
 * @property string $created_at DateTime
 *
 * @property IdentityTokenType $type
 * @property-read Identity $identity
 */
class IdentityToken extends CoreActiveRecord
{
    public static function tableName(): string
    {
        return Tables::IDENTITY_TOKEN->value;
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

    /**
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            ['token_type', 'in', 'range' => IdentityTokenType::values()],
            ['identity_id', 'required'],
            ['identity_id', 'exist', 'targetClass' => Identity::class, 'targetAttribute' => 'id'],
            ['id', 'default', 'value' => Uuid::uuid7()],
            ['token', 'default', 'value' => md5(Yii::$app->security->generateRandomString()) . '_' . time()],

        ];
    }

    public static function create(Identity $identity, IdentityTokenType $tokenType): IdentityToken
    {
        return (new static([
            'identity_id' => $identity->id,
            'token_type' => $tokenType->value,
        ]))->saveOrPanic();
    }

    public static function clean(Identity $identity, IdentityTokenType $tokenType): void
    {
        try {
            static::deleteAll([
                'identity_id' => $identity->id,
                'token_type' => $tokenType->value,
            ]);
        } catch (Throwable) {
        }
    }

    public function getIdentity(): ActiveQuery
    {
        return $this->hasOne(Identity::class, ['id' => 'identity_id']);
    }

    public function getType(): IdentityTokenType
    {
        return IdentityTokenType::from($this->token_type);
    }

    public function setType(IdentityTokenType $tokenType): void
    {
        $this->token_type = $tokenType->value;
    }
}