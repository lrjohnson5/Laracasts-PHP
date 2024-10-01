<?php

namespace Http\Forms;

use Core\Validator;

class LoginForm
{
    protected $errors = [];
    public function validate($email, $password) {
        if (!Validator::email($email)) {
            $this->$errors['email'] = "Please proved a valid email address.";
        }

        if (!Validator::string($password)) {
            $this->$errors['password'] = "Password must be a valid match.";
        }

        return empty($this->errors);
    }

    public function errors() {
        return $this->errors;
    }
}