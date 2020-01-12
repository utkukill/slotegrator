<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wins".
 *
 * @property int|null $id
 * @property int|null $user_id
 * @property int|null $win_type
 * @property int|null $win_balance_int
 * @property string|null $win_balance_var
 * @property int|null $status
 */
class Wins extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wins';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'win_type', 'win_balance_int', 'status'], 'integer'],
            [['win_balance_var'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'win_type' => 'Win Type',
            'win_balance_int' => 'Win Balance Int',
            'win_balance_var' => 'Win Balance Var',
            'status' => 'Status',
        ];
    }
}
