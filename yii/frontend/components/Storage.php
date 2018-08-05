<?php

namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * File storage compoment
 *
 * @author admin
 */
class Storage extends Component implements StorageInterface
{

    private $fileName;

    /**
     * Save given UploadedFile instance to disk
     * @param UploadedFile $file
     * @return string|null
     */
    public function saveUploadedFile(UploadedFile $file)
    {
      $path = $this->preparePath($file);
        if ($path && $file->saveAs($path)) {
        // масштабируем изображение до размера 800х600 пикселей, и пересохраняем его в темп
//           echo $patchToResize = $this->getFile($path);
            if ($this->resizeAndCropImage($path, $path, 800, 600)) {
                return $this->fileName;
            }
        }
    }

    /**
     * Prepare path to save uploaded file
     * @param UploadedFile $file
     * @return string|null
     */
    protected function preparePath(UploadedFile $file)
    {
        $this->fileName = $this->getFileName($file);
        //     0c/a9/277f91e40054767f69afeb0426711ca0fddd.jpg

        $path = $this->getStoragePath() . $this->fileName;
        //     /var/www/project/frontend/web/uploads/0c/a9/277f91e40054767f69afeb0426711ca0fddd.jpg

        $path = FileHelper::normalizePath($path);
        if (FileHelper::createDirectory(dirname($path))) {
            return $path;
        }
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    protected function getFilename(UploadedFile $file)
    {
        // $file->tempname   -   /tmp/qio93kf

        $hash = sha1_file($file->tempName); // 0ca9277f91e40054767f69afeb0426711ca0fddd

        $name = substr_replace($hash, '/', 2, 0);  // 0c/a9277f91e40054767f69afeb0426711ca0fddd
        $name = substr_replace($name, '/', 5, 0);  // 0c/a9/277f91e40054767f69afeb0426711ca0fddd
        $name = substr_replace($name, '/', 8, 0);  // 0c/a9/27/7f91e40054767f69afeb0426711ca0fddd
        return $name . '.' . $file->extension;  // 0c/a9/27/7f91e40054767f69afeb0426711ca0fddd.jpg
    }

    /**
     * @return string
     */
    protected function getStoragePath()
    {
        return Yii::getAlias(Yii::$app->params['storagePath']);
    }

    /**
     *
     * @param string $filename
     * @return string
     */
    public function getFile(string $filename)
    {
        return Yii::$app->params['storageUri'] . $filename;
    }

    protected function resizeAndCropImage($path, $save, $width, $height)
    {
        $info = getimagesize($path); //получаем размеры картинки и ее тип
        $size = array($info[0], $info[1]); //закидываем размеры в массив

        //В зависимости от расширения картинки вызываем соответствующую функцию
        if ($info['mime'] == 'image/png') {
            $src = imagecreatefrompng($path); //создаём новое изображение из файла
        } else if ($info['mime'] == 'image/jpeg') {
            $src = imagecreatefromjpeg($path);
        } else if ($info['mime'] == 'image/gif') {
            $src = imagecreatefromgif($path);
        } else {
            return false;
        }

        $thumb = imagecreatetruecolor($width, $height); //возвращает идентификатор изображения, представляющий черное изображение заданного размера

        $scale0 = $size[0] / $width;
        $scale1 = $size[1] / $height;
        $scale = min($scale0, $scale1);

        $new_size = [$size[0] / $scale, $size[1] / $scale];

        //Ищем координаты начальной точки обрезки
        $x_start = ($new_size[0] > $width) ? ($new_size[0] - $width) / 2 : 0;
        $y_start = ($new_size[1] > $height) ? ($new_size[1] - $height) / 2 : 0;
        //$src_pos = [$x_start, $y_start];
        $src_pos = [$x_start * $scale, $y_start * $scale];

        imagecopyresampled($thumb, $src, 0, 0, $src_pos[0], $src_pos[1], $width, $height, $width * $scale, $height * $scale);

        if ($save == false) {
            return imagejpeg($thumb, null, 75); //Выводит JPEG/PNG/GIF изображение
        } else {
            return imagejpeg($thumb, $save);//Сохраняет JPEG/PNG/GIF изображение
        }
    }


}