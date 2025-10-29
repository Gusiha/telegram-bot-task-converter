<?php

declare(strict_types=1);

namespace src\domain;

use src\exceptions\DomainException;


//TODO Декомпозировать класс (парсер, форматтер как минимум)
//TODO После декомпозиции написать юнит-тесты
//TODO После успешных юнит-тестов, сделать интеграционный
//TODO Запустить бота
//TODO Приветственное сообщение, которое расскажет о формате ввода
//TODO Вывод ошибок (try/catch) как через контроллер

class ReportParser extends AbstractReportParser
{

    public function parseMultipleRows(string $text): array
    {
        //TODO тут была раньше библиотека, надо донормализовать (двойные проблелы заменить хотя бы)
        $normalizedText = mb_trim($text);
        $rows = explode($this->rowDelimiter, $normalizedText);

        if (empty($rows) && $normalizedText !== '') {
            return $this->parseSingleRow($normalizedText);
        }

        return $rows;
    }

    public function parseSingleRow(string $text): array
    {
        $parts = explode($this->innerDelimeter, $text, PHP_INT_MIN);

        if ($parts > 2) {
            throw new DomainException(
                "Не соответствует формату (слишком много частей для одного задания, должно быть 2)"
            );
        }

        if (empty($parts)) {
            throw new DomainException(
                "Не удалось разбить сообщение на части. Для разделения используйте символ(ы) '{$this->innerDelimeter}'"
            );
        };

        $this->parseLink($text);


        return $parts;
    }

    protected function parseLinkText(string $row): string
    {
        $isTaskShortTitleFound = preg_match($this->taskShortTitleRegex, $row, $match);

        if (!$isTaskShortTitleFound) {
            throw new DomainException(
                "Не удалось спарсить task_short_title.  '{$this->rowDelimiter}'"
            );
        };

        if (count($match) > 1) {
            throw new DomainException(
                sprintf("В строке несколько task_short_title. %s", print_r($match, true))
            );
        }

        return $match[0][0];
    }


    public function escapeMarkdown(string $text): string
    {
        $escapedText = '';

        foreach (mb_str_split($text) as $char) {
            if (in_array($char, $this->escapeSymbols, true)) {
                $escapedText .= '\\' . $char;
            } else {
                $escapedText .= $char;
            }
        }
        return $escapedText;
    }

    function parse(string $text): string
    {
        return 'hello';
    }

    /**
     * @param string $row
     * @return string Ссылка
     * @throws DomainException Не найдена ссылка
     */
    protected function parseLink(string $row): string
    {
        $parts = explode($this->innerDelimeter, $row);

        foreach ($parts as $part) {
            if (filter_var($part, FILTER_VALIDATE_URL)) {
                return $this->formatLink($part, $this->parseLinkText($part));
            }
        }

        throw new DomainException('Не найдена ссылка');
    }

    /**
     * @param string $row
     * @return string Описание (жирным шрифтом в скобках)
     * @throws DomainException Не найдена ссылка
     */
    protected function parseDescription(string $row): string
    {
        $parts = explode($this->innerDelimeter, $row);

        foreach ($parts as $part) {
            if (!filter_var($part, FILTER_VALIDATE_URL)) {
                return $this->formatDescription($part);
            }
        }

        throw new DomainException('Не найдено описание');
    }

    protected function formatDescription(string $description): string
    {
        if (empty($description)) {
            throw new DomainException('Передана пустая строка вместо описания');
        }

        return "*[{$description}*]";
    }

    protected function formatLink(string $link, string $linkText): string
    {
        if (empty($link)) {
            throw new DomainException('Передана пустая строка вместо ссылки');
        }

        if (empty($linkText)) {
            throw new DomainException('Передан пустой замещающий текст для ссылки');
        }

        return "[$linkText]($link)";
    }

    protected function parseTitle(string $row): string
    {
        if (preg_match($this->taskTitleRegex, $row, $match)) {
            return $this->formatTitle($match[1]);
        }

        throw new DomainException('Из ссылки не удалось вытянуть название тикета при парсинге');
    }

    protected function formatTitle(string $title): string
    {
        if (empty($title)) {
            throw new DomainException('Из ссылки не удалось вытянуть название тикета при форматировании');
        }

        $cyrillic = $this->translitToCyrillic($title);
        $withUppercase = $this->replaceFirstLetterWithUppercase($cyrillic);

        return $this->replaceDashesWithSpaces($withUppercase);
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

    protected function replaceDashesWithSpaces(string $text): string
    {
        return strtr($text, ['-' => ' ']);
    }

    protected function replaceFirstLetterWithUppercase(string $text): string
    {
        return mb_ucfirst($text);
    }

}