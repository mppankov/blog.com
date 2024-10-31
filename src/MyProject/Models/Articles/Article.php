<?php

namespace MyProject\Models\Articles;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;

class Article extends ActiveRecordEntity
{
    protected string $name;
    protected string $text;
    protected int $authorId;
    protected $createdAt = null;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    public function setAuthor(User $user): void
    {
        $this->authorId = $user->getId();
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }

    public static function createFromArray(array $fields, User $author): Article
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Не передано название статьи');
        }

        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст статьи');
        }

        $article = new Article();
        $article->setAuthor($author);
        $article->setName($fields['name']);
        $article->setText($fields['text']);
        $article->save();

        return $article;
    }

    public function updateFromArray(array $fields): Article
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Не передано название статьи');
        }

        if (empty($fields['text'])) {           
            throw new InvalidArgumentException('Не передан текст статьи');
        }

        $this->setName($fields['name']);
        $this->setText($fields['text']);
        $this->save();

        return $this;
    }

    public function getParsedText(): string
{
    $parser = new \Parsedown();
    return $parser->text($this->getText());
}
}