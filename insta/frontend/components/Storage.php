<?php


namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class Storage extends Component implements StorageInterface
{
    private $filename;

    public function saveUploadedFile(UploadedFile $file)
    {
        $path = $this->preparePath($file);

        if ($path && $file->saveAs($path)) {
            return $this->filename;
        }
    }

    public function getFile(string $filename)
    {
        return Yii::$app->params['storageUri'] . $filename;
    }

    protected function preparePath(UploadedFile $file)
    {
        $this->filename = $this->getFileName($file);

        $path = $this->getStoragePath() . $this->filename;

        $path = FileHelper::normalizePath($path);



        if (FileHelper::createDirectory(dirname($path)))
        {
            return $path;

        }
    }

    protected function getFileName(UploadedFile $file)
    {
        $hash = sha1_file($file->tempName);
        $name = substr_replace($hash, '/', 2, 0);
        $name = substr_replace($name, '/', 5, 0);
        return $name . '.' . $file->extension;
    }

    protected function getStoragePath()
    {
        return Yii::getAlias(Yii::$app->params['storagePath']);

    }


}


