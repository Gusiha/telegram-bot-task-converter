<?php

declare(strict_types=1);

namespace src\domain\abstractions;


abstract class AbstractReportParser
{
    protected string $rowDelimiter = "\n";
    protected string $innerDelimeter = " ";

    protected string $taskShortTitleRegex = "/HELP-\d+/";
    protected string $taskTitleRegex = "/HELP-\d+/([^/]+)";
}
