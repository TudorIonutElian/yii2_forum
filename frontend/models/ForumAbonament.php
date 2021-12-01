<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "forum_abonament".
 *
 * @property int $id
 * @property int $ab_subiect_id
 * @property string $ab_email
 *
 * @property Subiect $abSubiect
 */
class ForumAbonament extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forum_abonament';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ab_subiect_id', 'ab_email'], 'required'],
            [['ab_subiect_id'], 'integer'],
            [['ab_email'], 'string', 'max' => 255],
            [['ab_subiect_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subiect::className(), 'targetAttribute' => ['ab_subiect_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ab_subiect_id' => 'Ab Subiect ID',
            'ab_email' => 'Ab Email',
        ];
    }

    /**
     * Gets query for [[AbSubiect]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubiect()
    {
        return $this->hasOne(Subiect::className(), ['id' => 'ab_subiect_id']);
    }
}
