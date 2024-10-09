<?php

namespace app\models;

use app\components\db\CoreActiveRecord;
use app\enums\IdentityTokenType;
use app\enums\Tables;
use Ramsey\Uuid\Uuid;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * @property string $id string(36) UUIDv7
 * @property string $identity_id string(36) UUIDv7
 * @property string $token string(64)
 * @property-read int $token_type int
 * @property string $created_at DateTime
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

    public function rules(): array
    {
        return [
            [['token', 'type'], 'required'],
            [['token'], 'string'],
            [['token'], 'unique'],
            [['token_type'], 'integer'],
            [['token_type', 'in', 'range' => IdentityTokenType::values()]],
            [['identity_id', 'exists', 'targetClass' => Identity::class, 'targetAttribute' => ['identity_id' => 'id']]],
            ['id', 'default', 'value' => Uuid::uuid7()],
        ];
    }

    public function getIdentity(): ActiveQuery
    {
        return $this->hasOne(Identity::class, ['id' => 'identity_id']);
    }

    public function getType(): IdentityTokenType
    {
        return IdentityTokenType::from($this->token_type);
    }

    public function setType(IdentityTokenType $type): void
    {
        $this->token_type = $type->value;
    }
}