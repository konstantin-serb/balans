<?php


namespace common\components;

use Yii;
use yii\base\Component;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use common\components\Resize;

class StoragePostPicture extends Component implements StorageInterface
{
    private $filename;

    public function saveUploadedFile(UploadedFile $file, $params)
    {
        $path = $this->preparePath($file);

        $resize = new Resize($file->tempName);
        $size = getimagesize($file->tempName);

        $width = $params['width'];
        $height = $params['height'];
        $method = $params['method'];

        $resize->resize($width,$height, $method);

        if ($path) {
            if($size[0] > $width || $size[1] > $height){
                $resize->save($path, $params['quality']);
            } else {
                $file->saveAs($path);
            }
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
//        $hash = sha1_file($file->tempName);
        $hash = md5(uniqid($file->tempName));

        $name = substr_replace($hash, '/', 2, 0);
        $name = substr_replace($name, '/', 5, 0);

        return $name . '.' . $file->extension;
    }

    protected function getStoragePath()
    {
        return Yii::getAlias(Yii::$app->params['storagePath']);

    }

}


