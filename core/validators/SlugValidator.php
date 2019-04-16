<?php


namespace core\validators;

use yii\validators\RegularExpressionValidator;

class SlugValidator
{
    public $pattern = '#^[a-z0-9_-]*$#s';
    public $message = 'Only [a-z0-9_-] symbols are allowed.';

}