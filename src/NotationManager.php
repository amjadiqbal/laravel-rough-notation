<?php

namespace AmjadIqbal\RoughNotation;

class NotationManager
{
    private const TYPES = ['underline', 'box', 'circle', 'highlight', 'strike-through', 'crossed-off', 'bracket'];
    private const OPTION_KEYS = ['color', 'strokeWidth', 'padding', 'iterations', 'brackets', 'animationDuration'];

    public function normalizeType(string $type): string
    {
        $t = strtolower($type);
        $map = [
            'strikethrough' => 'strike-through',
            'strike_through' => 'strike-through',
            'crossedoff' => 'crossed-off',
            'crossed_off' => 'crossed-off',
        ];
        if (isset($map[$t])) {
            $t = $map[$t];
        }
        return $t;
    }

    public function validateType(string $type): bool
    {
        return in_array($type, self::TYPES, true);
    }

    public function toJsonOptions(array $options, string $type): string
    {
        $filtered = [];
        foreach (self::OPTION_KEYS as $key) {
            if (array_key_exists($key, $options)) {
                $value = $options[$key];
                if ($key === 'brackets') {
                    if ($this->normalizeType($type) === 'bracket') {
                        if (is_string($value)) {
                            $filtered[$key] = [$value];
                        } elseif (is_array($value)) {
                            $filtered[$key] = array_values($value);
                        }
                    }
                } else {
                    $filtered[$key] = $value;
                }
            }
        }
        return json_encode($filtered, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function openTag(string $type, array $options = [], ?string $groupId = null, string $tag = 'span'): string
    {
        $type = $this->normalizeType($type);
        if (!$this->validateType($type)) {
            $type = 'underline';
        }
        $attrs = [];
        $attrs[] = 'data-rough-type="' . htmlspecialchars($type, ENT_QUOTES, 'UTF-8') . '"';
        $optionsJson = $this->toJsonOptions($options, $type);
        $attrs[] = "data-rough-options='" . htmlspecialchars($optionsJson, ENT_QUOTES, 'UTF-8') . "'";
        if ($groupId) {
            $attrs[] = 'data-rough-group="' . htmlspecialchars($groupId, ENT_QUOTES, 'UTF-8') . '"';
        }
        return '<' . $tag . ' class="rough-notation" ' . implode(' ', $attrs) . '>';
    }

    public function closeTag(string $tag = 'span'): string
    {
        return '</' . $tag . '>';
    }
}
