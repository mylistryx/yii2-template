<?php

namespace app\controllers;

use app\components\controllers\WebController;
use app\components\exceptions\ValidationException;
use app\forms\LoginForm;
use app\services\IdentityAuthService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

final class AuthController extends WebController
{
    public function __construct(
        $id,
        $module,
        private readonly IdentityAuthService $authService,
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
        $this->checkIsGuest();
        $model = new LoginForm();

        if ($model->load($this->post())) {
            try {
                $this->authService->login($model);
                return $this->success('Login successful')->goBack();
            } catch (ValidationException $exception) {
                $this->error($exception->getMessage());
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionLogout(): Response
    {
        $this->authService->logout();
        return $this->goHome();
    }
}