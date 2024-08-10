<?php include __DIR__ . '/../header.php'; ?>
<?php foreach ($articles as $article): ?>
    <h2><a href="/articles/<?= $article->getId() ?>"><?= $article->getName() ?></h2>
    <p><?= $article->getParsedText() ?></p>
    <hr>
<?php endforeach; ?>

<div style="text-align: center">
    <?php if ($previousPageLink !== null): ?>
        <a href="<?= $previousPageLink ?>">&lt; Назад</a>
    <?php else: ?>
        <span style="color: grey">&lt; Назад</span>
    <?php endif; ?>
    &nbsp;&nbsp;&nbsp;
    <?php if ($nextPageLink !== null): ?>
        <a href="<?= $nextPageLink ?>">Вперед &gt;</a>
    <?php else: ?>
        <span style="color: grey">Вперед &gt;</span>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?>