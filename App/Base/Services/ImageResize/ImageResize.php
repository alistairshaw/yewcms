<?php namespace AlistairShaw\YewCMS\App\Base\Services\ImageResize;

interface ImageResize {

    /**
     * @param string $path
     * @param int    $width
     * @param int    $height
     * @param bool   $crop
     * @param string $saveTo
     * @return ImageResize
     */
    public static function resize($path, $width, $height, $crop = true, $saveTo = '');

    /**
     * @param $pathToFile
     * @return ImageResize
     */
    public static function getJpg($pathToFile);

}