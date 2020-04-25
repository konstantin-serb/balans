<?php


namespace frontend\models\forms;


use Yii;
use yii\base\Model;
use frontend\models\CommentReport;
use yii\helpers\Url;

class MessagesReportView extends Model
{
    public $userId;


    public function view()
    {
        $report = CommentReport::find()->where(['recipient' => $this->userId])->orderBy('created_at desc')->all();

        $value = "";

        if ($report) {
            $value = '           
            <div class="wrap">
                <h2>Новые комментарии к вашим постам:</h2>
                <br>
                <table class="table table-condensed">
                    <tr>
                        <th>Post photo:</th>
                        <th>Message</th>
                        <th>date</th>
                        <th>action</th>
                    </tr>';
                    foreach ($report as $oneMessage) {
                        $value .= '                        
                        <tr>
                            <td><a href="'.Url::to(['/post/default/view/', 'id' => $oneMessage->post_id, '#' => 'photoView']).'">
                                    <img src="'.$oneMessage->getPostImage($oneMessage->post_id).'" class="" style="width:100px;">
                                </a>
                            </td>
                            <td>Пользователь <a href="'.Url::to(['/user/profile/view/', 'nickname' => $oneMessage->commentator]).'" style="color: #FF5F00; cursor: pointer;">
                                    <b>'.$oneMessage->getUserName($oneMessage->commentator).'</b>
                                </a>
                                добавил комментарий:
                                <a href="'.Url::to(['/post/default/view/', 'id' => $oneMessage->post_id, '#' => 'comments']).'"
                                 style="color: #FF5F00; cursor: pointer;">
                                    "<b>'.$oneMessage->comment.'</b>"
                                </a>
                            </td>
                            <td>'.Yii::$app->formatter->asDatetime($oneMessage->created_at).'</td>
                            <td><a class="dell" id="btn-del" data-DelId="'.$oneMessage->id.'"
                             style="color: red; cursor: pointer;">
                                    <span class="deleteMessage">&times;</span>
                                </a>
                                <a class="approve" id="btn-approve" data-id="'.$oneMessage->id.'"
                                 style="color: #FF5F00; cursor: pointer;">
                                    <!--span class="glyphicon glyphicon-ok"></span></td-->
                            </a>
                        </tr>
                        
                        ';
                    }
                    $value .= '
                </table>
            </div>
            ';

        } else {
            $value = '<h2>Нет новых комментариев</h2>';
        }


        return $value;
    }

}