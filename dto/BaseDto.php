<?php

namespace dto;

use ReflectionClass;

class BaseDto
{
    public function getVariableName(string $getterMethod): ?string
    {
        $reflection = new ReflectionClass($this);

        if ($reflection->hasMethod($getterMethod)) {

            return lcfirst(substr($getterMethod, 3));
        }

        return null;
    }
}