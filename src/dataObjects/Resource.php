<?php

namespace jr\ooapi\dataObjects;

class Resource
{
    /** @var int */
    private $type = 0;

    /** @var string */
    private $id = '';

    public function __construct(int $id, string $type = '')
    {
        $this->type = $type;
        $this->id = $id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getId(): int
    {
        return $this->id;
    }
}