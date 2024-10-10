<?php

namespace app\controllers;

use app\components\controllers\WebController;
use app\components\exceptions\ValidationException;
use app\forms\SignupForm;
use app\services\IdentitySignupService;
use yii\web\Response;

final class SignupController extends WebController
{
    public function __construct(
        $id,
        $module,
        private readonly IdentitySignupService $identitySignupService,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): Response
    {
        $this->checkIsGuest();
        $model = new SignupForm();

        if ($model->load($this->post())) {
            try {
                $this->identitySignupService->requestSignup($model);
                return $this->info('Follow email instructions')->goHome();
            } catch (ValidationException $exception) {
                $this->error($exception->getMessage());
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionConfirm(string $token): Response
    {
        $this->checkIsGuest();
        try {
            $this->identitySignupService->complete($token);
            $this->info('Your email has been confirmed');
        } catch (ValidationException $exception) {
            $this->error($exception->getMessage());
        }

        return $this->goHome();
    }
}