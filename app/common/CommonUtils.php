<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 31/01/2018
 * Time: 12:52
 */

namespace app\common;

trait CommonUtils
{
    /*
     * Ici vous devez créer uniquement des méthodes avec le mot clé << static >>
     * Vous pouvez acceder à votre méthode partout dans le projet en faisant
     * Utils::votre_nom_de_methode();
     */

    public static function getDateUS2($date)
    {
        $date    = \explode("/",$date);
        return $date[0];
    }

    public static function alignRight($mnt)
    {
        return "<div class='text-right'>".$mnt."</div>";
    }

    public static function truncate_carte($carte)
    {
        $nb_caractere = strlen($carte);
        $premier = "";
        if ($nb_caractere > 0) {

            for ($i = 0; $i < $nb_caractere - 4; $i++) {
                $premier .= "*";
            }
            $truncate = $premier . substr($carte, $nb_caractere - 4);
            return $truncate;
        } else {
            return -1;
        }
    }

    public static function bourrageChaine($caractere,$chaine_a_bourrer,$tailleVoulue,$sensBourrage)
    {
        $boucle = $tailleVoulue - strlen($chaine_a_bourrer);
        while($boucle){
            if($sensBourrage=='gauche')
                $chaine_a_bourrer = $caractere.$chaine_a_bourrer;
            else $chaine_a_bourrer = $chaine_a_bourrer.$caractere;
            $boucle--;
        }
        return $chaine_a_bourrer;
    }
}