<?php

use Iamvar\Library\Book;
use Slim\Http\Request;
use Slim\Http\Response;

$app->post('/scan', function (Request $request, Response $response) {
    $this->logger->addInfo("Trying to scan with following request: ", $request->getParsedBody());

    $data = $request->getParsedBody();

    $year = filter_var($data['year'], FILTER_VALIDATE_INT);
    $isbn = filter_var($data['isbn'], FILTER_SANITIZE_STRING);
    $title = filter_var($data['title'], FILTER_SANITIZE_STRING);
    $author = filter_var($data['author_full_name'], FILTER_SANITIZE_STRING);

    try {
        $book = (new Book($author, $title, $year, $isbn));
        $this->librarian->addBook($book);
    } catch (\Exception $e) {
        $this->logger->addInfo("Error while adding the book: ", ['error' => $e->getMessage()]);
        throw $e;
    }

    return $response;
});

$app->get('/authorsTop100', function (Request $request, Response $response) {
    $authors = $this->librarian->getAuthorsTop100();

    return $response->withJson($authors);
});

$app->get('/authorYearlyBooks', function (Request $request, Response $response) {
    $author = $request->getQueryParam('author');
    $author = filter_var($author, FILTER_SANITIZE_STRING);

    $books = $this->librarian->getYearlyBooksByAuthor($author);

    return $response->withJson($books);
});

$app->get('/books', function (Request $request, Response $response) {
    $author = $request->getQueryParam('author');
    $author = filter_var($author, FILTER_SANITIZE_STRING);

    $from = $request->getQueryParam('from');
    $from = filter_var($from, FILTER_VALIDATE_INT);

    $to = $request->getQueryParam('to');
    $to = filter_var($to, FILTER_VALIDATE_INT);

    $books = [];
    if ($author) {
        $books = $this->librarian->getBooksByAuthor($author);
    } elseif ($from || $to) {
        $books = $this->librarian->getBooksByYears($from, $to);
    } else {
        $books = $this->librarian->getBooks();
    }

    return $response->withJson($books);
});