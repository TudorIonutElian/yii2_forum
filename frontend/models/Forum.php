<?php

namespace app\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "forum".
 *
 * @property int $id
 * @property string $titlu
 * @property string $descriere
 * @property string $data_creare
 * @property int $creat_de
 *
 * @property Categorie[] $categories
 * @property User $creatDe
 */
class Forum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titlu', 'descriere', 'creat_de'], 'required'],
            [['id', 'creat_de'], 'integer'],
            [['data_creare'], 'safe'],
            [['titlu', 'descriere'], 'string', 'max' => 255],
            [['id'], 'unique'],
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
            'titlu' => 'Titlu',
            'descriere' => 'Descriere',
            'data_creare' => 'Data Creare',
            'creat_de' => 'Creat De',
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categorie::className(), ['forum_id' => 'id']);
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
}
