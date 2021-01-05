<?php
/**
 * Created by PhpStorm.
 * User: smithjunior
 * Date: 22/01/19
 * Time: 16:10
 */

namespace App\Services;


class PixelService
{
    public static function returnPixel()
    {
        $image="\x47\x49\x46\x38\x37\x61\x1\x0\x1\x0\x80\x0\x0\xfc\x6a\x6c\x0\x0\x0\x2c\x0\x0\x0\x0\x1\x0\x1\x0\x0\x2\x2\x44\x1\x0\x3b";
        return \response($image,200)->header('Content-Type', 'image/gif');;
    }
}
