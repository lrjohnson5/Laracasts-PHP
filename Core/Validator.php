<?php

/**
 * File Name: Validator.php
 * Description: Manages input validation.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 */

namespace Core;

class Validator {
    public static function string($value, $min = 1, $max = INF) {
        $value = trim($value);
        return strlen($value) >= $min && strlen($value) <= $max;
    }

    public static function email($value) {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}