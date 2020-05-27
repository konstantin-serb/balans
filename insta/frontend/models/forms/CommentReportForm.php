<?php


namespace frontend\models\forms;


use yii\base\Model;
use frontend\models\CommentReport;

class CommentReportForm extends Model
{
    public $recipient;
    public $postId;
    public $commentator;
    public $comment;
    public $created_at;
    public $comment_id;


    public function save()
    {
        $report = new CommentReport();
        $report->post_id = $this->postId;
        $report->recipient = $this->recipient;
        $report->commentator = $this->commentator;
        $report->comment = $this->comment;
        $report->comment_id = $this->comment_id;
        $report->created_at = $this->created_at;
        $report->status = 10;
        if($report->save()) {
            return true;
        }
        return false;
    }

}


