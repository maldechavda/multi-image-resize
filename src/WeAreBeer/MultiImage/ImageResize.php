<?php

namespace WeAreBeer\MultiImage;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Image;

class ImageResize
{
    /**
     * @var ImageManager
     */
    protected $manager;

    /**
     * @var ImageTypes
     */
    protected $types;

    /**
     * @var string
     */
    protected $fileName;

    /**
     * ImageResizeService constructor.
     * @param ImageManager $manager
     * @param ImageTypes $types
     */
    public function __construct(ImageManager $manager, ImageTypes $types)
    {
        $this->manager = $manager;
        $this->types = $types;
    }

    /**
     * @param UploadedFile $file
     * @param string $type
     * @return string
     */
    public function resizeImageForType(UploadedFile $file, $type)
    {
        /** @var ImageType $typeConfig */
        $typeConfig = $this->types->getType($type);

        /** @var Image $image */
        $image = $this->manager->make($file);

        $this->fileName = $this->generateFilename() . '.' . $file->getClientOriginalExtension();

        /** @var ImageSize $size */
        foreach ($typeConfig->getSizes() as $size ) {
            $resizeImage = $image;

            switch ($size->getScaleType()) {
                case 'fit':
                    $this->resizeFit($resizeImage, $size->getWidth(), $size->getHeight());
                    break;

                case 'fill':
                    $this->resizeFill($resizeImage, $size->getWidth(), $size->getHeight());
                    break;
            }
            $this->saveImage($resizeImage, $typeConfig, $size);
        }

        return $this->fileName;
    }

    /**
     * @param Image $image
     * @param int $width
     * @param int $height
     */
    private function resizeFit(Image &$image, $width, $height)
    {
        $image = $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }

    /**
     * @param Image $image
     * @param int $width
     * @param int $height
     */
    private function resizeFill(Image &$image, $width, $height)
    {
        $image = $image->fit($width, $height);
    }

    /**
     * @param Image $image
     * @param ImageType $typeConfig
     * @param ImageSize $size
     */
    private function saveImage(Image $image, ImageType $typeConfig, ImageSize $size)
    {
        $path = $typeConfig->makeFilePath($size, $this->fileName);

        file_put_contents($path, $image->encode($image->mime()));
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    protected function generateFilename()
    {
        return uniqid() . time();
    }


    public function resizeImageStringForType($file, $type, $ext)
    {
        /** @var ImageType $typeConfig */
        $typeConfig = $this->types->getType($type);

        /** @var Image $image */
        $image = $this->manager->make($file);

        $this->fileName = $this->generateFilename() . '.' . $ext;

        /** @var ImageSize $size */
        foreach ($typeConfig->getSizes() as $size ) {
            $resizeImage = $image;

            switch ($size->getScaleType()) {
                case 'fit':
                    $this->resizeFit($resizeImage, $size->getWidth(), $size->getHeight());
                    break;

                case 'fill':
                    $this->resizeFill($resizeImage, $size->getWidth(), $size->getHeight());
                    break;
            }
            $this->saveImage($resizeImage, $typeConfig, $size);
        }

        return $this->fileName;
    }
}