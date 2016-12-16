<?php

namespace WeAreBeer\MultiImage;

class ImageTypes
{
    /**
     * @var array
     */
    protected $types = [];

    /**
     * @param array $config
     */
    public function __construct($config)
    {
        foreach ( $config as $sizeConfigName => $sizeConfig ) {
            $this->types[$sizeConfigName] = new ImageType($sizeConfigName, $sizeConfig);
        }
    }

    /**
     * @param string $name
     * @return ImageType
     */
    public function getType($name)
    {
        return $this->types[$name];
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        return $this->types;
    }
}