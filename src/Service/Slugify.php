<?php


namespace App\Service;


class Slugify
{
    public function generate(string $input): string
    {
        //enlève les à, ç, ï...
        $clean = iconv('utf-8', 'us-ascii//TRANSLIT', $input);
        //enlève les espaces en début et fin de chaine
        $clean = trim($clean);
        //remplace les espaces
        $clean = str_replace(' ', '-', $clean);
        $clean = str_replace(['!', '?', '\'', '.', ';', ','], '', $clean);
        //remplace les double -
        $clean = preg_replace('/-{2}/', '-', $clean);
        return strtolower($clean);
    }
}