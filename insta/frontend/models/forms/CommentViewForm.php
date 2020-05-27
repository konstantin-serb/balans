<?php


namespace frontend\models\forms;

use frontend\models\Comment;
use frontend\models\Post;
use frontend\models\User;
use Yii;
use yii\helpers\Url;
use yii\helpers\Html;


class CommentViewForm
{
    public $userId;
    public $postId;
    public $currentUser;

    public function __construct()
    {

    }

    public function view()
    {

        $comments = Comment::find()->where(['post_id' => $this->postId])->andWhere('status = 10')->
        orderBy('created_at desc')->all();

        $post = Post::findOne($this->postId);
        $currentUser = $this->currentUser;


        $value = '';
        foreach ($comments as $comment) {
            $value .= '
            
            <div class="comment">
        <div class="commentInfo">
            <div class="userPhoto">
                <a href="' . Url::to(['/user/profile/view',
                    'nickname' => $comment->user->getNickname()]) . '">
                    <img src="' . $comment->user->getPicture() . '" style="text-align: center; display: block; height: 100%; max-width: unset;
    margin: 0 auto;">
                </a>
            </div>
            <div class="dataBlock">
                <div class="name-info">
                    <div class="name"><a class="" ';
            if ($comment->user->id == $currentUser->id) {
                $value .= 'style="color:#FF7B00;"';
            }
            $value .= 'href="' . Url::to(['/user/profile/view',
                    'nickname' => $comment->user->getNickname()]) . '">
                            ' . Html::encode($comment->user->username) . ':</a></div>
                    <div class="info">
                        <div class="posts">' . $comment->user->rating . ' ' . Yii::t('my page', 'posts') . '</div>
                        |
                        <div class="followers">
                        <a href="myModalFollower-'.$comment->user->id.'" style="cursor:pointer;" data-toggle="myModal" data-target="#myModalFollower-'.$comment->user->id.'">'.$comment->user->countFollowers().' '.Yii::t('my page', 'subscribers').'</a>                  
                        <!---------------------------------modalSubscribers--------------------------------------->
                                            <div id="myModalFollower-'.$comment->user->id.'" class="myModal">
                                                <div class="myModal-dialog">
                                                    <div class="myModal-content">
                                                        <div class="myModal-header">
                                                            <h3 class="myModal-title" >
                                                                '.Yii::t('my page' , 'SUBSCRIBED TO').':</h3>
                                                            <a href="#" title="Закрыть" class="modalClose" data-close="myModal">
                                                                &times;
                                                            </a>
                                                        </div>
                                                        <div class="myModal-body" style="padding: 15px 10px;">';
                                                            foreach($comment->user->getFollowers() as $subscriber){

                                                                $value .= '<a href="
                                                            '.Url::to(['/user/profile/view', 'nickname' => $subscriber['id']]).'">
                                                                <div class="UserBlock">
                                                                    <div class="minAvatar" style="padding:0;">
                                                                        <img class="mimiatiura" src="
                                                                    '.\frontend\models\User::getUserPhoto2($subscriber['id']).'"
                                                        style=""
                                                                        >
                                                                    </div>
                                                                    <p style="padding-top:10px;">
                                                                        '.Html::encode($subscriber['username']).'
                                                                    </p>
                                                                </div>';

                                                                if (!$currentUser->isFollowersId($subscriber['id'])) {
                                                                    $value .= '<div class="subscribeButton">
                                                                    <a style="cursor:pointer" data-id=' . $subscriber['id'] . '" class="btnSubscribe btn btn-default">
                                                                        ' . Yii::t('my page', 'Subscribe') . '
                                                                    </a>
                                                                </div>';
                                                                }


                                                            $value .= '</a>
                                                            <hr>';
                                                            }
                                                            $value .= '<br>
                                                            <a href="#" title="Закрыть" class="btn btn-default" data-close="myModal">
                                                                '.Yii::t('my page', 'CANCEL').'
                                                            </a>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--------------------------------endModalSubscribers------------------------------------->
                        
                        </div>                        |
                        
                        <div class="subscriber">
                                    <a href="myModalUser-'.$comment->user->id.'" style="cursor:pointer;" data-toggle="myModal" data-target="#myModalUser-'.$comment->user->id.'">'.Yii::t('my page', 'subscribed to {followers} users', [
                    'followers' => $comment->user->countSubscribers()
                ]).'</a>
                                            <!---------------------------------modalSubscribers--------------------------------------->
                                            <div id="myModalUser-'.$comment->user->id.'" class="myModal">
                                                <div class="myModal-dialog">
                                                    <div class="myModal-content">
                                                        <div class="myModal-header">
                                                            <h3 class="myModal-title" >
                                                                '.Yii::t('my page' , 'SUBSCRIBED TO').':</h3>
                                                            <a href="#" title="Закрыть" class="modalClose" data-close="myModal">
                                                                &times;
                                                            </a>
                                                        </div>
                                                        <div class="myModal-body" style="padding: 15px 10px;">';
                                                            foreach($comment->user->getSubscriptions() as $subscriber){

                                                                $value .= '<a href="
                                                            '.Url::to(['/user/profile/view', 'nickname' => $subscriber['id']]).'">
                                                                <div class="UserBlock">
                                                                    <div class="minAvatar" style="padding:0;">
                                                                        <img class="mimiatiura" src="
                                                                    '.\frontend\models\User::getUserPhoto2($subscriber['id']).'"
                                                        style=""
                                                                        >
                                                                    </div>
                                                                    <p style="padding-top:10px;">
                                                                        '.Html::encode($subscriber['username']).'
                                                                    </p>
                                                                </div>';

                                                                if (!$currentUser->isFollowersId($subscriber['id'])) {
                                                                    $value .= '<div class="subscribeButton">
                                                                    <a style="cursor:pointer" data-id="' . $subscriber['id'] . '" class="btnSubscribe btn btn-default">
                                                                        ' . Yii::t('my page', 'Subscribe') . '
                                                                    </a>
                                                                </div>';
                                                                }


                                                            $value .= '</a>
                                                            <hr>';
                                                            }
                                                            $value .= '<br>
                                                            <a href="#" title="Закрыть" class="btn btn-default" data-close="myModal">
                                                                '.Yii::t('my page', 'CANCEL').'
                                                            </a>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--------------------------------endModalSubscribers------------------------------------->

                                        </div>
                        
                    </div>
                </div>
                <div class="nickname">
                    <b>' . Yii::t('post', 'nickname') . ':</b> ' . Html::encode(($comment->user->nickname) ? $comment->user->nickname : Yii::t('post', 'No nickname')) . '
                </div>
                <div class="userDate">
                    <b>' . Yii::t('post', 'Comment added') . ':</b> ' . Yii::$app->formatter->asDatetime($comment->created_at) . '
                </div>                
            </div>
            <div class="editButtons">';
            if ($comment->user_id == $currentUser->id) {
                $value .= '<a class="deleteCommentButton" data-toggle="myModal" data-target="#myModal-' . $comment->id . '" title="delete comment">&times;</a>
            <div id="myModal-' . $comment->id . '" class="myModal">
                                    <div class="myModal-dialog">
                                        <div class="myModal-content">
                                            <div class="myModal-header">
                                                <h3 class="myModal-title" style="color:#555;">Удаление комментария</h3>
                                                <a href="#" title="Закрыть" class="modalClose" data-close="myModal">&times;</a>
                                            </div>
                                            <div class="myModal-body">
                                                <p style="color:#666;">Вы действительно хотите удалить этот комментарий:</p>
                                                <br>
                                                ' . $comment->comment . '
                                                <br><br>
                                                <a href="#" id="submitButton" data-commentAuthor="' . $comment->user_id . '" data-userId="' . $currentUser->id . '" post-id="' . $post->id . '" data-id="' . $comment->id . '" class="btn btn-danger" data-close="myModal">Да</a>
                                                <a href="#" title="Закрыть" class="btn btn-info" data-close="myModal">Нет, я передумал</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            ';
            } elseif ($post->user_id == $currentUser->getId()) {
                $value .= '<a class="deleteCommentButton" data-toggle="myModal" data-target="#myModal-' . $comment->id . '" title="delete comment">&times;</a>
            <div id="myModal-' . $comment->id . '" class="myModal">
                                    <div class="myModal-dialog">
                                        <div class="myModal-content">
                                            <div class="myModal-header">
                                                <h3 class="myModal-title" style="color:#555;">Удаление комментария</h3>
                                                <a href="#" title="Закрыть" class="modalClose" data-close="myModal">&times;</a>
                                            </div>
                                            <div class="myModal-body">
                                                <p style="color:#666;">Вы действительно хотите удалить этот комментарий:</p>
                                                <br>
                                                ' . $comment->comment . '
                                                <br><br>
                                                <a href="#" id="submitButton" data-commentAuthor="' . $comment->user_id . '" data-userId="' . $currentUser->id . '" post-id="' . $post->id . '" data-id="' . $comment->id . '" class="btn btn-danger" data-close="myModal">Да</a>
                                                <a href="#" title="Закрыть" class="btn btn-info" data-close="myModal">Нет, я передумал</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            ';
            }

            $value .= '</div>
        </div>
        
        <div class="commentText">
            <p ';

            if ($comment->user->id == $post->user->id) {
                $value .= 'style="color:#FF7B00;"';
            }

            if ($comment->user->id == $currentUser->id) {
                $value .= 'style="color:red; font-weight:bold;"';
            }
            $value .= '>
                <i>
                    ' . Html::encode($comment->comment) . '</i>
            </p>
            <hr>
        </div>
        ';
        }


        return $value;

    }

}