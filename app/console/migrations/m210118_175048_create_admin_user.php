<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m210118_175048_create_admin_user
 */
class m210118_175048_create_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
          $transaction = $this->getDb()->beginTransaction();
          $user = \Yii::createObject([
                'class'    => User::class,
                'scenario' => 'create',
                'email'    => 'admin@example.com',
                'username' => 'admin',
                'password' => 'admin',
            ]);
          $user->generateAuthKey();
          if (!$user->insert(false)) {
              $transaction->rollBack();
              return false;
          }
          $transaction->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $transaction = $this->getDb()->beginTransaction();
        $user = User::findOne([
            'username' => 'admin',
        ]);

        if (!$user->delete()) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210118_175048_create_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
