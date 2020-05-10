<?php

namespace frontend\modules\post\models\forms;


use Yii;
use yii\base\Model;
use frontend\models\Post;
use frontend\models\User;


class PostEditForm extends Model
{

    const MAX_DESCRIPTIONS_LENGHT = 1000;


    public $picture;
    public $description;
    public $status;

    private $user;
    private $updated_at;

    public function rules()
    {
        return [
            [['description'], 'string', 'max' => self::MAX_DESCRIPTIONS_LENGHT],
            [['status'], 'safe'],
        ];
    }

    public function __construct(User $user)
    {
        $this->user = $user;
    }



    public function save($id)
    {
        if ($this->validate()) {
            $post = Post::findOne($id);
            $post->description = $this->description;
            $post->status = $this->status;


            $post->updated_at = time();
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




    private function getMaxFileSize()
    {
        return Yii::$app->params['maxFileSize'];
    }

}