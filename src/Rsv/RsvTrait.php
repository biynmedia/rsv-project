<?php


namespace App\Rsv;



use Behat\Transliterator\Transliterator;

trait RsvTrait
{
    /**
     * Permet de générer un Slug à partir d'un String
     * @param $text
     * @return mixed|string
     */
    public function slugify($text)
    {
        return Transliterator::transliterate($text);
    }
}