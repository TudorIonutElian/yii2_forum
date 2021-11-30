<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class RaspunsSubiectForm extends Model
{
    public $raspuns;
    public $document;
    public $abonament;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['raspuns'], 'required'],
            [['document'], 'file', 'maxFiles' => 5],
            [['raspuns'], 'string', 'min'=> 2, 'max' => '3000'],
            [['abonament'], 'integer', 'min'=> 0, 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'raspuns' => 'Adaugati un raspuns',
            'documente' => 'Adaugati documente',
            'abonament'   => 'Informeaza-ma cand apare un mesaj nou'
        ];
    }
}
