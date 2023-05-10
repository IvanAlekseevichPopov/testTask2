# Решение задачи

Идея простая - делаем из БД запросы с limit offset на подходящих пользователей и отправляем в очередь. Т.к. выполнение ключевых
процедур длительное, то количеством консьмеров легко можно нивелировать длительность обработки. Если проект живет в 
кубере то настроенный автоскейлер решит проблему количества консьюмеров. 
Непонятно, зачем валидация почты в момент отправки, по хорошему это должно происходить при регистрации и пользователей 
с невалидными емаилами не должно быть в БД. Неясно, как юзер мог подтвердить емаил, но при этом его еще нужно проверить 
на валидность.
Крона раз в день достаточно, есть нюанс, что допустим крон отрабатывает утром, а пользователь зарегистрировался вечером,
тут надо разбираться с бизнесом, когда должна уйти коммуникация - утром этого дня или утром следующего. В коде это 
не отражено, т.к. требования не ясны.

Код будет не рабочим, т.к. тянуть реальные либы и все это коннектить - дело техники, и не хочется тратить время на 
этот никому не нужный код. 
Для передачи данных внутри кода используются массивы, т.к. DTO - это часть парадигмы ООП. Насколько не ООП нужно было 
сделать - непонятно, сделал на свое усмотрение. Я бы так ни за что делать не стал в реальном проекте.