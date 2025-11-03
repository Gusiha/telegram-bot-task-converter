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

    public static function getValidTicket(): array
    {
        return [
            'full valid ticket' =>
                [
                    "https://test.ru/tickets/HELP-9999/ne-hochet-nichego порисчерчил, ничего не понял, грустный",
                    "https://test.ru/tickets/HELP-9999/ne-hochet-nichego"
                ]
        ];
    }

    public static function getTicketWithoutTransliteratedTitle(): array
    {
        return [
            'ticket without transliterated title' => ["https://test.ru/tickets/HELP-9999 порисчерчил, ничего не понял, грустный"]
        ];
    }

    public static function getTicketsWithInvalidUrl(): array
    {
        return [
            'ticket with invalid url' => ["http\ns://test.ru/tickets/HELP-9999/ne-hochet-nichego порисчерчил, ничего не понял, грустный"],
            'ticket reversed' => ["порисчерчил, ничего не понял, грустный https://test.ru/tickets/HELP-9999"],
        ];
    }

    public static function getInvalidTickets(): array
    {
        return array_merge(
            self::getTicketWithoutTransliteratedTitle(),
            [
                'ticket without description' => ["https://test.ru/tickets/HELP-9999"],
                'ticket without description, but there is a slash' => ["https://test.ru/tickets/HELP-9999/"],
                'ticket with description, but there is slash + whitespace' => ["https://test.ru/tickets/HELP-9999/ "],
                'ticket with invalid url' => ["http\ns://test.ru/tickets/HELP-9999/ne-hochet-nichego порисчерчил, ничего не понял, грустный"],
                'ticket reversed' => ["порисчерчил, ничего не понял, грустный https://test.ru/tickets/HELP-9999"],
            ]
        );
    }

}