<?php

/**
 * File Name: LoginForm.php
 * Description: Manages login form validation and handling.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 */

namespace Http\Forms;

use Core\ValidationException;
use Core\Validator;

class LoginForm
{
    protected $errors = [];
    public function __construct(public array $attributes) {
        if (!Validator::email($attributes['email'])) {
            $this->$errors['email'] = "Please proved a valid email address.";
        }

        if (!Validator::string($attributes['password'])) {
            $this->$errors['password'] = "Password must be a valid match.";
        }
    }

    public static function validate($attributes)
    {
        $instance = new static($attributes);

        return $instance->failed() ? $instance->throw() : $instance;
    }

    public function throw()
    {
        ValidationException::throw($this->errors(), $this->attributes);
    }

    public function failed()
    {
        return count($this->errors);
    }

    public function errors() {
        return $this->errors;
    }

    public function error($field, $message) {
        $this->errors[$field] = $message;
        return $this;
    }
}