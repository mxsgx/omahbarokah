<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LinkButton extends Component
{
    /**
     * The URL.
     *
     * @var string
     */
    public $href;

    /**
     * The type of button.
     *
     * @var string
     */
    public $type;

    /**
     * Link content.
     *
     * @var string
     */
    public $text;

    /**
     * Create a new component instance.
     *
     * @param string $href
     * @param string $type
     * @param string $text
     * @return void
     */
    public function __construct($href, $text, $type = 'primary')
    {
        $this->href = $href;
        $this->type = $type;
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.link');
    }
}
