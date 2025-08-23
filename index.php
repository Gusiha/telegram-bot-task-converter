<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$token = $_ENV['BOT_TOKEN'];

if(!$token)
    throw new Exception('Bot token not set');

$bot = new Nutgram($token);

$bot->onCommand('start', function (Nutgram $bot) {
   $bot->sendMessage("Bot is working!");
});

$bot->onCommand('convert {text}', function (Nutgram $bot, string $text) {
   $bot->sendMessage(
        text: $text,
        parse_mode: ParseMode::MARKDOWN,
   );
});

$bot->run();