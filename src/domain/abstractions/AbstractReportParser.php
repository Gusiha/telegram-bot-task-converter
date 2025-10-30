<?php

declare(strict_types=1);

namespace src\domain\abstractions;


abstract class AbstractReportParser implements IParser
{
    protected string $rowDelimiter = "\n";
    protected string $innerDelimeter = " ";

    protected string $taskShortTitleRegex = "/HELP-\d+/";
    protected string $taskTitleRegex = "/HELP-\d+/([^/]+)";


    protected array $escapeSymbols = ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];
    protected abstract function escapeMarkdown(string $text): string;
}
