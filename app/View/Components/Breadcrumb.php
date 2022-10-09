<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $message;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($message = '')
    {
        $this->message = $message;
    }
    public function getData()
    {
        return explode(',', $this->message);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.breadcrumb');
    }
}
