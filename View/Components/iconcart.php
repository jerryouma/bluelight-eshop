<?php

namespace App\View\Components;

use Closure;
use App\Models\cart;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class iconcart extends Component
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
        $count =0;
        if (Auth::check()) {
        $user=Auth::user();
        $userid=$user->id;
        $count= cart::where('user_id',$userid)->count();
        }
        return view('components.iconcart',compact('count'));
    }
}
