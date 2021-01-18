<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 21/07/2016
 * Time: 12:24
 */

namespace app\core;

abstract class Language
{
    static function getLang($langs)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $langs = @htmlspecialchars($langs, ENT_QUOTES);
        if (!file_exists(ROOT.'app/language/'.$langs.'.lang')) $langs = 'fr';
        return parse_ini_string(file_get_contents(ROOT.'app/language/'.$langs.'.lang'));
    }
}