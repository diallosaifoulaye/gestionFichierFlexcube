<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 17/08/2017
 * Time: 11:01
 */

namespace app\core;

abstract class TokenJWT
{
    public static function encode($params, $key, $expire = false) {
        if($expire !== false && intval($expire) > 0)
            $params["expire"] = strtotime(Utils::getDateFuturFromDate([$expire,"minute"], "now"));
        return \JWT::encode($params, $key);
    }

    public static function decode($tokenJWT, $key) {
        try{
            return (self::verif($tokenJWT, $key) == 0) ? \JWT::decode($tokenJWT, $key, ['HS256']) : -1;
        }catch(\Exception $ex){
            return -2;
        }
    }

    /**
     * @param $tokenJWT
     * @param $key
     * @return bool|int|object
     *
     *  si retourne -1 alors le Token a expiré
     *  si retourne -2 alors le Token est invalide
     *
     */
    public static function verif($tokenJWT, $key) {
        try{
            $result = \JWT::decode($tokenJWT, $key, ['HS256']);
            if (isset($result->{"expire"}))
                return (strtotime(Utils::getDateNow(true)) < $result->{"expire"}) ? 0 : -1;
            else return $result;
        }catch(\Exception $ex){
            return -2;
        }
    }
}