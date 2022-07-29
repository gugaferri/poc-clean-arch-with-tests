<?php

namespace Core\UseCase\DTO\Category\UpdateCategory;

class UpdateCategoryInputDto
{
    public function __construct(
        public string $uuid,
        public string $name
    ) {}
}
