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
            ActiveRecord::EVENT_AFTER_INSERT => 'log',
            ActiveRecord::EVENT_AFTER_UPDATE => 'log',
        ];
    }

    public function log($event)
    {

        $beforeChange = $event->sender->oldAttributes;  // attribute ทีั้งหมดก่อนการเปลี่ยนแปลง
        $afterChange = $event->sender->attributes;      // attribute ทีั้งหมดหลังการเปลี่ยนแปลง
        if (property_exists($event->sender::className(), 'ignoreLogAttributes')  && is_array($event->sender->ignoreLogAttributes)) {
            foreach ($event->sender->ignoreLogAttributes as $attribute) {
                // remove attribute ที่ทำการ ignore ออกจาก array log
                unset($beforeChange[$attribute]);
                unset($afterChange[$attribute]);
            }
        }
        foreach ($beforeChange as $key) :
            // $before = (string)$event->sender->oldAttributes[$key];
            // $after = (string)$event->sender->$key;
            if ($event->sender->oldAttributes[$key] != $event->sender->$key) {
                $model = new Yii2LogField();
                $model->table_name = $event->sender->tableName();
                $model->field_name = $key;
                $model->primary_key = implode(",", $event->sender->getPrimaryKey(true));
                $model->before_change = (string)$event->sender->oldAttributes[$key];
                $model->after_change = (string)$event->sender->$key;
                $model->event_time = new Expression('NOW()');
                $model->event_name = $event->name;
                $model->model_class = $event->sender::className();
                $model->user_id = Yii::$app->user->identity->id ?? null;
                $model->referrer = Yii::$app->request->referrer;
                $model->remote_ip = Yii::$app->request->remoteIP;
                $model->remote_host = Yii::$app->request->remoteHost;
                $model->request_method = Yii::$app->request->method;
                $model->save();
            }
        endforeach;
    }
}
