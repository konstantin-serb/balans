<?php

/** @var $this yii\web\View
 * @var $users \frontend\models\User;
 */

use yii\helpers\Url;

$this->title = 'Главная';
?>

<?php foreach ($users as $user):?>
<a href="<?=\yii\helpers\Url::to(['/user/profile/view', 'nickname' => $user->getNickname()])?>"><?=$user->username?></a>
<br>
<hr>
<?php endforeach;

