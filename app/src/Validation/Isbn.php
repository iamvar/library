<?php

namespace Iamvar\Library\Validation;

/**
 * Class Isbn
 * @package Iamvar\Library\Validation
 *
 * Has validation methods for ISBN
 */
class Isbn
{
    /**
     * @param string $isbn
     * @return bool
     */
    public static function validate($isbn)
    {
        if (strlen($isbn) === 13) {
            return self::validateIsbn13($isbn);
        }

        if (strlen($isbn) === 10) {
            return self::validateIsbn10($isbn);
        }

        return false;
    }

    /**
     * @param $isbn
     * @return bool
     */
    public static function validateIsbn13($isbn)
    {
        if(is_string($isbn) === false) {
            throw new \InvalidArgumentException('Invalid parameter type.');
        }

        //Verify ISBN-13 scheme
        if (preg_match('/^\d{13}$/', $isbn) === false) {
            return false;
        }

        //Verify checksum
        $check = 0;
        for ($i = 0; $i < 13; $i += 2) {
            $check += substr($isbn, $i, 1);
        }

        for ($i = 1; $i < 12; $i += 2) {
            $check += 3 * substr($isbn, $i, 1);
        }

        return $check % 10 === 0;
    }

    /**
     * @param string $isbn
     * @return bool
     */
    public static function validateIsbn10($isbn)
    {
        //Verify ISBN-10 scheme
        if (preg_match('/^\d{10}$/', $isbn) === false) {
            return false;
        }

        //Verify checksum
        $check = 0;
        for ($i = 0; $i < 10; $i++) {
            $check += $isbn[$i] * (10 - $i);
        }

        return $check % 11 === 0;
    }
}