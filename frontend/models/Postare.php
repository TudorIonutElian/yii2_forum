<?php

namespace app\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "postare".
 *
 * @property int $id
 * @property int $subiect_id
 * @property string $continut
 * @property string $documente
 * @property string $data_creare
 * @property int $creat_de
 * @property int $position
 *
 * @property User $creatDe
 * @property Subiect $subiect
 */
class Postare extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'postare';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subiect_id', 'continut', 'creat_de'], 'required'],
            [['subiect_id', 'creat_de'], 'integer'],
            [['continut'], 'string'],
            [['data_creare'], 'safe'],
            [['subiect_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subiect::className(), 'targetAttribute' => ['subiect_id' => 'id']],
            [['creat_de'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creat_de' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subiect_id' => 'Subiect ID',
            'continut' => 'Continut',
            'documente' => 'Documente',
            'data_creare' => 'Data Creare',
            'creat_de' => 'Creat De',
        ];
    }

    /**
     * Gets query for [[CreatDe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'creat_de']);
    }

    /**
     * Gets query for [[Subiect]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubiect()
    {
        return $this->hasOne(Subiect::className(), ['id' => 'subiect_id']);
    }
}
