<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Controllers\AbstractController;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comments;

class CommentsController extends AbstractController
{
    public function view(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $comments = Comments::getAllCommentsByArticleId($articleId);

        $this->view->renderHtml('comments/view.php', ['article' => $article, 'comments' => $comments]);
    }

    public function add($articleId): void
    {
        $article = Article::getById($articleId);
        $comments = Comments::getAllCommentsByArticleId($articleId);

        if ($this->user === null){
            throw new UnauthorizedException();
        }

        if ($articleId === null) {
            throw new NotFoundException();
        }

        if(!$this->user->isAdmin()){
            throw new ForbiddenException('Для добавления комментария нужно обладать правами администратора!');
        }

        if (!empty($_POST)) {
            try {
                Comments::add($_POST, $articleId, $this->user);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('comments/view.php', ['error' => $e->getMessage(), 'article' => $article, 'comments' => $comments]);
                return;
            }
    
            header('Location: /articles/' . $articleId . '/comments', true, 302);
            exit();
        }

        $this->view->renderHtml('/articles/' . $articleId . '/comments.php');
    }

    public function delete(int $commentId): void
    {
        $comment = Comments::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException();
        } else {
            $this->view->renderHtml('errors/commentsDelete.php', [], 404);
            $comment->delete();
        }
    }

    public function edit(int $commentsId): void
    {
        $comment = Comments::getById($commentsId);
        $article = $comment->getArticle();

        if ($comment === null) {
            throw new NotFoundException();
        }

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if(!$this->user->isAdmin()) {
            throw new ForbiddenException('Для редактирования комментария нужно обладать правами администратора');
        }

        if (!empty($_POST)) {
            try {
                
                $comment->edit($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('article/edit.php', ['error' => $e->getMessage(), 'comment' => $comment]);
                return;
            }

            header('Location: /articles/' . $article->getId() . '/comments', true, 302);
            exit();
        }
    
        $this->view->renderHtml('/comments/edit.php', ['article' => $article, 'comment' => $comment]);
    }

}