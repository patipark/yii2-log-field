<?php

use yii\db\Schema;
use yii\db\Migration;
/**
 * Class m210502_113511_create_table_yii2_log_field
 */
class m210502_113511_create_table_yii2_log_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('yii2_log_field', [
            'id' => $this->primaryKey(),
            'table_name' => $this->string(50),
            'field_name' => $this->string(50),
            'primary_key' => $this->string(50),
            'before_change' => Schema::TYPE_TEXT,
            'after_change' => Schema::TYPE_TEXT,
            'event_time' => Schema::TYPE_DATETIME,
            'event_name' => $this->string(50),
            'model_class' => $this->string(50),
            'user_id' => Schema::TYPE_INTEGER,
            'remote_ip' => $this->string(50),
            'remote_host' => $this->string(50),
            'request_method' => $this->string(50),
            'referrer' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210502_113511_create_table_yii2_log_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210502_113511_create_table_yii2_log_field cannot be reverted.\n";

        return false;
    }
    */
}
