<?php

namespace app\models;

use Codeception\Step\Skip;
use Yii;
use yii\base\Model;

class ImagenForm extends Model
{
    public $imagen;
 
    public function rules()
    {
        return [
            [['imagen'], 'image', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg']]
        ];
    }

    public function upload($id)
    {
     
        if ($this->validate()) {
            $id2=Feeds::find()->max('[[id]]');
           
            $filename = $id2 . 'feed' . '.' . $this->imagen->extension;
           
            $origen = Yii::getAlias('@uploads/' . $filename);
            $destino = Yii::getAlias('@img/' . $filename);
            $this->imagen->saveAs($origen);
            rename($origen, $destino);
            return true;
        } else {
            return false;
        }
    }
    public function upload2($id)
    {
        if ($this->validate()) {
            $filename = $id . '.' . $this->imagen->extension;
            $origen = Yii::getAlias('@uploads/' . $filename);
            $destino = Yii::getAlias('@img/' . $filename);
            $this->imagen->saveAs($origen);
            rename($origen, $destino);
            return true;
        } else {
            return false;
        }
    }
}
