<?php

namespace app\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "subiect".
 *
 * @property int $id
 * @property int $categorie_id
 * @property string $titlu
 * @property string $descriere
 * @property string $data_creare
 * @property int $creat_de
 *
 * @property Categorie $categorie
 * @property User $user
 * @property Postare[] $postares
 */
class Subiect extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subiect';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categorie_id', 'titlu', 'descriere', 'creat_de'], 'required'],
            [['categorie_id', 'creat_de'], 'integer'],
            [['data_creare'], 'safe'],
            [['titlu', 'descriere'], 'string', 'max' => 255],
            [['categorie_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorie::className(), 'targetAttribute' => ['categorie_id' => 'id']],
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
            'categorie_id' => 'Categorie ID',
            'titlu' => 'Titlu',
            'descriere' => 'Descriere',
            'data_creare' => 'Data Creare',
            'creat_de' => 'Creat De',
        ];
    }

    /**
     * Gets query for [[Categorie]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategorie()
    {
        return $this->hasOne(Categorie::className(), ['id' => 'categorie_id']);
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
     * Gets query for [[Postares]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostares()
    {
        return $this->hasMany(Postare::className(), ['subiect_id' => 'id']);
    }
}
