<?php

namespace App\Core;

class Dto {
    public static function create(array $values): static {
        $dto = new static();

        foreach ($values as $key => $value) {
            if(property_exists($dto, $key)) {
                $dto->{$key} = $value;
            }
        }
        
        return $dto;
    }

    public static function createArray(array $values): array { 
        $dtos = [];
        foreach ($values as $value) {
            $dto = static::create($value);
            array_push($dtos, $dto);
        }
        return $dtos;
    }

    public function toArray() {
        return get_object_vars($this);
    }
}