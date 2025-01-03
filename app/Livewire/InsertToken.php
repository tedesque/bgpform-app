<?php

namespace App\Livewire;

use App\Models\BgpRequest;
use Livewire\Component;

class InsertToken extends Component
{
    public $token;

    public function submit()
    {
        $BgpRequest = BgpRequest::where('token', $this->token)->firstOrFail();
        session()->flash('success', "Token recebido, edição do circuito: {$BgpRequest->circuit_id}.");
        $this->redirect("/assign/{$this->token}");
    }

    public function render()
    {
        return view('livewire.insert-token')->layout('layouts.client');
    }
}
