<?php

namespace patipark\yii2logfield;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class LogBehavior extends Behavior
{
    /**
     * กำหนด event ให้ไปที่ method
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT    => 'log',
            ActiveRecord::EVENT_BEFORE_UPDATE   => 'log',
        ];
    }

    public function log($event)
    {
        $sender = $event->sender;
        // echo 'before<br>';
        // \yii\helpers\VarDumper::dump($sender->oldAttributes, $depth = 10, $highlight = true);
        // echo '<br>after<br>';
        // \yii\helpers\VarDumper::dump($sender->attributes, $depth = 10, $highlight = true);
        // echo '<br>';
        foreach ($sender->attributes as $key => $val) :
            // \yii\helpers\VarDumper::dump($key, $depth = 10, $highlight = true);
            // \yii\helpers\VarDumper::dump($sender->oldAttributes[$key], $depth = 10, $highlight = true);
            // \yii\helpers\VarDumper::dump($val, $depth = 10, $highlight = true);
            // // exit();
            // echo '<br>';
            if ($sender->oldAttributes[$key] != $val) {
                $model = new Yii2LogField();
                $model->table_name = $sender->tableName();
                $model->field_name = $key;
                $model->primary_key = implode(",", $sender->getPrimaryKey(true));
                $model->before_change = (string)$sender->oldAttributes[$key];
                $model->after_change = (string)$val;
                $model->event_time = new Expression('NOW()');
                $model->event_name = $event->name;
                $model->model_class = $sender::className();
                $model->user_id = Yii::$app->user->identity->id ?? null;
                $model->referrer = Yii::$app->request->referrer;
                $model->remote_ip = Yii::$app->request->remoteIP;
                $model->remote_host = Yii::$app->request->remoteHost;
                $model->request_method = Yii::$app->request->method;
                if (!$model->save()) {
                    \yii\helpers\VarDumper::dump($model->getErors(), $depth = 10, $highlight = true);
                    // exit();
                }
            }
        endforeach;
        // exit();
    }
}
