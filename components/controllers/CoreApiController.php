<?php

namespace app\components\controllers;

use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

abstract class CoreApiController extends Controller {
    /**
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        $result = parent::beforeAction($action);
        $this->response->format = Response::FORMAT_JSON;
        return $result;
    }
}