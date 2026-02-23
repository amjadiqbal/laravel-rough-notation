<?php

namespace AmjadIqbal\RoughNotation\View\Components;

use Illuminate\View\Component;

class Annotate extends Component
{
    public string $type;
    public array $options;
    public $group;
    public string $tag;

    public function __construct(string $type, array $options = [], $group = null, string $tag = 'span')
    {
        $this->type = $type;
        $this->options = $options;
        $this->group = $group;
        $this->tag = $tag;
    }

    public function render()
    {
        return view('rough-notation::components.annotate');
    }
}
