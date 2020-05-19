<?php

namespace frontend\modules\post\models\forms;


use Yii;
use yii\base\Model;
use frontend\models\Post;
use frontend\models\User;
use frontend\models\events\PostCreatedEvent;

class PostForm extends Model
{
    const MAX_DESCRIPTIONS_LENGHT = 1000;
    const EVENT_POST_CREATED = 'post_created';

    public $picture;
    public $description;
    public $status;

    private $user;

    public function rules()
    {
        return [
            [['picture'], 'file',
                'skipOnEmpty' => false,
                'extensions' => ['jpg', 'png', 'jpeg'],
                'checkExtensionByMimeType' => true,
                'maxSize' => $this->getMaxFileSize()],
            [['description'], 'string', 'max' => self::MAX_DESCRIPTIONS_LENGHT],
            [['status'], 'integer'],
        ];
    }

    public function __construct(User $user)
    {
        $this->user = $user;
        //$this->on(self::EVENT_AFTER_VALIDATE, [$this, 'resizePicture']);
        $this->on(self::EVENT_POST_CREATED, [Yii::$app->feedService, 'addToFeeds']);
    }



    public function save()
    {
        if ($this->validate()) {
            $post = new Post();
            $post->description = $this->description;
            $post->status = $this->status;
            $post->created_at = time();

            $params = self::getResizeParams();
            $post->filename = Yii::$app->storagePostPicture->saveUploadedFile($this->picture, $params);
            $post->user_id = $this->user->getId();

            if ($post->save(false)) {
                $rating = Post::find()->where(['user_id' => $this->user->getId()])->andWhere(['status' => 1])->count();
                $curUser = User::findOne($this->user->getId());
                $curUser->rating = $rating;
                $curUser->save();
                return true;
            }
            return false;
        }
        return false;
    }

    public function postUpdate($id)
    {

        if ($this->validate()) {
            $post = Post::find()->where(['id'=>$id])->one();

            $post->description = $this->description;
            $post->created_at = time();
            $post->filename = Yii::$app->storagePostPicture->saveUploadedFile($this->picture);
            $post->user_id = $this->user->getId();
            if ($post->save(false)) {
                $event = new PostCreatedEvent();
                $event->user = $this->user;
                $event->post = $post;
//                $this->trigger(self::EVENT_POST_CREATED, $event);
                return true;
            }
        }
        return false;

    }

    private function getMaxFileSize()
    {
        return Yii::$app->params['maxFileSize'];
    }

    private function getResizeParams()
    {
        return Yii::$app->params['paramsUploadPictureFromUserPosts'];
    }

}