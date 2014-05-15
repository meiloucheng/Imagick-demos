<?php

namespace ImagickDemo\Example;

class psychedelicFontGif extends \ImagickDemo\ExampleWithoutControl {

    function renderDescription() {
    }

    function renderImage() {

        set_time_limit(3000);

        $aniGif = new \Imagick();
        $aniGif->setFormat("gif");

        $maxFrames = 11;
        $scale = 0.25;

        for ($frame = 0; $frame < $maxFrames; $frame++) {

            $draw = new \ImagickDraw();

            $name = 'Danack';

            if (array_key_exists('name', $_REQUEST) == true) {
                $name = $_REQUEST['name'];
            }

            $draw->setStrokeOpacity(1);

            
            $draw->setFont("../fonts/CANDY.TTF");

            $draw->setfontsize(150 * $scale);

            for ($strokeWidth = 25; $strokeWidth > 0; $strokeWidth--) {
                $hue = intval(fmod(($frame * 360 / $maxFrames) + 170 + $strokeWidth * 360 / 25, 360));
                $color = "hsl($hue, 255, 128)";
                $draw->setStrokeColor($color);
                $draw->setFillColor($color);
                $draw->setStrokeWidth($strokeWidth * 3 * $scale);
                $draw->annotation(60 * $scale, 165 * $scale, $name);
            }

            $draw->setStrokeColor('none');
            $draw->setFillColor('black');
            $draw->setStrokeWidth(0);
            $draw->annotation(60 * $scale, 165 * $scale, $name);
            
            

            //Create an image object which the draw commands can be rendered into
            $imagick = new \Imagick();
            $imagick->newImage(650 * $scale, 230 * $scale, "#eee");
            $imagick->setImageFormat("png");

            //Render the draw commands in the ImagickDraw object
            //into the image.
            $imagick->drawImage($draw);

            $imagick->setImageDelay(5);
            $aniGif->addImage($imagick);

            $imagick->destroy();
        }

        $aniGif->setImageIterations(0); //loop forever
        $aniGif->deconstructImages();

        header("Content-Type: image/gif");
        echo $aniGif->getimagesblob();
        //there more than one file, so must be using writeImages()
        //$aniGif->writeImages("../var/cache/imageCache/Danack.gif", true);

//$aniGif->writeimagesfile();
        //echo "done";

    }
}