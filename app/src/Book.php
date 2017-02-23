<?php

namespace Iamvar\Library;

use Iamvar\Library\Validation\ValidationHelper;

class Book
{
    /** @var string */
    private $author;

    /** @var int */
    private $year;

    /** @var int */
    private $isbn;

    /** @var string */
    private $title;

    /**
     * Book constructor.
     * @param $author
     * @param $title
     * @param $year
     * @param $isbn
     */
    public function __construct($author, $title, $year, $isbn)
    {
        $this->setAuthor($author)
            ->setTitle($title)
            ->setYear($year)
            ->setIsbn($isbn);
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return $this
     */
    public function setAuthor($author)
    {
        if (!$author || !is_string($author)) {
            throw new \InvalidArgumentException('Please, verify author');
        }

        $this->author = $author;
        return $this;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     * @return $this
     */
    public function setYear($year)
    {
        if (!ValidationHelper::year($year)) {
            throw new \InvalidArgumentException('Year is wrong');
        }

        $this->year = $year;
        return $this;
    }

    /**
     * @return int
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * @param int $isbn
     * @return $this
     */
    public function setIsbn($isbn)
    {
        if (!ValidationHelper::isbn($isbn)) {
            throw new \InvalidArgumentException('ISBN is wrong');
        }

        $this->isbn = $isbn;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        if (!$title || !is_string($title)) {
            throw new \InvalidArgumentException('Please, verify title');
        }

        $this->title = $title;
        return $this;
    }
}