<?php

namespace app\components\traits;

use app\components\exceptions\IdentityStatusException;
use app\enums\IdentityStatus;
use app\models\Identity;
use Exception;

trait IdentityStatusChecker
{
    public function checkIdentityStatus(Identity $identity, IdentityStatus $status): void
    {
        if ($identity->status !== $status) {
            throw new IdentityStatusException();
        }
    }

    /**
     * @param Identity $identity
     * @param array|IdentityStatus[] $statusList
     * @return void
     * @throws Exception
     */
    public function checkIdentityStatusIn(Identity $identity, array $statusList): void
    {
        $success = false;
        foreach ($statusList as $status) {
            if ($status instanceof IdentityStatus) {
                if ($identity->status !== $status) {
                    $success = $success && $identity->status === $status;
                }
            } else {
                throw new Exception('Invalid identity status in list');
            }
        }

        if (!$success) {
            throw new IdentityStatusException();
        }
    }
}