<?php


namespace app\modules\api\v1\controllers;


use app\models\Comment;
use yii\rest\ActiveController;

class CommentController extends ActiveController
{
    public $modelClass = Comment::class;
}
