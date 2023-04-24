<?php

namespace Fpaipl\Features\Http\Livewire;

use Livewire\Component;

class AlertBox extends Component
{
    public $redirect_route;

    public function mount()
    {
        
    }

    public function confirmDialog(){
        if (session()->has('redirect_route')) {
            return redirect()->to(session('redirect_route'));
        }
    }

    public function render()
    {
        return view('features::livewire.alert-box');
    }
}
