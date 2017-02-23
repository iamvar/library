<?php

namespace Iamvar\Library\Services;

use Iamvar\Library\Book;
use Iamvar\Library\Validation\ValidationHelper;
use PDO;

class Librarian
{
    /** @var PDO */
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Adds new book in our library
     *
     * @param Book $book
     */
    public function addBook(Book $book)
    {
        $stmt = $this->db->prepare('INSERT INTO books (author, title, year, isbn, created) VALUES (:author, :title, :year, :isbn, :created)');
        $stmt->bindParam(':author', $book->getAuthor());
        $stmt->bindParam(':title', $book->getTitle());
        $stmt->bindParam(':year', $book->getYear());
        $stmt->bindParam(':isbn', $book->getIsbn());
        $stmt->bindParam(':created', date('Y-m-d H:i:s'));

        $stmt->execute();
    }

    /**
     * Get top 100 authors who have most number of books
     *
     * @return array
     */
    public function getAuthorsTop100()
    {
        return $this->getAuthorsTop(100);
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getAuthorsTop($limit = 10)
    {
        $sql = "SELECT author, count(id) AS books
             FROM books
             GROUP BY author ORDER BY books DESC LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @param $author
     * @return array
     */
    public function getBooksByAuthor($author)
    {
        $sql = "SELECT author, title, isbn, created
             FROM books
             WHERE author LIKE :author";

        $stmt = $this->db->prepare($sql);
        $author = "%$author%";
        $stmt->bindParam(':author', $author);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Get books in a range of years
     *
     * @param null $from
     * @param null $to
     * @return array
     */
    public function getBooksByYears($from = null, $to = null)
    {
        if (!$from && !$to) {
            throw new \InvalidArgumentException('At least one parameter (from or to) should be specified.');
        }

        $conditions = [];

        if ($from) {
            if (!ValidationHelper::year($from)) {
                throw new \InvalidArgumentException("'From' year is wrong");
            }

            $conditions[] = 'year >= :from';
        }

        if ($to) {
            if (!ValidationHelper::year($to)) {
                throw new \InvalidArgumentException("'To' year is wrong");
            }

            $conditions[] = 'year <= :to';
        }

        $sql = "SELECT title, isbn
             FROM books
             WHERE " . implode(' AND ', $conditions);

        $stmt = $this->db->prepare($sql);

        if ($from) {
            $stmt->bindParam(':from', $from);
        }

        if ($to) {
            $stmt->bindParam(':to', $to);
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Get number of books per year by an author
     *
     * @param $author
     * @return array
     */
    public function getYearlyBooksByAuthor($author)
    {
        $sql = "SELECT count(id) AS books, year
             FROM books WHERE author = :author
             GROUP BY year ORDER BY year";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':author', $author);
        $stmt->execute();

        $result = [];

        foreach ($stmt->fetchAll() as $row) {
            $result[$row['year']] = [
                'author' => $author,
                'books' => $row['books']
            ];
        }

        return $result;
    }

    /**
     * Get all books from our library
     *
     * @return array
     */
    public function getBooks()
    {
        $sql = "SELECT title, author, isbn, created FROM books";

        return $this->db->query($sql)->fetchAll();
    }
}