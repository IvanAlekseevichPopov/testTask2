<?php

const QUERY_LIMIT = 1000;

function check_email(string $email): int
{
    sleep(rand(1, 60));

    return 1;
}

function send_email($from, $to, $text): void
{
    sleep(rand(1, 10));
}

function sendTask($task): void
{
    //TODO send message to queue
}

//Тут можно было бы сделать удобный итератор - интерфейс был бы очень простым в использовании, но мы без ООП
function findUsers(DaysBeforeEnd $daysBeforeSubscriptionEnd, int $page = 0): array
{
    $dateOfEndTS = strtotime("+$daysBeforeSubscriptionEnd->value days midnight");
    $firstDayOfTheMonth = strtotime("'first day of this month'");
    //Для реального кода нужно уносить в конфиги, упрощено для тестового задания.
    $connection = new PDO('mysql:host=localhost;dbname=mail', 'root', 'root');

    $offset = $page * QUERY_LIMIT;

    $fieldName = 'last_sent_' . $daysBeforeSubscriptionEnd->value; //колхозное решение, но гибкое, можно добавить новые дни, код продолжит работать
    //Prepared statements умышленно опущены
    return $connection
        ->prepare('SELECT email, checked FROM `users` WHERE confirmed = 1 AND validts < ' . $dateOfEndTS .'AND '. $fieldName.' <' . $firstDayOfTheMonth . ' LIMIT ' . QUERY_LIMIT . ' OFFSET '.$offset)
        ->fetchAll();
    //TODO можно также исключить пользователей с невалидными емаилами, если реализовать запись информации о них в БД
}

function markAsChecked(string $email): void
{
    //TODO записываем, что емаил провалидирован
}

function markAsSent(string $email, DaysBeforeEnd $days, int $timestamp): void
{
    //TODO записываем дату последней отправки. Нужны два новых флаговых поля или одно поле в виде битовой маски.
    //TODO Необходимо для выборки, чтобы повторно не отправить в
    //TODO промежутке между 1 и 3 днями до окончания рассылки и 1 и 0

    //Решение подходит только для такой синтетической задачи, в реальном проекте, я бы писал всю историю отправок
    //коммуникаций в отдельную таблицу. Можно банально анализировать работают ли подобные рассылки или нет, делать АБ
    //тесты контента и т.д.
}

enum DaysBeforeEnd: int
{
    case THREE = 3;
    case ONE = 1;
}
