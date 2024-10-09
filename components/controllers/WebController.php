<?php

namespace app\components\controllers;

use Yii;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\User;

/**
 * @property User $user
 */
abstract class WebController extends Controller
{
    public function getUser(): User
    {
        return Yii::$app->user;
    }

    public function queryParams(): ?array
    {
        return Yii::$app->request->queryParams;
    }

    /**
     * @param string $view
     * @param array $params
     * @return Response
     */
    public function render($view, $params = []): Response
    {
        $response = Yii::$app->getResponse();
        $response->data = parent::render($view, $params);
        return $response;
    }

    /**
     * @param string $view
     * @param array $params
     * @return Response
     */
    public function renderAjax($view, $params = []): Response
    {
        $response = Yii::$app->getResponse();
        $response->data = parent::renderAjax($view, $params);
        return $response;
    }

    /**
     * Быстрый доступ к механизму межстраничных сообщений, удобный для использования в контроллерах.
     */
    public function success(
        string $message,
        ?string $category = null,
        array $params = [],
        bool $removeAfterAccess = true,
    ): self {
        $this->addFlash('success', $message, $category, $params, $removeAfterAccess);

        return $this;
    }

    /**
     * Добавляет флэш сообщение в сессию.
     */
    public function addFlash(
        $type,
        string $message,
        ?string $category = null,
        array $params = [],
        bool $removeAfterAccess = true,
    ): self {
        // Наличие категории является признаком того, что нужно перевести сообщение в текущий язык.
        if ($category !== null) {
            $message = Yii::t($category, $message, $params);
        }

        Yii::$app->getSession()->addFlash($type, $message, $removeAfterAccess);

        return $this;
    }

    /**
     * Быстрый доступ к механизму межстраничных сообщений, удобный для использования в контроллерах.
     */
    public function primary(
        string $message,
        ?string $category = null,
        array $params = [],
        bool $removeAfterAccess = true,
    ): self {
        $this->addFlash('primary', $message, $category, $params, $removeAfterAccess);

        return $this;
    }

    /**
     * Быстрый доступ к механизму межстраничных сообщений, удобный для использования в контроллерах.
     */
    public function secondary(
        string $message,
        ?string $category = null,
        array $params = [],
        bool $removeAfterAccess = true,
    ): self {
        $this->addFlash('secondary', $message, $category, $params, $removeAfterAccess);

        return $this;
    }

    /**
     * Быстрый доступ к механизму межстраничных сообщений, удобный для использования в контроллерах.
     */
    public function info(
        string $message,
        ?string $category = null,
        array $params = [],
        bool $removeAfterAccess = true,
    ): self {
        $this->addFlash('info', $message, $category, $params, $removeAfterAccess);

        return $this;
    }

    /**
     * Быстрый доступ к механизму межстраничных сообщений, удобный для использования в контроллерах.
     */
    public function error(
        string $message,
        ?string $category = null,
        array $params = [],
        bool $removeAfterAccess = true,
    ): self {
        $this->addFlash('danger', $message, $category, $params, $removeAfterAccess);

        return $this;
    }

    /**
     * Быстрый доступ к механизму межстраничных сообщений, удобный для использования в контроллерах.
     */
    public function warning(
        string $message,
        ?string $category = null,
        array $params = [],
        bool $removeAfterAccess = true,
    ): self {
        $this->addFlash('warning', $message, $category, $params, $removeAfterAccess);

        return $this;
    }

    /**
     * Быстрый доступ к механизму межстраничных сообщений, удобный для использования в контроллерах.
     */
    public function light(
        string $message,
        ?string $category = null,
        array $params = [],
        bool $removeAfterAccess = true,
    ): self {
        $this->addFlash('light', $message, $category, $params, $removeAfterAccess);

        return $this;
    }

    /**
     * Быстрый доступ к механизму межстраничных сообщений, удобный для использования в контроллерах.
     */
    public function dark(
        string $message,
        ?string $category = null,
        array $params = [],
        bool $removeAfterAccess = true,
    ): self {
        $this->addFlash('dark', $message, $category, $params, $removeAfterAccess);

        return $this;
    }

    protected function post(): ?array
    {
        return Yii::$app->request->post();
    }

    protected function isAjax(): bool
    {
        return Yii::$app->request->isAjax;
    }

    protected function isPost(): bool
    {
        return Yii::$app->request->isPost;
    }

    /**
     * @param string $className
     * @param int|string $id
     * @return ActiveRecord
     * @throws NotFoundHttpException
     */
    protected function findModel(string $className, int|string $id): ActiveRecord
    {
        /**
         * @var ActiveRecord $className
         */
        return $className::findOne($id) ?? throw new NotFoundHttpException();
    }
}