<?php

namespace app\controllers;

use app\components\controllers\WebController;
use app\components\exceptions\ValidationException;
use app\forms\SignupForm;
use app\services\IdentitySignupService;
use Throwable;
use yii\web\Response;

class SignupController extends WebController
{
    public function __construct(
        $id,
        $module,
        private readonly IdentitySignupService $service,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): Response
    {
        $model = new SignupForm();

        if ($model->load($this->post())) {
            try {
                $this->service->requestSignup($model);
                return $this->info('Follow email instructions')->goHome();
            } catch (ValidationException $exception) {
                $this->error($exception->getMessage());
            } catch (Throwable $exception) {
                $this->error($exception->getMessage());
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionConfirm(string $token): Response
    {
        try {
            $this->service->complete($token);
            $this->info('Your email has been confirmed');
        } catch (ValidationException $exception) {
            $this->error($exception->getMessage());
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());
        }

        return $this->goHome();
    }
}