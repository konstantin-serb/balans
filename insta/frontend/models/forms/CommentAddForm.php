<?php


namespace frontend\models\forms;

use frontend\models\CommentReport;
use frontend\models\Post;
use yii\base\Model;
use frontend\models\Comment;

class CommentAddForm extends Model
{
    public $comment;
    public $user_id;
    public $post_id;
    public $postAuthorId;
    public $commentId;
    public $commentAuthorId;

    private $created_at;
    private $status;

    public function rules()
    {
        return [
            [['comment'], 'required'],
            [['comment'], 'string', 'min' => 3, 'max' => 500],
            [['user_id', 'post_id'], 'integer'],
            [['commentId', 'commentAuthorId'], 'integer'],
        ];
    }

    public function save()
    {
        $newComment = new Comment();
        $newComment->user_id = intval($this->user_id);
        $newComment->post_id = intval($this->post_id);
        $newComment->comment = $this->comment;
        $newComment->created_at = time();
        $newComment->status = 10;
        if($this->validate() && $newComment->save()){
            if($newComment->user_id != $this->postAuthorId){

                $report = new CommentReportForm();
                $currentComment = Comment::find()->where(['created_at' => $newComment->created_at])->one();
                $report->comment_id = $currentComment->id;
                $report->postId = $newComment->post_id;
                $report->recipient = $this->postAuthorId;
                $report->commentator = $newComment->user_id;
                $report->comment = $newComment->comment;
                $report->created_at = $newComment->created_at;
                $report->save();
            }
            return true;
        }
        return false;
    }

    public function delete()
    {
        $comment = Comment::findOne($this->commentId);
        if ($comment->delete()){
            $report = CommentReport::find()->where(['comment_id' => $this->commentId])->one();
            if (!empty($report)) {
                $report->delete();
                return true;
            }
            return true;
        }
        return false;
    }

}