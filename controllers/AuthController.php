<?php

namespace app\controllers;

use app\components\controllers\WebController;
use app\components\exceptions\ValidationException;
use app\forms\LoginForm;
use app\services\AuthService;
use Throwable;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

final class AuthController extends WebController
{
    public function __construct(
        $id,
        $module,
        private readonly AuthService $service,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'Access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    'logout' => [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'Verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'login' => ['get', 'post'],
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex(): Response
    {
        $model = new LoginForm();

        if ($model->load($this->post())) {
            try {
                $this->service->login($this->user, $model);
                return $this->success('Login successful')->goBack();
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

    public function actionLogout(): Response
    {
        try {
            $this->service->logout($this->user);
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());
        }

        return $this->goHome();
    }
}