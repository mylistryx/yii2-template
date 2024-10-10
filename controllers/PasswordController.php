<?php

namespace app\controllers;

use app\components\controllers\WebController;
use app\components\exceptions\ValidationException;
use app\forms\password\ChangePasswordForm;
use app\forms\password\RequestPasswordResetForm;
use app\forms\password\ResetPasswordForm;
use app\services\IdentityPasswordService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;

final class PasswordController extends WebController
{
    public function behaviors(): array
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function __construct(
        $id,
        $module,
        private readonly IdentityPasswordService $service,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): Response
    {
        $model = new ChangePasswordForm(Yii::$app->user->identity);

        if ($model->load($this->post())) {
            try {
                $this->service->changePassword($model);
                return $this->success('Password changed')->refresh();
            } catch (ValidationException $exception) {
                $this->error($exception->getMessage());
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionRequest(): Response
    {
        $this->checkIsGuest();
        $model = new RequestPasswordResetForm();

        if ($model->load($this->post())) {
            try {
                $this->service->requestPasswordReset($model);
                return $this->success('Password reset requested')->refresh();
            } catch (ValidationException $exception) {
                $this->error($exception->getMessage());
            }
        }

        return $this->render('request', [
            'model' => $model,
        ]);
    }

    public function actionReset(string $token): Response
    {
        $this->checkIsGuest();
        $model = new ResetPasswordForm($token);

        if ($model->load($this->post())) {
            try {
                $this->service->resetPassword($model);
                return $this->success('Password reset requested')->redirect(['/auth/login']);
            } catch (ValidationException $exception) {
                $this->error($exception->getMessage());
            }
        }

        return $this->render('reset');
    }
}