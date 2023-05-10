<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Cart extends Component
{
    protected $listeners = [
        'updateCart' => 'render',
        // 'refresh-me' => '$refresh'
    ];
    
    public function update()
    {
        $this->emitSelf('refresh-me');
    }

    public function render()
    {
        $result=topNavCart();
        // $result=topNavCart();
        // prx($result);
        return view('livewire.cart',$result);
    }
}
