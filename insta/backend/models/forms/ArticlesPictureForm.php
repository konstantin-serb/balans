<?php

namespace backend\models\forms;

use Yii;
use backend\models\PostsImage;
use yii\base\Model;

class ArticlesPictureForm extends Model
{
    private $post_id;
    private $path;
    private $status;


    public function view($postId)
    {
        $photos = PostsImage::find()->where(['post_id' => $postId])->orderBy('id desc')->all();
        $value = '';
        $value .= '
            <div class="row">';
        foreach ($photos as $picture) {
            $value .= '<div class="col-md-12 pictureAdd">
                            <img class="addedPictures" src="'.$picture->getImage().'">
                            &lt;div class="central"&gt;<br>
                            &lt;img src="'.Yii::$app->params['storageAdmin'].'<wbr>'.$picture->path.'"style="" alt="photo"&gt;
                            <br>&lt;/div&gt;
                            <br>
                            <a class="btn btn-danger btnDelete" post-id="'.$postId.'" data-id="'.$picture->id.'">Удалить</a>
                        </div>
                    <hr>';
        }
        $value .= '</div>';

        return $value;
    }


    public function footer($name)
    {
        $photos = PostsImage::find()->where(['title' => $name])->orderBy('id desc')->all();
        $value = '';
        $value .= '
            <br>
            <div class="row">';
        foreach ($photos as $picture) {
            $value .= '<div class="col-md-12 pictureAdd">
                            <img class="addedPictures" src="'.$picture->getImage().'">
                            &lt;div class="central"&gt;<br>
                            &lt;img src="'.Yii::$app->params['storageAdmin'].'<wbr>'.$picture->path.'"style="" alt="photo"&gt;
                            <br>&lt;/div&gt;
                            <br>
                            <a class="btn btn-danger btnDelete" post-id="'.$name.'" data-id="'.$picture->id.'">Удалить</a>
                        </div>
                    <hr>';
        }
        $value .= '</div>';

        return $value;
    }

    public function blurb($name)
    {
        $photos = PostsImage::find()->where(['title' => $name])->orderBy('id desc')->all();
        $value = '';
        $value .= '
            <br>
            <div class="row">';
        foreach ($photos as $picture) {
            $value .= '<div class="col-md-12 pictureAdd">
                            <img class="addedPictures" src="'.$picture->getImage().'">
                           
                            '.$picture->path.'
                            <br>
                            <a class="btn btn-danger btnDelete" post-id="'.$name.'" data-id="'.$picture->id.'">Удалить</a>
                        </div>
                    <hr>';
        }
        $value .= '</div>';

        return $value;
    }

    public function blurbVert($name)
    {
        $photos = PostsImage::find()->where(['title' => $name])
            ->andWhere(['status' => 4])
            ->orderBy('id desc')->all();
        $value = '';
        $value .= '
            <br>
            <div class="row">';
        foreach ($photos as $picture) {
            $value .= '<div class="col-md-12 pictureAdd">
                            <img class="addedPicturesVert" src="'.$picture->getImage().'">
                           
                            '.$picture->path.'
                            <br>
                            <a class="btn btn-danger btnDeleteVert" post-id="'.$name.'" data-id="'.$picture->id.'">Удалить</a>
                        </div>
                    <hr>';
        }
        $value .= '</div>';

        return $value;
    }


}
