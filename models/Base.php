<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.06.15
 * Time: 5:30
 */

namespace app\models;
use Yii;
use yii\base\Model;

class Base extends Model
{
    public function getLastErrorMessage(){
        $errors = $this->errors;
        foreach($errors as $error=>$key){
            return $error;
        }
    }
} 