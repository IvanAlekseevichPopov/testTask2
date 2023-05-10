<?php

require_once 'lib.php';

$i = 0;

foreach (DaysBeforeEnd::cases() as $days) {
    do {
        $users = findUsers($days, $i);
        foreach ($users as $user) {
            $task = [
                'to' => $users['email'],
                'from' => 'ourservice@gmail.com',
                'days' => $days,
                'is_valid' => $users['checked'],
                'text' => 'Your subscription going to end in ' . $days->value . ' days'
            ];
            sendTask($task);
        }
    } while (count($users) > 0);
}



