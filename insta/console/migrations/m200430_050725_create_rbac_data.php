<?php

use yii\db\Migration;
use backend\models\User;

/**
 * Class m200430_050725_create_rbac_data
 */
class m200430_050725_create_rbac_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $viewComplaintsListPermission = $auth->createPermission('viewComplaintsList');
        $auth->add($viewComplaintsListPermission);

        $viewPostPermission = $auth->createPermission('viewPost');
        $auth->add($viewPostPermission);

        $deletePostPermission = $auth->createPermission('deletePost');
        $auth->add($deletePostPermission);

        $approvePostPermission = $auth->createPermission('approvePost');
        $auth->add($approvePostPermission);

        $viewUserListPermission = $auth->createPermission('viewUserList');
        $auth->add($viewUserListPermission);

        $viewUserPermission = $auth->createPermission('viewUser');
        $auth->add($viewUserPermission);

        $deleteUserPermission = $auth->createPermission('deleteUser');
        $auth->add($deleteUserPermission);

        $updateUserPermission = $auth->createPermission('updateUser');
        $auth->add($updateUserPermission);


        //define roles

        $moderatorRole = $auth->createRole('moderator');
        $auth->add($moderatorRole);

        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);


        //define roles - permissions relation

        $auth->addChild($moderatorRole, $viewComplaintsListPermission);
        $auth->addChild($moderatorRole, $viewPostPermission);
        $auth->addChild($moderatorRole, $deletePostPermission);
        $auth->addChild($moderatorRole, $approvePostPermission);
        $auth->addChild($moderatorRole, $viewUserPermission);
        $auth->addChild($moderatorRole, $viewUserListPermission);

        $auth->addChild($adminRole, $moderatorRole);
        $auth->addChild($adminRole, $deleteUserPermission);
        $auth->addChild($adminRole, $updateUserPermission);


        //create admin user
        $user = new User([
            'email' => 'admin@kot.com',
            'username' => 'Admin',
            'password_hash' => '$2y$13$dfog2jjX5jdAlSP6Lq15.eGxQfBDAFbQTpkTY5PdA0kO//SeoxDoa',
        ]);
        $user->generateAuthKey();
        $user->save();

        $auth->assign($adminRole, $user->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200430_050725_create_rbac_data cannot be reverted.\n";

        return false;
    }


}
