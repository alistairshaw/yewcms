<?php namespace AlistairShaw\YewCMS\App\Base\Services\ImageResize;

use Gregwar\Image\Image;

class GregwarImageResize implements ImageResize {

    /**
     * @param string $path
     * @param int    $width
     * @param int    $height
     * @param bool   $crop
     * @param string $saveTo
     * @return ImageResize
     * @throws \Exception
     */
    public static function resize($path, $width = null, $height = null, $crop = true, $saveTo = '')
    {
        $image = Image::open($path);

        if ($width && $height && $crop)
        {
            $image = $image->zoomCrop($width, $height);
        }
        else
        {
            $image = $image->resize($width, $height);
        }

        if ($saveTo !== '') $image->save($saveTo);

        return $image->get('jpg', 100);
    }

    /**
     * @param $pathToFile
     * @return ImageResize
     */
    public static function getJpg($pathToFile)
    {
        return Image::open($pathToFile)->get('jpg', 100);
    }
}