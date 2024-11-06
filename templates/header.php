<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Блог</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">
        <a href="/">Блог</a>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
        <?php if (!empty($user)) { ?> Привет, <?= $user->getNickname() ?> | <a href="/users/logout">Выйти</a>
<?php } else { ?>
    <a href="/users/login">Войдите на сайт</a> | <a href="/users/register">Зарегестрируйтесь</a>
<?php } ?>
        </td>
    </tr>
    <tr>
        <td>