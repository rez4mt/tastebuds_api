<?php
/**
 * Created by PhpStorm.
 * User: r_mot
 * Date: 3/7/2019
 * Time: 9:59 AM
 */

class HomeModule extends ParentClass {
    public static function addVideo($url , $owner , $title , $category_id)
    {
        $sql = "INSERT INTO videos(category_id, url, owner,title) VALUES (?,?,?,?)";
        $stmt = getConn()->prepare($sql);
        if(!$stmt->execute([$category_id ,$url , $owner , $title]))
        {
            self::setCode(500);
            return false;
        }
        return true;
    }
    public static function getCategories()
    {
        $sql = "SELECT * FROM categories";
        $stmt = getConn()->prepare($sql);
        if(!$stmt->execute([]))
        {
            self::setCode(500);
            return false;
        }
        return $stmt->fetchAll();
    }
    public static function getRandVideo($cat)
    {
        $sql = "SELECT * FROM videos where category_id = ? ORDER BY  rand() LIMIT 2";
        $stmt = getConn()->prepare($sql);
        if(!$stmt->execute([$cat]))
        {
            self::setCode(500);
            return false;
        }
        return $stmt->fetchAll();
    }
    public static function voteVideo($v_id)
    {
        $sql = "update videos as v 
        JOIN users as u ON U.id = v.owner
        SET votes = votes+1 , u.points = u.points+1 WHERE v.id = ?";
        $stmt = getConn()->prepare($sql);
        if(!$stmt->execute([$v_id]))
        {
            self::setCode(500);
            return false;
        }
        return true;
    }

}