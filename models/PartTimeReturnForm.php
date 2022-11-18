<?php

namespace app\models;
use Yii;
use yii\base\Model;

class PartTimeReturnForm extends Model {
    public $return_amount;

    public function rules()
    {
        return [
            [['return_amount'], 'safe'],
        ];
    }


    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param TakenBooks $model the target email address
     * @return bool whether the model passes validation
     */

    public function partTimeReturn($model) {

    }
}