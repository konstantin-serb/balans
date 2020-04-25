<?php


namespace frontend\models\forms;

use frontend\models\Post;
use yii\base\Model;
use frontend\models\Comment;

class CommentAddForm extends Model
{
    public $comment;
    public $user_id;
    public $post_id;
    public $postAuthorId;

    private $created_at;
    private $status;

    public function rules()
    {
        return [
            [['comment'], 'required'],
            [['comment'], 'string', 'min' => 5, 'max' => 500],
            [['user_id', 'post_id'], 'integer'],
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

}