<?php

namespace app\modules\linker\controllers;

use app\components\controllers\WebController;
use app\components\exceptions\ValidationException;
use app\modules\linker\forms\CreateShortUrlForm;
use app\modules\linker\search\ShortUrlSearch;
use app\modules\linker\services\LinkerService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;

final class SiteController extends WebController
{
    public function __construct(
        $id,
        $module,
        private readonly LinkerService $linkerService,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): Response
    {
        $searchModel = new ShortUrlSearch();
        $dataProvider = $searchModel->search($this->queryParams());
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate(): Response
    {
        $model = new CreateShortUrlForm();
        if ($model->load($this->post())) {
            try {
                $linkModel = $this->linkerService->create($model);
                return $this->info('Link created: ' . $linkModel->short_url)->redirect(['index']);
            } catch (ValidationException $exception) {
                $this->error($exception->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionView(string $shortUrl): Response
    {
        $this->linkerService->view($shortUrl);
    }
}