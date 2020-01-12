<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bank".
 *
 * @property int|null $id
 * @property int|null $type
 * @property string|null $val
 */
class Bank extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bank';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['val'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'val' => 'Val',
        ];
    }
}
