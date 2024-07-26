<?php

namespace App\View\Components;

use Closure;
use App\Models\cart;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class cartm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $data=cart::all();
        $user=Auth::user();
        return view('components.cartm',compact('data'));
    }
}
