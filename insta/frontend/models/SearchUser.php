<?php


namespace frontend\models;

use yii\base\Model;
use Yii;

class SearchUser extends Model
{

    public function simpleSearch($keyWord)
    {
        $sql = "SELECT * FROM user WHERE username LIKE ('%$keyWord%')";
        return Yii::$app->db->createCommand($sql)->queryAll();
    }

}