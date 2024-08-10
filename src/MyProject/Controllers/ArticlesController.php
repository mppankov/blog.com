<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Controllers\AbstractController;

class ArticlesController extends AbstractController
{
    public function view(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {

            throw new NotFoundException();
        }

        $this->view->renderHtml('articles/view.php', ['article' => $article]);
    }

    public function edit(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {

            throw new NotFoundException();
        }

        if ($this->user === null) {

            throw new UnauthorizedException();
        }

        if(!$this->user->isAdmin()) {

            throw new ForbiddenException('Для редактирования статьи нужно обладать правами администратора');
        }
    
        if (!empty($_POST)) {

            try {

                $article->updateFromArray($_POST);

            } catch (InvalidArgumentException $e) {

                $this->view->renderHtml('/articles/edit.php', ['error' => $e->getMessage(), 'article' => $article]);
                return;
            }
    
            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }
    
        $this->view->renderHtml('/articles/edit.php', ['article' => $article]);
    }

    public function add(): void
    {
        if ($this->user === null) {

            throw new UnauthorizedException();
        }

        if(!$this->user->isAdmin()) {

            throw new ForbiddenException('Для добавления статьи нужно обладать правами администратора');
        }

        if (!empty($_POST)) {

            try {

                $article = Article::createFromArray($_POST, $this->user);

            } catch (InvalidArgumentException $e) {

                $this->view->renderHtml('/articles/add.php', ['error' => $e->getMessage()]);
                return;
            }
    
            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('/articles/add.php');
    }

    public function delete(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {

            throw new NotFoundException();

        } else {

            $this->view->renderHtml('errors/delete.php', [], 404);
            $article->delete();
        }
    }
}