<?php

namespace App\DTO;

use App\Core\DTO;

class EventDTO extends DTO {
    public int $id;
    public int $teamOneId;
    public string $teamOneName;
    public int $teamTwoId; 
    public string $teamTwoName;
    public array $outcomes = [];

    public static function create(array $values): static {
        $dto = new static();
        foreach ($values as $key => $value) {
            
            if(property_exists($dto, $key)) {
                $dto->{$key} = $value;
            }

            if(preg_match("/outcome(\w+)/", $key, $matches)) {
                $slices = explode("//", $value);
                $dto->outcomes[$matches[1]] = [
                    "coefficient" => $slices[0],
                    "name" => $matches[1],
                    "label" => isset($slices[1]) ? $slices[1] : 1.5,
                ];
            }
        }
        
        return $dto;
    }
}