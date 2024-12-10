<?php

namespace App\Core;

class DTO {
    public static function create(array|null $values): static|null {
        if ($values === null) {
            return null;
        }

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