<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 15/4/18
 * Time: 9:59 PM
 */
class ValidatorCustom extends Illuminate\Validation\Validator {
    public function validateDumb($attribute, $value, $params) {
        return $value < $params[0];
    }

    public function validateDumber($attribute, $value, $params) {
        return $value < $params[0];
    }

    public function replaceDumb($message, $attribute, $rule, $parameters) {
        return str_replace(':dumb', $parameters[0], $message);
    }
    public function replaceDumber($message, $attribute, $rule, $parameters) {
        return str_replace(':dumber', $parameters[0], $message);
    }
}