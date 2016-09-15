<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
	public $mess;
	public $subj;

    public function rules()
    {
        return [
            //[['imageFile'], 'file', 'skipOnEmpty' => false],
        ];
    }

    public function upload()
    {
        // if ($this->validate()) {
            // $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            // return true;
        // } else {
            // return false;
        // }
    }
}