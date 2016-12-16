<?php

namespace WeAreBeer\MultiImage;

class ImageSize
{
    /**
     * Name of this image size configuration
     *
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * Type of scaling
     * e.g. 'fit'|'fill'
     *
     * @var string
     */
    protected $scaleType;

    /**
     * @param string $name
     * @param array $config
     */
    public function __construct($name, $config)
    {
        $this->name = $name;
        $this->width = $config['width'];
        $this->height = $config['height'];
        $this->scaleType = $config['scale'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return string
     */
    public function getScaleType()
    {
        return $this->scaleType;
    }
}