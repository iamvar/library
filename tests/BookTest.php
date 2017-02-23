<?php

use PHPUnit\Framework\TestCase;
use \Iamvar\Library\Book;

/**
 * @covers Book
 */
final class BookTest extends TestCase
{
    private $validData = [
        'author' => 'William Shakespeare',
        'title' => 'Othello',
        'year' => 2010,
        'isbn' => '2-266-11156-6',
    ];

    private $invalidData = [
        'author' => '',
        'title' => '',
        'year' => 3001,
        'isbn' => '2266111569',
    ];

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Year is wrong
     */
    public function testCreateBookWithWrongYear()
    {
        new Book(
            $this->validData['author'],
            $this->validData['title'],
            $this->invalidData['year'],
            $this->validData['isbn']
        );
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage ISBN is wrong
     */
    public function testCreateBookWithWrongIsbn()
    {
        new Book(
            $this->validData['author'],
            $this->validData['title'],
            $this->validData['year'],
            $this->invalidData['isbn']
        );
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Please, verify author
     */
    public function testCreateBookWithWrongAuthor()
    {
        new Book(
            $this->invalidData['author'],
            $this->validData['title'],
            $this->validData['year'],
            $this->validData['isbn']
        );
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Please, verify title
     */
    public function testCreateBookWithWrongTitle()
    {
        new Book(
            $this->validData['author'],
            $this->invalidData['title'],
            $this->validData['year'],
            $this->validData['isbn']
        );
    }

}