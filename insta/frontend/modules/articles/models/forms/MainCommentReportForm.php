<?php


namespace frontend\modules\articles\models\forms;


use frontend\modules\articles\models\MainCommentsReport;
use yii\base\Model;

class MainCommentReportForm extends Model
{

    public $articlesId;
    public $commentatorId;
    public $status;
    public $comment;
    public $createdAt;


    public function save()
    {
        $report = new MainCommentsReport();

        $report->articles_id = $this->articlesId;
        $report->commentator = $this->commentatorId;
        $report->status = $this->status;
        $report->comment = $this->comment;
        $report->created_at = $this->createdAt;

        if ($report->save()) {
            return true;
        } else {
            return false;
        }
    }


}