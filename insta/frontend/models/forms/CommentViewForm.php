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
                    'nickname' => $comment->user->getNickname()]) .'">
                    <img src="' . $comment->user->getPicture() . '" style="text-align: center; display: block; height: 100%; max-width: unset;
    margin: 0 auto;">
                </a>
            </div>
            <div class="dataBlock">
                <div class="name-info">
                    <div class="name"><a class="" ';
            if ($comment->user->id == $post->user->id) {
                $value .= 'style="color:#FF7B00;"';
            }
            $value .= 'href="'.Url::to(['/user/profile/view',
                    'nickname' => $comment->user->getNickname()]).'">
                            '.Html::encode($comment->user->username).':</a></div>
                    <div class="info">
                        <div class="posts">'.$comment->user->rating.' '.Yii::t('my page', 'posts').'</div>
                        <div class="followers"><a href="#">'.$comment->user->countFollowers() .' '.Yii::t('my page', 'subscribers').' </a></div>
                        <div class="subscriber"><a href="#"> '.
                Yii::t('my page', 'subscribed to {followers} users',[
                        'followers' => $comment->user->countSubscribers()
                    ])
                .' </a></div>
                        
                    </div>
                </div>
                <div class="nickname">
                    <b>'.Yii::t('post', 'nickname').':</b> '.Html::encode(($comment->user->nickname) ? $comment->user->nickname : Yii::t('post', 'No nickname')).'
                </div>
                <div class="userDate">
                    <b>'.Yii::t('post', 'Comment added').':</b> '.Yii::$app->formatter->asDatetime($comment->created_at).'
                </div>
            </div>
        </div>
        
        <div class="commentText">
            <p ';

            if($comment->user->id == $post->user->id){
                $value .= 'style="color:#FF7B00;"';
            }

                if($comment->user->id == $currentUser->id){
                    $value .= 'style="color:red; font-weight:bold;"';
                }
            $value .='>
                <i>
                    '.Html::encode($comment->comment).'</i>
            </p>
            <hr>
        </div>
        ';
        }

//        $value .= '
//            <div class="pagination">
//                <div class="paginationWrap">
//                    <a href="#" class="yellow">
//                        <div class="box left">&lt;</div>
//                    </a>
//                    <a href="#" class="yellow">
//                        <div class="box pageNumber">1</div>
//                    </a>
//                    <a href="#" class="yellow">
//                        <div class="box active pageNumber">2</div>
//                    </a>
//                    <a href="#" class="yellow">
//                        <div class="box pageNumber">3</div>
//                    </a>
//                    <a href="#" class="yellow">
//                        <div class="box right">&gt;</div>
//                    </a>
//                </div>
//            </div>
//                ';

        return $value;

    }

}