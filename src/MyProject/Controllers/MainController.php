<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Controllers\AbstractController;

class MainController extends AbstractController
{
    public function main()
    {
        $lastID = Article::getLastID();
        
        if ($lastID === null) {
            throw new NotFoundException();
        }
        $this->after($lastID + 1);
    }

    public function page(array $articles): void
    {
        if ($articles === []) {
            throw new NotFoundException();
        }
    
        $firstID = $articles[0]->getId();
        $lastID = $articles[count($articles)-1]->getId();
    
        $this->view->renderHtml('main/main.php', [
            'articles' => $articles,
            'previousPageLink' => Article::hasPreviousPage($firstID) ? '/before/' . $firstID : null,
            'nextPageLink' => $lastID > 1 ? '/after/' . $lastID : null,
        ]);
    }

    public function before(int $id): void
    {
        $this->page(Article::getPageBefore($id, 5));
    }

    public function after(int $id): void
    {
        $this->page(Article::getPageAfter($id, 5));
    }
}