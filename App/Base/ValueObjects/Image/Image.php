<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects\Image;

use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidPathException;
use AlistairShaw\YewCMS\App\Base\Services\ImageResize\ImageResize;
use AlistairShaw\YewCMS\App\Base\ValueObjects\Number\Integer;
use AlistairShaw\YewCMS\App\Base\ValueObjects\String\String;
use AlistairShaw\YewCMS\App\Base\ValueObjects\Util\Util;
use AlistairShaw\YewCMS\App\Base\ValueObjects\ValueObject;
use App;

class Image implements ValueObject {

    /**
     * @var String
     */
    private $baseFolder;

    /**
     * @var String
     */
    private $fileName;

    /**
     * @var Integer
     */
    private $order;

    /**
     * @var String
     */
    private $caption;

    /**
     * @var String
     */
    private $alt;

    /**
     * @param      $baseFolder
     * @param      $fileName
     * @param null $order
     * @param null $caption
     * @param null $alt
     * @throws InvalidPathException
     */
    public function __construct($baseFolder, $fileName, $order = null, $caption = null, $alt = null)
    {
        $baseFolder = rtrim($baseFolder, '/');

        // check that base folder exists
        if ( ! is_dir(storage_path($baseFolder))) throw new InvalidPathException($baseFolder);

        // check that the file exists
        if ( ! file_exists(storage_path($baseFolder) . '/' . $fileName)) throw new InvalidPathException($baseFolder . '/' . $fileName);

        $this->baseFolder = String::fromNative($baseFolder);
        $this->fileName   = String::fromNative($fileName);
        if ($order) $this->order = Integer::fromNative($order);
        if ($caption) $this->caption = String::fromNative($caption);
        if ($alt) $this->alt = String::fromNative($alt);
    }

    /**
     * @return ValueObject
     */
    public static function fromNative()
    {
        $vars       = func_get_args();
        $baseFolder = $vars[0];
        $fileName   = $vars[1];
        $order      = isset($vars[2]) ? $vars[2] : null;
        $caption    = isset($vars[3]) ? $vars[3] : null;
        $alt        = isset($vars[4]) ? $vars[4] : null;

        return new static($baseFolder, $fileName, $order, $caption, $alt);
    }

    /**
     * @param  Image|ValueObject $image
     * @return bool
     */
    public function sameValueAs(ValueObject $image)
    {
        if (false === Util::classEquals($this, $image))
        {
            return false;
        }

        if ( ! $this->baseFolder->sameValueAs($image->baseFolder)) return false;
        if ( ! $this->fileName->sameValueAs($image->fileName)) return false;
        if ($this->order !== null && ! $this->order->sameValueAs($image->order)) return false;
        if ($this->caption !== null && ! $this->caption->sameValueAs($image->caption)) return false;
        if ($this->alt !== null && ! $this->alt->sameValueAs($image->alt)) return false;

        return true;
    }

    /**
     * @return ValueObject|int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return String
     */
    public function getFilename()
    {
        return $this->fileName;
    }

    /**
     * @return String
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @return String
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Returns a string representation of the object
     * @return string
     */
    public function __toString()
    {
        return route('images', [str_replace('/', '~', $this->baseFolder), $this->fileName]);
    }

    /**
     * @param null $width
     * @param null $height
     * @param bool $crop
     * @param bool $raw
     * @return string
     */
    public function resize($width = null, $height = null, $crop = true, $raw = true)
    {
        $pathToFile  = storage_path($this->baseFolder . '/' . $this->fileName);
        $imageResize = $this->resolveImageResize();

        // check for cached version
        if ((int) $width > 0 || (int) $height > 0)
        {
            $sizeFolder = storage_path($this->baseFolder . '/' . $width . 'x' . $height);
            if ( ! is_dir($sizeFolder))
            {
                mkdir($sizeFolder, 0777, true);
            }
            $pathToSizedFile = $sizeFolder . '/' . $this->fileName;

            // check if cached and sized file already exists, if not create it and return it
            if ( ! file_exists($pathToSizedFile)) return ($raw) ? $imageResize::resize($pathToFile, $width, $height, $crop, $pathToSizedFile) : $pathToSizedFile;

            $pathToFile = $pathToSizedFile;
        }

        if ($raw)
        {
            return $imageResize::getJpg($pathToFile);
        }
        else
        {
            return $pathToFile;
        }
    }

    /**
     * @return ImageResize
     */
    private function resolveImageResize()
    {
        return App::make('AlistairShaw\YewCMS\App\Base\Services\ImageResize\ImageResize');
    }

    /**
     * @param Image $picture
     * @return array
     */
    public static function getPicArray(Image $picture)
    {
        return [
            'url' => (string)$picture,
            'caption' => (string)$picture->getCaption(),
            'alt' => (string)$picture->getAlt()
        ];
    }
}