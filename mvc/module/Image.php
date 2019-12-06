<?php
/**
 * Created by PhpStorm.
 * User: r_mot
 * Date: 8/31/2018
 * Time: 4:44 PM
 */
class ImageModule
{
    public static function getImage($id)
    {
        $sql = "SELECT data FROM images WHERE id = ?";
        $stmt = getConn()->prepare($sql);
        if(!$stmt->execute([$id]) || !$stmt->rowCount())
            return false;
        return $stmt->fetchObject()->data;
    }
}