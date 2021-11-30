<?php

namespace app\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "categorie".
 *
 * @property int $id
 * @property int $forum_id
 * @property string $titlu
 * @property string $descriere
 * @property string $data_creare
 * @property int $creat_de
 *
 * @property User $creatDe
 * @property Forum $forum
 * @property Subiect[] $subiects
 */
class Categorie extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categorie';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['forum_id', 'titlu', 'descriere', 'creat_de'], 'required'],
            [['forum_id', 'creat_de'], 'integer'],
            [['data_creare'], 'safe'],
            [['titlu', 'descriere'], 'string', 'max' => 255],
            [['forum_id'], 'exist', 'skipOnError' => true, 'targetClass' => Forum::className(), 'targetAttribute' => ['forum_id' => 'id']],
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
            'forum_id' => 'Forum ID',
            'titlu' => 'Titlu',
            'descriere' => 'Descriere',
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
     * Gets query for [[Forum]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForum()
    {
        return $this->hasOne(Forum::className(), ['id' => 'forum_id']);
    }

    /**
     * Gets query for [[Subiects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubiects()
    {
        return $this->hasMany(Subiect::className(), ['categorie_id' => 'id']);
    }
}
