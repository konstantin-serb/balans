<?php


namespace frontend\modules\user\models;


use frontend\models\User;
use Yii;
use yii\base\Model;

class UpdateForm extends Model
{
    public $username;
    public $currentPassword;
    public $password;
    public $about;
    public $nickname;
    public $currentUserId;

    private $updated_at;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],

//            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            [['about'], 'string', 'max' => 1000],

            [['nickname'], 'string', 'min' => 5, 'max' => 20],
            [['nickname'], 'unique', 'targetClass' => '\frontend\models\User', 'message' => 'Извините, но такой никнейм уже зарегистрироваан!'],

            [['updated_at'], 'safe'],
            ['currentPassword', 'string', 'min' => 6],
        ];
    }

    public function update()
    {

        $this->updated_at = time();
        if (!$this->validate()) {
            return false;
        }
        $user = User::findOne($this->currentUserId);

        $user->username = $this->username;

        if(!empty($this->nickname)) {
        $user->nickname = $this->nickname;
        }

        if (!empty($this->password)) {
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }

        $user->about = $this->about;
        $user->created_at = $this->updated_at;

        if ($user->save()) {
            return true;
        }
        return false;
    }


}













