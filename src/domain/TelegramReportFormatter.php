<?php

declare(strict_types=1);

namespace src\domain;

use src\domain\abstractions\IFormatter;
use src\exceptions\DomainException;

class TelegramReportFormatter implements IFormatter
{
    function formatDescription(string $description): string
    {
        if (empty($description)) {
            throw new DomainException('Передана пустая строка вместо описания');
        }

        return "*[{$description}*]";
    }
    function formatLink(string $link, string $linkText): string
    {
        if (empty($link)) {
            throw new DomainException('Передана пустая строка вместо ссылки');
        }

        if (empty($linkText)) {
            throw new DomainException('Передан пустой замещающий текст для ссылки');
        }

        return "[$linkText]($link)";
    }
    function formatTitle(string $title): string
    {
        if (empty($title)) {
            throw new DomainException('Из ссылки не удалось вытянуть название тикета при форматировании');
        }

        $cyrillic = $this->translitToCyrillic($title);
        $withUppercase = $this->replaceFirstLetterWithUppercase($cyrillic);

        return $this->replaceDashesWithSpaces($withUppercase);
    }


    protected function replaceDashesWithSpaces(string $text): string
    {
        return strtr($text, ['-' => ' ']);
    }

    protected function replaceFirstLetterWithUppercase(string $text): string
    {
        return mb_ucfirst($text);
    }

    protected function translitToCyrillic(string $str): string
    {
        $converter = [
            // Сначала многосимвольные комбинации (длинные → короткие)
            'SHCH' => 'Щ',
            'Shch' => 'Щ',
            'shch' => 'щ',
            'YO' => 'Ё',
            'ZH' => 'Ж',
            'TS' => 'Ц',
            'CH' => 'Ч',
            'SH' => 'Ш',
            'YU' => 'Ю',
            'YA' => 'Я',
            'yo' => 'ё',
            'zh' => 'ж',
            'ts' => 'ц',
            'ch' => 'ч',
            'sh' => 'ш',
            'yu' => 'ю',
            'ya' => 'я',

            // Затем одиночные буквы
            'A' => 'А',
            'B' => 'Б',
            'V' => 'В',
            'G' => 'Г',
            'D' => 'Д',
            'E' => 'Е',
            'Z' => 'З',
            'I' => 'И',
            'Y' => 'Й',
            'K' => 'К',
            'L' => 'Л',
            'M' => 'М',
            'N' => 'Н',
            'O' => 'О',
            'P' => 'П',
            'R' => 'Р',
            'S' => 'С',
            'T' => 'Т',
            'U' => 'У',
            'F' => 'Ф',
            'H' => 'Х',

            'a' => 'а',
            'b' => 'б',
            'v' => 'в',
            'g' => 'г',
            'd' => 'д',
            'e' => 'е',
            'z' => 'з',
            'i' => 'и',
            'y' => 'й',
            'k' => 'к',
            'l' => 'л',
            'm' => 'м',
            'n' => 'н',
            'o' => 'о',
            'p' => 'п',
            'r' => 'р',
            's' => 'с',
            't' => 'т',
            'u' => 'у',
            'f' => 'ф',
            'h' => 'х',
        ];

        return strtr($str, $converter);
    }
}