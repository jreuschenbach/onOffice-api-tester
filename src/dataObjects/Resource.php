<?php

namespace jr\ooapi\dataObjects;

/**
 * Class Resource
 *
 * data-object for json-resource-tag
 *
 * @package jr\ooapi\dataObjects
 */

class Resource
{
    /** @var string */
    private $type = '';

    /** @var string */
    private $id = '';

    public function __construct(string $id, string $type = '')
    {
        $this->type = $type;
        $this->id = $id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getId(): string
    {
        return $this->id;
    }
}