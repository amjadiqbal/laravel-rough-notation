<?php

namespace AmjadIqbal\RoughNotation;

class NotationBuilder
{
    protected string $type;
    protected array $options = [];
    protected ?string $groupId = null;
    protected string $tag = 'span';
    protected NotationManager $manager;

    public function __construct(string $type)
    {
        $this->type = $type;
        $this->manager = new NotationManager();
    }

    public static function make(string $type): self
    {
        return new self($type);
    }

    public function color(string $color): self
    {
        $this->options['color'] = $color;
        return $this;
    }

    public function strokeWidth(int $width): self
    {
        $this->options['strokeWidth'] = $width;
        return $this;
    }

    public function padding(int $padding): self
    {
        $this->options['padding'] = $padding;
        return $this;
    }

    public function iterations(int $iterations): self
    {
        $this->options['iterations'] = $iterations;
        return $this;
    }

    public function brackets($brackets): self
    {
        $this->options['brackets'] = $brackets;
        return $this;
    }

    public function animationDuration(int $ms): self
    {
        $this->options['animationDuration'] = $ms;
        return $this;
    }

    public function group($group): self
    {
        if ($group instanceof NotationGroup) {
            $this->groupId = $group->id();
        } elseif (is_string($group)) {
            $this->groupId = $group;
        }
        return $this;
    }

    public function tag(string $tag): self
    {
        $this->tag = $tag;
        return $this;
    }

    public function open(): string
    {
        return $this->manager->openTag($this->type, $this->options, $this->groupId, $this->tag);
    }

    public function close(): string
    {
        return $this->manager->closeTag($this->tag);
    }

    public function render(string $content): string
    {
        return $this->open() . $content . $this->close();
    }
}
