<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2018/5/14
 * Time: 10:24
 */
namespace app\models;

use Yii;
use yii\base\Model;

class EntryForm extends Model
{
    public $name;
    public $email;

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
        ];
    }
}
