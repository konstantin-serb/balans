<?php


namespace frontend\modules\articles\models\forms;


use Yii;
use yii\base\Model;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\User;
use frontend\modules\articles\models\MainComments;
use yii\widgets\LinkPager;

class MainCommentsViewForm extends Model
{
    public $article_id;
    public $user_id;
    public $currentUser;
    private $pageSize = 20;


    public function view()
    {
        $data = MainComments::getComments($this->pageSize, $this->article_id);
//        $comments = MainComments::find()->where(['articles_id' => $this->article_id])->orderBy('id desc')->all();
        $pagination = $data['pagination'];
        $comments = $data['comments'];
        $value = '';

        foreach ($comments as $comment) {
            $value .= '<div class="comment">
                <div class="commentInfo">
                    <div class="userPhoto">
                        <a href=" ' . Url::to(['/user/profile/view',
                    'nickname' => $comment->user->getNickname()]) . '">
                            <img src="'.$comment->user->getPicture().'" style="text-align: center; display: block;
    height: 100%; max-width: unset; margin: 0 auto;">
                        </a>
                    </div>
                    <div class="dataBlock">
                        <div class="name-info">
                            <div class="name"><a class="" ';

            if ($comment->user_id == $this->currentUser) {
                $value .= 'style="color:red;" ';
            }

            $value .= ' href="' . Url::to(['/user/profile/view',
                    'nickname' => $comment->user->getNickname()]) . '">
                                    ' . Html::encode($comment->user->username) . ':</a></div>
                            <div class="info">
                                <div class="posts">' . $comment->user->rating . ' ' . Yii::t('my page', 'posts') . ' </div>
                                |
                                <div class="followers">
                                    
                                 <a >
                                '.$comment->user->countFollowers().' '.Yii::t('my page', 'subscribers').'
                                </a></div>
                                |
                                <div class="subscriber"><a>
                                            '.Yii::t('my page', 'subscribed to {followers} users',[
                    'followers' => $comment->user->countSubscribers()
                ]).'
                                        </a>
                                </div>
                                <!--                            <div class="friends"><a href="#"> общих друзей</a></div>-->
                            </div>
                        </div>
                        <div class="nickname">
                            <b>' . Yii::t('post', 'nickname') . '
                                :</b> ' . Html::encode(($comment->user->nickname) ? $comment->user->nickname : Yii::t('post', 'No nickname')) . '
                        </div>
                        <div class="userDate">
                            <b>' . Yii::t('post', 'Comment added') . '
                                :</b> ' . Yii::$app->formatter->asDatetime($comment->created_at) . '
                        </div>
                    </div>
                </div>
                <!--            <hr>-->
                <div class="commentText">
                    <p style="';
            if ($comment->user_id == $this->currentUser) {
                $value .= 'color:red; font-weight:bold;';
            }
            $value .= ' ">

                        <i>' . Html::encode($comment->comment) . '</i>
                    </p>
                </div>
                <hr>
            </div>';
        }

        return $value;

    }


}
























