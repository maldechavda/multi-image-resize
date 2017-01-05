<?php

namespace WeAreBeer\MultiImage;

use File;

class ImageType
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $sizes;

    /**
     * @param string $name
     * @param array  $config
     */
    public function __construct($name, $config)
    {
        $this->name = $name;
        foreach ( $config as $sizeConfigName => $sizeConfig ) {
            $this->sizes[$sizeConfigName] = new ImageSize($sizeConfigName, $sizeConfig);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ImageSize
     */
    public function getSize($name)
    {
        return $this->sizes[$name];
    }

    /**
     * @return array
     */
    public function getSizes()
    {
        return $this->sizes;
    }

    /**
     * @param ImageSize $imageSize
     * @param string $filename
     * @return string
     */
    public function makeFilePath(ImageSize $imageSize, $filename)
    {
        $path = config('multi_image.base') . $this->getName() . '/' . $imageSize->getName();

        if(! File::isDirectory($path)) {
            File::makeDirectory($path, 755, true);
        }

        return  $path. '/' . $filename;
    }
}