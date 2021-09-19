<DOCTYPE html>
<html lang="ru-RU">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
    <?php if (!$feedback->anonymous) { ?>
        <h3>Email: </h3><p><?= $feedback->email ?></p>
        <h3>Телефон: </h3><p><?= $feedback->phone ?></p>
        <h3>Имя: </h3><p><?= $feedback->first_name ?></p>
        <h3>Фамилия: </h3><p><?= $feedback->last_name ?></p>
        <h3>Отчество: </h3><p><?= $feedback->middle_name ?></p>
    <?php } ?>
    <h3>Сообщение:</h3>
    <p><?= $feedback->message ?></p>
</body>
</html>
