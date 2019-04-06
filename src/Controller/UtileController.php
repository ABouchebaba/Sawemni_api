<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 06/04/2019
 * Time: 08:04
 */

namespace App\Controller;


class UtileController
{

    public static function saveImage($dir="Public/Images", $data)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                return false;
            }

            $data = base64_decode($data);

            if ($data === false) {
                return false;
            }
        } else {
            return false;
        }

        $name = uniqid('', true);
        $path =  "$dir/$name.$type";

        $saved = file_put_contents($path, $data);

        return array("saved" => ($saved != false), "path" => $path);

    }
}