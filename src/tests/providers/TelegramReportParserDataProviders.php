<?php

declare(strict_types=1);

namespace src\tests\providers;

class TelegramReportParserDataProviders
{
    public static function getRowsWithTextAndExcessWhitespaces(): array
    {
        return [
            'two rows' => ["hello\nhello", ['hello', 'hello']],
            'two rows with additional whitespaces' => ["  hello  \n hello ", ['hello', 'hello']],
        ];
    }

    public static function getEmptyRows(): array
    {
        return [
            'empty' => [""],
            'only whitespaces' => ["      "],
            'only empty rows' => ["\n\n"],
            'rows with whitespaces' => ["   \n   \n   "]
        ];
    }
}