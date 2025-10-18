<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use src\domain\ReportParser;


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$token = $_ENV['BOT_TOKEN'];

if (!$token) {
    throw new Exception('Bot token not set');
}

$bot = new Nutgram($token);
$parser = new ReportParser();

$bot->onCommand('start', function (Nutgram $bot) {
    $bot->sendMessage("Bot is working!");
});

//$bot->onMessage(function (Nutgram $bot) {
//    $text = $bot->message()->text;
//    var_dump('RAW MESSAGE:', $text);
//
//    $bot->sendMessage(
//        text: $text,
//        parse_mode: null // временно убери Markdown
//    );
//});

$bot->onMessage(function (Nutgram $bot) use ($parser) {
    $text = $bot->message()->getText();

    $bot->sendMessage(
//        text: $parser->escapeMarkdown($text),
        text: $text,
        parse_mode: ParseMode::MARKDOWN
    );
});

$bot->fallback(function (Nutgram $bot) {
    $bot->sendMessage('Не найдена команда');
});

$bot->run();