<?php

class Validator
{
    protected $errors = [];
    protected $rules_list = ['required', 'min', 'max', 'email'];

    public function validate($data = [], $rules = [])
    {
        foreach ($data as $fieldname => $value) {
            if (in_array($fieldname, array_keys($rules))) {
                $this->check([
                    'fieldname' => $fieldname,
                    'value' => $value,
                    'rules' => $rules[$fieldname],


                ]);
            }
        }
    }



    protected function check($field)
    {
        foreach ($field['rules'] as $rule => $rule_value) {
            if (in_array($rule, $this->rules_list)) {
                if (call_user_func_array([$this, $rule], [$field['value'], $rule_value])) {
                    $this->addError($field['fieldname'], $rule);
                }
            }
        }
    }

    protected function addError($fieldname, $errors)
    {
        $this->errors[$fieldname][] = $errors;
    }
    protected function required($value, $rule_value)
    {
        return !empty(trim($value));
    }
    protected function min($value, $rule_value)
    {
        return mb_strlen($value, 'UTF-8') >= $rule_value;
    }
    protected function max($value, $rule_value)
    {
        return mb_strlen($value, 'UTF-8') <= $rule_value;
    }

    protected function email($value, $rule_value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
