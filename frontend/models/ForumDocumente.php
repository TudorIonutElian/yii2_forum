<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "forum_documente".
 *
 * @property int $id
 * @property int $postare_id
 * @property string $file_name
 *
 * @property Postare $postare
 */
class ForumDocumente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forum_documente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['postare_id', 'file_name'], 'required'],
            [['postare_id'], 'integer'],
            [['file_name'], 'string', 'max' => 255],
            [['postare_id'], 'exist', 'skipOnError' => true, 'targetClass' => Postare::className(), 'targetAttribute' => ['postare_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'postare_id' => 'Postare ID',
            'file_name' => 'File Name',
        ];
    }

    /**
     * Gets query for [[Postare]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostare()
    {
        return $this->hasOne(Postare::className(), ['id' => 'postare_id']);
    }
}
