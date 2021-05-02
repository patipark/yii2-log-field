<?php

namespace patipark\yii2logfield;

use Yii;

/**
 * This is the model class for table "yii2_log_field".
 *
 * @property int $id
 * @property string|null $table_name
 * @property string|null $field_name
 * @property string|null $primary_key
 * @property string|null $before_change
 * @property string|null $after_change
 * @property string|null $event_time
 * @property string|null $event_name
 * @property string|null $model_class
 * @property int|null $user_id
 * @property string|null $remote_ip
 * @property string|null $remote_host
 * @property string|null $request_method
 * @property string|null $referrer
 */
class Yii2LogField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yii2_log_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['before_change', 'after_change'], 'string'],
            [['event_time'], 'safe'],
            [['user_id'], 'integer'],
            [['table_name', 'field_name', 'primary_key', 'event_name', 'model_class', 'remote_ip', 'remote_host', 'request_method'], 'string', 'max' => 50],
            [['referrer'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_name' => 'Table Name',
            'field_name' => 'Field Name',
            'primary_key' => 'Primary Key',
            'before_change' => 'Before Change',
            'after_change' => 'After Change',
            'event_time' => 'Event Time',
            'event_name' => 'Event Name',
            'model_class' => 'Model Class',
            'user_id' => 'User ID',
            'remote_ip' => 'Remote Ip',
            'remote_host' => 'Remote Host',
            'request_method' => 'Request Method',
            'referrer' => 'Referrer',
        ];
    }
}
