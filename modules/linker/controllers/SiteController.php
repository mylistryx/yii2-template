<?php

namespace app\modules\linker\controllers;

use app\components\controllers\WebController;
use app\components\exceptions\EntityNotFoundException;
use app\components\exceptions\ValidationException;
use app\modules\linker\forms\CreateShortUrlForm;
use app\modules\linker\search\ShortUrlSearch;
use app\modules\linker\services\ShortUrlService;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;

final class SiteController extends WebController
{
    public function __construct(
        $id,
        $module,
        private readonly ShortUrlService $shortUrlService,
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
                $shortUrl = $this->shortUrlService->create($model);
                return $this->redirect(['view', 'id' => $shortUrl->id]);
            } catch (ValidationException $exception) {
                $this->error($exception->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView(string $id): Response
    {
        try {
            $entity = $this->shortUrlService->getEntityById($id);

            return $this->render('view', [
                'entity' => $entity,
            ]);
        } catch (EntityNotFoundException) {
            throw new NotFoundHttpException();
        }
    }

    public function actionGo(string $shortUrl): Response
    {
        $shortUrlEntity = $this->shortUrlService->go($shortUrl);
        return $this->redirect($shortUrlEntity->url);
    }
}