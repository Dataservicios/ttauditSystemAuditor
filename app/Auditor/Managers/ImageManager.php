<?php
/**
 * ImageManager.php
 * A wrapper around GD that does multiple operations like, resizing, rotating,
 * cropping and stuff.
 *
 * @author Michael Pratt <pratt@hablarmierda.net>
 * @version 1.0
 * @link http://www.michael-pratt.com/
 * @demo http://www.michael-pratt.com/Lab/imageManager/
 *
 * @License: MIT
 * Copyright (C) 2012 by Michael Pratt <pratt@hablarmierda.net>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace Auditor\Managers;

class ImageManager
{
    protected $image;
    protected $width;
    protected $height;

    /**
     * Construct
     *
     * @param string $image Path to the image file
     * @return void.
     */
    /*public function __construct($image)
    {
        $this->image = $this->loadImageResource($image);
        list($this->width, $this->height) = getimagesize($image);
    }*/

    public function getImage($image)
    {
        $this->image = $this->loadImageResource($image);
        list($this->width, $this->height) = getimagesize($image);
    }

    /**
     * Resizes the image file, presserving the ratio
     *
     * @param int $ratio The new ratio that the image will have
     * @return bool
     */
    public function resizeRatio($ratio = 90)
    {
        $xscale = round($this->width/$ratio);
        $yscale = round($this->height/$ratio);
        $width  = ($yscale > $xscale) ? ceil($this->width * (1/$yscale)) : ceil($this->width * (1/$xscale));
        $height = ($yscale > $xscale) ? ceil($this->height * (1/$yscale)) : ceil($this->height * (1/$xscale));

        return $this->resize($width, $height);
    }
    // Alias for Resize Ratio
    public function thumbnail($ratio = 90) { return $this->resizeRatio($ratio); }

    /**
     * Resizes the image file
     *
     * @param int $width
     * @param int $height
     * @return bool
     */
    public function resize($width, $height)
    {
        $resized = imagecreatetruecolor($width, $height);
        $return  = imagecopyresampled($resized, $this->image, 0, 0, 0, 0, $width, $height, $this->width, $this->height);

        if ($return)
            $this->image = $resized;

        return (bool) $return;
    }

    /**
     * Crops the given image from the ($fromX, $fromY) point to the ($toX,$toY) point.
     *
     * @param int $fromX X coordinate from where the crop should start
     * @param int $fromY Y coordinate from where the crop should start
     * @param int $toX   X coordinate from where the crop should end
     * @param int $toY   Y coordinate from where the crop should end
     * @return bool
     */
    public function crop($fromX, $fromY, $toX, $toY)
    {
        $width  = $toX - $fromX;
        $height = $toY - $fromY;

        $cropped = imagecreatetruecolor($width, $height);
        imagealphablending($cropped, false);
        imagesavealpha($cropped, true);

        $return = imagecopy($cropped, $this->image, 0, 0, $fromX, $fromY, $width, $height);

        if ($return)
            $this->image = $cropped;

        return $return;
    }

    /**
     * Crops the given image from the ($from_x,$from_y) point to the ($to_x,$to_y) point.
     *
     * @param int $width the width of the portion
     * @param int $height the height of the portion
     * @return bool
     */
    public function randomPortion($width, $height)
    {
        if ($width >= $this->width || $height >= $this->height)
            throw new Exception('The Portion must be smaller than the initial image');

        $portion = imagecreatetruecolor($width, $height);
        $return  = imagecopy($portion, $this->image, 0, 0, mt_rand(0, ($this->width - $width)), mt_rand(0, ($this->height - $height)), $width, $height);

        if ($return)
            $this->image = $portion;

        return (bool) $return;
    }

    /**
     * Rotates the image to any direction using the given angle.
     *
     * @param int $angle The rotation angle, in degrees.
     * @param array $background The background color to use with imagecolorallocate
     * @return bool
     */
    public function rotate($angle, $background = array())
    {
        $rotation = imagerotate($this->image, $angle, $this->colorAllocate($background));
        if ($rotation !== false)
            $this->image = $rotation;

        return (bool) $rotation;
    }

    /**
     * Pastes a new image to the current one, given x and y coordinates.
     *
     * @param string $image Location of the new image
     * @param int $destinyX
     * @param int $destinyY
     * @param int $opacity
     */
    public function overlayImage($image, $destinyX, $destinyY, $opacity = 100)
    {
        $newImage = $this->loadImageResource($image);
        return imagecopymerge($this->image, $newImage, $destinyX, $destinyY, 0, 0, imagesx($newImage), imagesy($newImage), $opacity);
    }

    /**
     * Zooms the frame given the center coordinates.
     *
     * @param int $zoom The Zoom Factor
     * @param int $centerX X center coordinate of the frame
     * @param int $centerY Y center coordinate of the frame
     * @return bool
     */
    public function zoom($zoom = 2, $centerX = 0, $centerY = 0)
    {
        $topLeftX = $topLeftY = 0;
        if ($centerX == 0 && $centerY == 0)
        {
            $centerX = round($this->width/2);
            $centerY = round($this->height/2);
        }

        if ($zoom == 0)
            return false;

        while(true)
        {
            $width  = ceil($this->width/$zoom);
            $height = ceil($this->height/$zoom);

            // Get the top left coordinates of the zoom
            $topLeftX = round($centerX - ($width/2));
            $topLeftY = round($centerY - ($height/2));

            // Validate that X and Y are inside the range of the image!
            $validateX = ($topLeftY <= $this->width && ($topLeftX + $width) <= $this->width && $topLeftX >= 0);
            $validateY = ($topLeftY <= $this->height && ($topLeftY + $height) <= $this->height && $topLeftY >= 0);

            // Stop zooming if the coordinates are good OR if we have tried too many times.
            if (($validateX && $validateY) || $zoom >= 50)
                break;

            $zoom++;
        }

        // Zoom the area
        $croppedImage = imagecreatetruecolor($width, $height);
        imagecopyresampled($croppedImage, $this->image, 0, 0, $topLeftX, $topLeftY, $this->width, $this->height, $this->width, $this->height);

        // Enhance it!
        $zoomedImage = imagecreatetruecolor($this->width, $this->height);
        $return = imagecopyresampled($zoomedImage, $croppedImage, 0, 0, 0, 0, $this->width, $this->height, $width, $height);

        if ($return)
            $this->image = $zoomedImage;

        return (bool) $return;
    }

    /**
     * Adds a border to the image
     *
     * @param int $thickness
     * @param array $color
     * @return bool
     */
    public function addBorder($thickness = 5, $color = array(0, 0, 0, 0, 0))
    {
        $x1 = $y1 = 0;
        $x2 = $this->width - 1;
        $y2 = $this->height - 1;

        for($i = 0; $i < $thickness; $i++)
        {
            imagerectangle($this->image, $x1++, $y1++, $x2--, $y2--, $this->colorAllocate($color));
        }
    }

    /**
     * Mirrors the given image in the desired direction
     *
     * @param string $mode This can be 'horizontal', 'vertical', 'both'
     * @return bool
     */
    public function flip($mode)
    {
        $newWidth = $this->width;
        $newHeight = $this->height;
        $srcX = $srcY = 0;

        switch (strtolower($mode))
        {
            case 'vertical':
                $srcY = ($this->height-1);
                $newHeight = ($this->height*-1);
               break;

            case 'horizontal':
                $srcX = ($this->width -1);
                $newWidth = ($this->width*-1);
                break;

            case 'both':
                $srcX = ($this->width-1);
                $srcY = ($this->height-1);
                $newWidth  = ($this->width*-1);
                $newHeight = ($this->height*-1);
                break;

            default:
                throw new Exception('The Flip Method only accepts a string like horizontal, vertical or both.');
        }

        $flipped = imagecreatetruecolor($this->width, $this->height);
        $return  = imagecopyresampled($flipped, $this->image, 0, 0, $srcX, $srcY, $this->width, $this->height, $newWidth, $newHeight);

        if ($return)
            $this->image = $flipped;

        return (bool) $return;
    }

    /**
     * Saves the image to path
     *
     * @param string $output The path where the image will be saved
     * @return bool
     */
    public function save($output)
    {
        $extension = strtolower(pathinfo($output, PATHINFO_EXTENSION));
        switch ($extension)
        {
            case 'jpg':
                return imagejpeg($this->image, $output, 100);
                break;

            case 'png':
                return imagepng($this->image, $output, 5);
                break;

            case 'gif':
                return imagegif($this->image, $output);
                break;

            default:
                throw new Exception('The output file must end in jpg, png or gif.');
        }
    }

    /**
     * Show the image in png format for a browser
     *
     * @return void
     */
    public function show()
    {
        header('Content-type: image/png');
        imagepng($this->image);
    }

    /**
     * Gets the resource form an image.
     * Throws exceptions when errors are found.
     *
     * @return resource
     */
    protected function loadImageResource($image)
    {
        if (!is_file($image))
            throw new Exception('The Image ' . $image . ' could not be found!');

        $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        switch ($extension)
        {
            case 'jpg':
                $resource = imagecreatefromjpeg($image);
                break;

            case 'png':
                $resource = imagecreatefrompng($image);
                break;

            case 'gif':
                $resource = imagecreatefromgif($image);
                break;

            default:
                throw new Exception('Extension not supported. The file must be jpg, png or gif.');
        }

        if ($resource === false)
            throw new Exception('Could not load the Image. Image file might be corrupt.');

        imagealphablending($resource, false);
        imagesavealpha($resource, true);

        return $resource;
    }

    /**
     * Allocate a color for an image
     *
     * @param array $color An array with at least 3 numeric keys
     * @return the color code
     */
    protected function colorAllocate($color = array())
    {
        if (empty($color) || !is_array($color) || count($color) < 3)
            return imagecolorallocatealpha($this->image, 255, 255, 255, 127);

        $red   = (int) (is_numeric($color[0]) && $color[0] <= 255 && $color[0] > 0 ? $color[0] : 0);
        $green = (int) (is_numeric($color[1]) && $color[1] <= 255 && $color[1] > 0 ? $color[1] : 0);
        $blue  = (int) (is_numeric($color[2]) && $color[2] <= 255 && $color[2] > 0 ? $color[2] : 0);
        $alpha = (int) (is_numeric($color[3]) && $color[3] <= 127 && $color[3] > 0 ? $color[3] : 127);

        return imagecolorallocatealpha($this->image, $red, $green, $blue, $alpha);
    }

    /**
     * Destruct
     * Free memory when this object is done.
     *
     * @return void
     */
    /*public function __destruct()
    {
        imagedestroy($this->image);
    }*/

    public function Terminar()
    {
        imagedestroy($this->image);
    }
}
?>