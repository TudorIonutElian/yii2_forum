<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "forum_vizualizari".
 *
 * @property int $id
 * @property int|null $forum_id
 * @property int|null $categorie_id
 * @property int|null $subiect_id
 * @property string $ip
 *
 * @property Categorie $categorie
 * @property Forum $forum
 * @property Subiect $subiect
 */
class ForumVizualizari extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forum_vizualizari';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['forum_id', 'categorie_id', 'subiect_id'], 'integer'],
            [['ip'], 'required'],
            [['ip'], 'string', 'max' => 15],
            [['categorie_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorie::className(), 'targetAttribute' => ['categorie_id' => 'id']],
            [['forum_id'], 'exist', 'skipOnError' => true, 'targetClass' => Forum::className(), 'targetAttribute' => ['forum_id' => 'id']],
            [['subiect_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subiect::className(), 'targetAttribute' => ['subiect_id' => 'id']],
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
            'categorie_id' => 'Categorie ID',
            'subiect_id' => 'Subiect ID',
            'ip' => 'Ip',
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
     * Gets query for [[Forum]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForum()
    {
        return $this->hasOne(Forum::className(), ['id' => 'forum_id']);
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
