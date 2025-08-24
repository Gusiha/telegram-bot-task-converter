<?php

declare(strict_types=1);

namespace src\domain;


use src\domain\exceptions\DomainException;

abstract class AbstractReportParser
{

    //[task_id]{link}{title}{description}
    protected string $rowDelimiter = "\n\n";
    protected string $s = "\n\n";

    //TODO Выбирать через '\n\n' каждый завершенный тикет
    public function parseMultipleRows(string $text): array
    {
        $rows = explode($this->rowDelimiter, $text);
        if (empty($rows)) {
            if ($row = $this->parseSingleRow($text)) {
                return $row;
            }
        }
        return $rows;
    }

    public function parseSingleRow(string $text): array
    {
        $row = explode("\n", $text);
        if (empty($row)) {
            throw new DomainException(
                "Не удалось разбить сообщение на строки. Для конца строки используйте символ(ы) '{$this->rowDelimiter}'"
            );
        };
        return $row;
    }

//    abstract function extractTaskId(string $pattern): string;

    //TODO Выделять из ссылки "HELP-номер"
    //TODO Форматирование "link"

    //TODO Выделить название из строки
    //TODO Транслитерация выделенного названия
    //TODO Форматирование "title"

    //TODO Экранирование переданного фрагмента
    public function escapeMarkdown(string $text): string
    {
        $escapedText = '';

        $specials = ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];
        foreach (mb_str_split($text) as $char) {
            if (in_array($char, $specials, true)) {
                $escapedText .= '\\' . $char;
            } else {
                $escapedText .= $char;
            }
        }
        return $escapedText;
    }
}