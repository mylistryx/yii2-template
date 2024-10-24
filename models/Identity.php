<?php

namespace app\models;

use app\components\db\CoreActiveRecord;
use app\enums\IdentityStatus;
use app\enums\IdentityTokenType;
use app\repositories\IdentityRepository;
use app\repositories\IdentityTokenRepository;
use Ramsey\Uuid\Rfc4122\UuidV7;
use Ramsey\Uuid\Uuid;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
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
 * @property-write string $password
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

    /**
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            [['email', 'password_hash'], 'required'],
            ['email', 'email'],
            ['email', 'unique'],

            ['auth_key', 'default', 'value' => Yii::$app->security->generateRandomString()],
            ['id', 'default', 'value' => Uuid::uuid7()],
            ['current_status', 'default', 'value' => IdentityStatus::INACTIVE->value],
        ];
    }

    public static function create(string $email, string $password): self
    {
        return (new static([
            'email' => $email,
            'password' => $password,
        ]))->saveOrPanic();
    }

    /**
     * @throws InvalidConfigException
     */
    public static function findIdentity($id): ?static
    {
        /** @var IdentityRepository $repository */
        $repository = Yii::createObject(IdentityRepository::class);
        return $repository->findById($id);
    }

    /**
     * @throws InvalidConfigException
     */
    public static function findIdentityByAccessToken($token, $type = null): ?static
    {
        /** @var IdentityTokenRepository $repository */
        $repository = Yii::createObject(IdentityTokenRepository::class);
        $accessToken = $repository->findByToken($token, $type);
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
        $this->current_status = $status->value;
    }
}
