<?php

use yii\db\Migration;

/**
 * Class m230726_163352_create_rbac_tables
 */
class m230726_163352_create_rbac_tables extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Create roles
        $guestRole = $auth->createRole('guest');
        $userRole = $auth->createRole('user');
        $adminRole = $auth->createRole('administrator');

        // Add roles to the authManager
        $auth->add($guestRole);
        $auth->add($userRole);
        $auth->add($adminRole);
    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        // Remove roles from the authManager
        $guestRole = $auth->getRole('guest');
        $userRole = $auth->getRole('user');
        $adminRole = $auth->getRole('administrator');

        $auth->remove($guestRole);
        $auth->remove($userRole);
        $auth->remove($adminRole);
    }
}
