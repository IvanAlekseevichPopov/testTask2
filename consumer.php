<?php

require_once 'lib.php';

// Подразумевается, что функция будет использоваться как коллбэк в консьюмере, например реббита
function consume(array $message)
{
//TODO в подобной упрощенной реализации может произойти частичное выполнение,
//TODO можно добавить транзакционность, чтобы избежать этого(Transactional outbox pattern)
    if ($message['is_valid'] == 1) {
        send_email($message['from'], $message['to'], $message['text']);
        markAsSent($message['to'], $message['days'], time());
        ack($message['id']);

        return;
    }

    if (check_email($message['to'])) {
        markAsChecked($message['to']);
        send_email($message['from'], $message['to'], $message['text']);
        markAsSent($message['to'], $message['days'], time());
        ack($message['id']);

        return;
    }

    //TODO dead queue или
    //TODO логгируем и аскаем сообщение или
    //TODO помечаем пользователя как невалидного, чтобы избежать повторных проверок, которые стоят денег
}

//Эта функция - условность.
function ack(array $message)
{
    //TODO ack message
}