<?php

declare(strict_types=1);

namespace src\domain;


abstract class AbstractReportParser
{
    protected string $rowDelimiter = "\n";
    protected string $innerDelimeter = " ";

    abstract function parse(string $text): string;

    protected abstract function parseMultipleRows(string $text): array;
    protected abstract function parseSingleRow(string $text): array;


    protected string $taskShortTitleRegex = "/HELP-\d+/";
    protected string $taskTitleRegex = "/HELP-\d+/([^/]+)";
    protected abstract function parseLinkText(string $row): string;
    protected abstract function parseTitle(string $row): string;
    protected abstract function parseLink(string $row): string;
    protected abstract function parseDescription(string $row): string;


    protected array $escapeSymbols = ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];
    protected abstract function escapeMarkdown(string $text): string;
}
