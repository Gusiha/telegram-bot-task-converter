<?php

declare(strict_types=1);

namespace src\domain;

use src\domain\abstractions\AbstractReportParser;
use src\domain\abstractions\IParser;
use src\exceptions\DomainException;


//TODO После декомпозиции написать юнит-тесты
//TODO После успешных юнит-тестов, сделать интеграционный
//TODO Запустить бота
//TODO Приветственное сообщение, которое расскажет о формате ввода
//TODO Вывод ошибок (try/catch) как через контроллер

class TelegramReportParser extends AbstractReportParser implements IParser
{

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

    public function parseLinkText(string $row): string
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


    /**
     * @param string $row
     * @return string Ссылка
     * @throws DomainException Не найдена ссылка
     */
    public function parseLink(string $row): string
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
    public function parseDescription(string $row): string
    {
        $parts = explode($this->innerDelimeter, $row);

        foreach ($parts as $part) {
            if (!filter_var($part, FILTER_VALIDATE_URL)) {
                return $this->formatDescription($part);
            }
        }

        throw new DomainException('Не найдено описание');
    }


    public function parseTitle(string $row): string
    {
        if (preg_match($this->taskTitleRegex, $row, $match)) {
            return $match[1];
        }

        throw new DomainException('Из ссылки не удалось вытянуть название тикета при парсинге');
    }

    public function parseLines(string $text): array
    {
        $normalizedText = mb_trim($text);
        if ($normalizedText == "") {
            throw new DomainException('Передана пустая строка');
        }

        $rows = explode($this->rowDelimiter, $normalizedText);
        $rowsWithoutWhitespaces = array_map(fn($row) => mb_trim($row), $rows);
        $rowsWithText = array_filter($rowsWithoutWhitespaces, fn($row) => $row != "");

        if (!count($rowsWithText)) {
            throw new DomainException('Переданы пустые строки');
        }

        return $rowsWithText;
    }
}