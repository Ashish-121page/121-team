<?php

namespace App\View\Components;

use Illuminate\View\Component;

class supcard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $phone;
    public $name;
    public $request_date;
    public $shoplink;
    public $profile;


    public function __construct($phone = null,$name = null,$request_date = null,$shoplink = null,$profile = null)
    {
        $this->phone = $phone;
        $this->name = $name;
        $this->request_date = $request_date;
        $this->shoplink = $shoplink;
        $this->profile = $profile;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.supcard');
    }
}
