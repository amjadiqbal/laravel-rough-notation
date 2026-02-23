<?php

namespace AmjadIqbal\RoughNotation;

class NotationGroup
{
    protected string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function make(string $id): self
    {
        return new self($id);
    }

    public function id(): string
    {
        return $this->id;
    }
}
