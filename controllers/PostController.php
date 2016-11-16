<?php

namespace app\controllers;

class PostController extends \yii\web\Controller
{
    public function actionArchive()
    {
        return $this->render('archive');
    }

    public function actionCreate()
    {
        return $this->render('create');
    }

    public function actionDelete()
    {
        return $this->render('delete');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpdate()
    {
        return $this->render('update');
    }

    public function actionView()
    {
        return $this->render('view');
    }

    public function actionFeed()
    {

    }
}
