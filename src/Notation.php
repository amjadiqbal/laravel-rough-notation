<?php

namespace AmjadIqbal\RoughNotation;

class Notation
{
    protected static ?NotationManager $manager = null;
    protected static string $defaultTag = 'span';

    public static function make(string $type): NotationBuilder
    {
        return NotationBuilder::make($type);
    }

    protected static function manager(): NotationManager
    {
        if (!static::$manager) {
            static::$manager = new NotationManager();
        }
        return static::$manager;
    }

    public static function open(string $type, array $options = [], $group = null, ?string $tag = null): string
    {
        $tag = $tag ?: static::$defaultTag;
        $groupId = null;
        if ($group instanceof NotationGroup) {
            $groupId = $group->id();
        } elseif (is_string($group)) {
            $groupId = $group;
        }
        return static::manager()->openTag($type, $options, $groupId, $tag);
    }

    public static function close(?string $tag = null): string
    {
        $tag = $tag ?: static::$defaultTag;
        return static::manager()->closeTag($tag);
    }
}
