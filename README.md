# yii2-log-field
ใช้ในการเก็บ Log ของ Active Record Model  โดยเก็บเฉพาะฟิวดที่เปลียนแปลงเท่านั้น และแปลงข้อมูลเป็น string ทั้งหมดก่อนเก็บลง Log

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer require patipark/yii2-log-field "dev-master"
```

or add

```
    "require": {
        ......
        "patipark/yii2-log-field": "dev-master"
        ......
    }
```

to the require section of your `composer.json` file.

Apply migrations เสร็จแล้วจะสร้างตารางชื่อว่า yii2_log เพื่อเก็บ Log
 
 ```
yii migrate/up --migrationPath=@vendor/patipark/yii2-log-field/migrations
```

Configure the behavior
```php
class YourModel extends \yii\db\ActiveRecord
{
    public $ignoreLogAttributes = ['created_by', 'created_at', 'updated_by', 'updated_at'];
    
    public function behaviors()
    {
        return [
            \patipark\yii2logfield\LogBehavior::class,
            ......
            ......
        ];
    }
```

### attributes ที่ไม่ต้องการเก็บ log  
ให้ประกาศตัวแปร ไว้ใน model ขื่อว่า **$ignoreLogAttributes**  แต่ถ้าไม่ได้ประกาศไว้ จะเก็บ log ทุกฟิวด์ 

```php
public $ignoreLogAttributes = ['created_by', 'created_at', 'updated_by', 'updated_at'];
```


## การทำงาน
ข้อมูลจะเก็บในตารางชื่อ yii2_log และเก็บข้อมูลของแต่ละฟิวด์ไว้ 1 record ต่อการเปลียนแปลง 1 ฟิวด์ โดยเก็บค่า before_change,after_change,table_name,field_name,primary_key  etc............
