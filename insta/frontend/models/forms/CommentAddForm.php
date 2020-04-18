<?php


namespace frontend\models\forms;

use yii\base\Model;
use frontend\models\Comment;

class CommentAddForm extends Model
{
    public $comment;
    public $user_id;
    public $post_id;

    private $created_at;
    private $status;

    public function rules()
    {
        return [
            [['comment'], 'required'],
            [['comment'], 'string', 'min' => 5, 'max' => 500],
            [['user_id', 'post_id', 'created_at', 'status'], 'integer'],
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
        if($newComment->save()){
            return true;
        }
        return false;
    }

}