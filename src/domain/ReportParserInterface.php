<?php

declare(strict_types=1);

namespace src\domain;

interface ReportParserInterface
{
    function parse(string $report) : string;
}