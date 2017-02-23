<?php

namespace Iamvar\Library\Validation;

/**
 * Class Validation
 * @package Iamvar\Library\Validation
 *
 * Has helper validation methods
 */
class ValidationHelper
{
    /**
     * @param string $isbn
     * @return bool
     */
    public static function isbn ($isbn)
    {
        return Isbn::validate($isbn);
    }

    /**
     * @param $year
     * @return mixed
     */
    public static function year ($year)
    {
        return filter_var($year, FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => '1967',
                'max_range' => date('Y')
            ]
        ]);
    }
}