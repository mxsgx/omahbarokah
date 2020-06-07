<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var bool
     */
    public $dismissible;

    /**
     * Create a new component instance.
     *
     * @param string $type
     * @param bool $dismissible
     */
    public function __construct($type, $dismissible = false)
    {
        $this->type = $type;
        $this->dismissible = $dismissible;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
