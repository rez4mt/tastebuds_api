<?php


class UserModule extends ParentClass {

    public static function isCredOk($username , $password)
    {
        $sql = "SELECT 1 FROM users WHERE username = ? AND password = ?";
        $stmt = getConn()->prepare($sql);
        if(!$stmt->execute([$username , $password]))
        {
            self::setCode("Internal error");
            return false;
        }
        if(!$stmt->rowCount())
        {
            self::setCode("incorrect username or password");
            return false;
        }
        return true;
    }
    public static function updateToken($username , $token)
    {
        $sql = "UPDATE users SET token = ? WHERE username = ?";
        $stmt = getConn()->prepare($sql);
        if(!$stmt->execute([$token , $username]))
        {
            self::setCode("Internal error");
            return false;
        }
        return true;
    }
    public static function register($username ,$name, $password)
    {
        $sql = "INSERT INTO users (username, name, password, token) VALUES (?,?,?,?)";
        $stmt = getConn()->prepare($sql);
        if(!$stmt->execute([$username , $name , $password,randomStr(10)]))
        {
            self::setCode("internal error");
            return false;
        }
        return true;
    }
    public static function getUserInfo($usernameOrId)
    {
        $sql = "SELECT * FROM users WHERE  username = ? OR id = ?";
        $stmt = getConn()->prepare($sql);
        if(!$stmt->execute([$usernameOrId , $usernameOrId]) || !$stmt->rowCount())
        {
            self::setCode(500);
            return false;
        }
        return $stmt->fetchObject();
    }
    public static function getId($username)
    {
        $sql = "SELECT id FROM users WHERE username = ? or token = ?";
        $stmt = getConn()->prepare($sql);
        if(!$stmt->execute([$username , $username]))
        {
            self::setCode(500);
            return false;
        }
        if(!$stmt->rowCount())
        {
            self::setCode("User not found");
            return false;
        }
        return $stmt->fetchObject()->id;
    }
    public static function authenticated($token)
    {
        $sql = "SELECT 1 FROM users WHERE token = ?";
        $stmt = getConn()->prepare($sql);
        if(!$stmt->execute([$token]))
        {
            self::setCode(500);
            return false;
        }
        if(!$stmt->rowCount())
        {
            self::setCode("Not Authenticated.");
            return false;
        }
        return true;
    }
    public static function extraInfo()
    {
        $sql = "select username FROM users order by points DESC ";
        $stmt = getConn()->prepare($sql);
        if(!$stmt->execute([]))
        {
            self::setCode(500);
            return false;
        }
        if(!$stmt->rowCount())
        {
            self::setCode("internal error");
            return false;
        }
        return $stmt->fetchAll();
    }
    public static function getVideos($id)
    {
        $sql = "SELECT videos.* ,c.name as category_name FROM videos 
        JOIN categories c on videos.category_id = c.id
        WHERE owner = ?";
        $stmt = getConn()->prepare($sql);
        if(!$stmt->execute([$id]))
        {
            self::setCode(500);
            return false;
        }
        return $stmt->fetchAll();
    }

}