<?php

namespace App\Helpers;

class Image
{

    /**
     * Generate the URL that will return a random image
     *
     * Set randomize to false to remove the random GET parameter at the end of the url.
     *
     * @example 'https://via.placeholder.com/640x480/?12345'
     *
     * @param integer $width
     * @param integer $height
     * @param bool $randomize
     *
     * @return string
     */
    public static function imageUrl($width = 640, $height = 480, $randomize = true): string
    {
        $baseUrl = "https://via.placeholder.com/";
        $color = substr(md5(rand()), 0, 6);
        $url = "{$width}x{$height}/{$color}";

        if ($randomize) {
            $url .= '?text=' . mt_rand();
        }

        return $baseUrl . $url;
    }

    /**
     * Download a remote random image to disk and return its location
     *
     * Requires curl, or allow_url_fopen to be on in php.ini.
     *
     * @param null $dir
     * @param int $width
     * @param int $height
     * @param bool $fullPath
     * @param bool $randomize
     * @return bool|\RuntimeException|string
     * @example '/path/to/dir/13b73edae8443990be1aa8f1a483bc27.jpg'
     */
}