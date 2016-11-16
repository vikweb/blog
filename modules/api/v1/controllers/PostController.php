<?php


namespace app\modules\api\v1\controllers;

use app\models\Post;
use yii\rest\ActiveController;

class PostController extends ActiveController
{
    public $modelClass = Post::class;
}