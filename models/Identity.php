<?php

namespace app\models;

use app\components\db\CoreActiveRecord;
use app\enums\IdentityStatus;
use app\enums\IdentityTokenType;
use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

/**
 * @property string $id string(36) UUIDv7
 * @property string $email string(64)
 * @property string $password_hash string(64)
 * @property string $auth_key string(64))
 * @property-read int $current_status int
 * @property string $created_at DateTime
 *
 * @property IdentityStatus $status
 */
class Identity extends CoreActiveRecord implements IdentityInterface
{
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

    public static function findIdentity($id): ?static
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null): ?static
    {
        $accessToken = IdentityToken::findOne([
            'token' => $token,
            'token_type' => IdentityTokenType::ACCESS->value,
        ]);

        return $accessToken?->identity;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @throws Exception
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function getStatus(): IdentityStatus
    {
        if ($this->isNewRecord) {
            return IdentityStatus::defaultValue();
        }

        return IdentityStatus::from($this->current_status);
    }

    public function setStatus(IdentityStatus $status): void
    {
        $this->status = $status->value;
    }

    public function isActive(): bool
    {
        return $this->getStatus() === IdentityStatus::ACTIVE;
    }

    public function getIdentityTokens(): ActiveQuery
    {
        return $this->hasMany(IdentityToken::class, ['identity_id' => 'id']);
    }
}
