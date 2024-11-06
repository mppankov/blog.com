<?php

namespace MyProject\Models\Comments;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
use MyProject\Models\Articles\Article;
use MyProject\Services\Db;
class Comments extends ActiveRecordEntity
{
    protected int $articleId;
    protected string $text;
    protected int $authorId;
    protected $createdAt = null;


    public function getArticle(): Article
    {
        return Article::getById($this->articleId);
    }

    public function setArticle(Article $article): void
    { 
        $this->articleId = $article->getId();
    }

    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    public function setAuthor(User $user): void
    {
        $this->authorId = $user->getId();
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    protected static function getTableName(): string
    {
        return 'comments';
    }

    public static function add(array $fields, int $articleId, User $user): Comments
    {
        if (empty($articleId)) {
            throw new InvalidArgumentException('Не передан id статьи!');
        }

        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст комментария!');
        }

        if (empty($user)) {
            throw new InvalidArgumentException('Не передан автор!');
        }

        $comments = new Comments();
        $comments->setAuthor($user);
        $comments->articleId = $articleId;
        $comments->setText($fields['text']);
        $comments->save();

        return $comments;
    }

    public function edit(array $fields): Comments
    {
        
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан комментарий');
        }

        $this->setText($fields['text']);
        $this->save();

        return $this;
    }

    public static function getAllCommentsByArticleId(int $articleId): array|null
    {
        $db = Db::getInstance();
        $comments = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE article_id=:id;',
            [':id' => $articleId],
            static::class
        );
        return $comments;
    }
}