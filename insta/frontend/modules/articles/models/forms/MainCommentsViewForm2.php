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
    private $pageSize = 5;


    public function view()
    {
        $data = MainComments::getComments($this->pageSize, $this->article_id);
        $comments = $data['comments'];
        $pagination = $data['pagination'];
        $value = '';

        foreach ($comments as $comment) {
            $value .= '<div class="comment">
                <div class="commentInfo">
                    <div class="userPhoto">
                        <a href=" ' . Url::to(['/user/profile/view',
                    'nickname' => $comment->user->getNickname()]) . '">
                            <img src="<?= $comment->user->getPicture() ?>" style="text-align: center; display: block;
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
                                    <a class="btnFollowers" data-toggle="modal" data-target="#myModal"
                                       style="cursor:pointer;">';

            Modal::begin([
                'size' => 'modal-lg',
                'header' => '<h2>Followers</h2>',
                'toggleButton' => [
                    'label' => $comment->user->countFollowers() . ' ' . Yii::t('my page', 'subscribers'),
                    'tag' => 'a',
                    'style' => 'cursor:pointer;'
                ],
//                                            'footer' => 'Bottom window',
            ]);
            foreach ($comment->user->getFollowers() as $follower) {
                $value .= '<a href="' .
                    Url::to(['/user/profile/view', 'nickname' => $follower['id']])
                    . '">' . Html::encode($follower['username']) . '</a>' . '<br>';
            }

            Modal::end();


            $value .= '</a></div>
                                |
                                <div class="subscriber"><a href="#">';

            Modal::begin([
                'size' => 'modal-lg',
                'header' => '<h2>Subscribers</h2>',
                'toggleButton' => [
                    'label' => Yii::t('my page', 'subscribed to {followers} users', [
                        'followers' => $comment->user->countSubscribers()
                    ]),
                    'tag' => 'a',
                    'style' => 'cursor:pointer;'
                ],
//                                            'footer' => 'Bottom window',
            ]);
            foreach ($comment->user->getSubscriptions() as $subscriber) {
                $value .= '<a href="' .
                    Url::to(['/user/profile/view', 'nickname' => $subscriber['id']])
                    . '">' . Html::encode($subscriber['username']) . '</a>' . '<br>';
            }

            Modal::end();


            $value .= '</a></div>
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


       $value .= ' <div class="mainPage pagination">
            <div class="paginationWrap">';

                echo LinkPager::widget([
                        'pagination' => $pagination,
                    ]);
                $value .='
                
            </div>
        </div>';



        return $comments;

    }


}
























