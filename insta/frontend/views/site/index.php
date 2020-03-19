<?php

/** @var $this yii\web\View
 * @var $users \frontend\models\User;
 */

use yii\helpers\Url;

$this->title = 'Главная';
?>

<div class="row">
    <?php foreach ($users as $user):?>
<div class="col-md-3" style="padding:25px;">
    <a href="<?=\yii\helpers\Url::to(['/user/profile/view', 'nickname' => $user->getNickname()])?>">
        <img id="profile-picture" src="<?= $user->getPicture() ?>" style="width: 100%;"><br>
        <?=$user->username?></a>

</div>

<?php endforeach;?>
</div>

