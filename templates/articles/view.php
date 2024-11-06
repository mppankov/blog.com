<?php include __DIR__ . '/../header.php'; ?>
    <h1><?= $article->getName() ?></h1>
    <p><?= $article->getParsedText()  ?></p>
    <p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
    <p><a href="/articles/<?= $article->getId() ?>/comments">Комментарии</a></p>
    <?php if ($user !== null && $user->isAdmin()): ?>
    <p><a href="/articles/<?= $article->getId() ?>/edit">Редактировать</a></p>
    <p><a href="/articles/<?= $article->getId() ?>/delete">Удалить</a></p>
    <?php endif ?>
<?php include __DIR__ . '/../footer.php'; ?>