<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$token = $_ENV['BOT_TOKEN'];

if (!$token) {
    throw new Exception('Bot token not set');
}

$bot = new Nutgram($token);

$bot->onCommand('start', function (Nutgram $bot) {
    $bot->sendMessage("Bot is working!");
});

$bot->onMessage(function (Nutgram $bot) {
    $text = $bot->message()->getText();

    $bot->sendMessage(
        text: $text,
        parse_mode: ParseMode::MARKDOWN
    );
});

$bot->fallback(function (Nutgram $bot) {
    $bot->sendMessage('Не найдена команда');
});

$bot->run();


https://youtrack.mostfit.ru/tickets/HELP-2437/Pochinit-vygruzku-studij-iz-srm-na-pauze проблемы не оказалось, все нормально экспортируется, скинул excel с таблицами на паузе https://youtrack.mostfit.ru/tickets/HELP-2442/Nuzhna-uchetka-data-grip решена https://youtrack.mostfit.ru/tickets/HELP-2167/Integraciya-sycret-rasshirit-zagruzhaemye-okna зависшая задачка в бэклоге, тегнул Игоря https://youtrack.mostfit.ru/tickets/HELP-2436/Ne-otobrazhayutsya-dostupnye-sloty-minimalnogo-vremeni-bronirovaniya проверил, что сейчас слоты появляются меньше чем за 60 минут, жду ответа https://youtrack.mostfit.ru/tickets/HELP-2437/Pochinit-vygruzku-studij-iz-srm-na-pauze проблемы не оказалось, все нормально экспортируется, скинул excel с таблицами на паузе https://youtrack.mostfit.ru/tickets/HELP-2451/Proverit-na-frod проверил существует ли антифрод для смс, спросил у олдов это все старая история, Арина должна сама настроить это в МТС https://youtrack.mostfit.ru/tickets/HELP-2449/Otklyuchenie-studii-ot-integracii-s-mobifitness связано с mobFit, тегнул Никиту, он объяснил как там все удалить, чтобы потом заработало, написал sql-запрос, сохранил, тикет закрыл https://youtrack.mostfit.ru/tickets/HELP-2422/Ne-poluchaetsya-zapisatsya-v-Reshape попытался записаться, все нормально отрабатывает, жду ответа