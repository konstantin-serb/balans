<?php


namespace frontend\modules\articles\models\forms;


use frontend\modules\articles\models\MainComments;
use yii\base\Model;

class MainCommentForm extends Model
{
    public $comment;
    public $userId;
    public $articlesId;

    private $created_at;
    private $status;

    public function rules()
    {
        return [
            [['comment'], 'required'],
            [['comment'], 'string', 'min'=>3, 'max'=>1000],
            [['userId', 'articlesId'], 'integer'],
        ];
    }

    public function save()
    {
        $comment = new MainComments();

        $comment->comment = $this->comment;
        $comment->user_id = intval($this->userId);
        $comment->articles_id = intval($this->articlesId);
        $comment->created_at = time();
        $comment->status = 10;

        if($this->validate() && $comment->save()) {
            $commentReport = new MainCommentReportForm();

            $commentReport->articlesId = $comment->articles_id;
            $commentReport->commentatorId = $comment->user_id;
            $commentReport->comment = $comment->comment;
            $commentReport->status = $comment->status;
            $commentReport->createdAt = $comment->created_at;

            if ($commentReport->save()) {
                return true;
            } else {
                return false;
            }

        }
    }

}