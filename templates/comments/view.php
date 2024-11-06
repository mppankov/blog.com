<?php include __DIR__ . '/../header.php'; ?>
    <?php if(!empty($error)): ?>
        <div style="color: red;"><?= $error ?></div>
    <?php endif; ?>
    <h1><?= $article->getName() ?></h1>
    <p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
    <h3><br>Комментарии к статье: </h3>
    <?php if($comments !== null) ?>
        <?php foreach ($comments as $comment): ?>
            <p><?= $comment->getText() ?></p>
            <p>Автор: <?=$comment->getAuthor()->getNickname()?></p>
            <?php if ($user !== null): ?>
                <p><a href="/comments/<?= $comment->getId() ?>/edit">Редактировать</a></p>
                <p><a href="/comments/<?= $comment->getId() ?>/delete">Удалить</a></p>
            <?php endif ?>
            <hr/>
        <?php endforeach; ?>
    <?php if ($user !== null): ?>
        <?php if(!empty($error)): ?>
            <div style="color: red;"><?= $error ?></div>
        <?php endif; ?>
        <form action="/articles/<?= $article->getId() ?>/comments/add" method="post">
        <label for="text">Добавить комментарий</label><br>
        <textarea name="text" id="text" rows="5" cols="50"><?= $_POST['text'] ?? '' ?></textarea><br>
        <br>
        <input type="submit" value="Отправить">
    </form>
    <?php else: ?>
    <p>Для добавление комментария войдите или зарегистрируйтесь.</p>
    <?php endif ?>
<?php include __DIR__ . '/../footer.php'; ?>