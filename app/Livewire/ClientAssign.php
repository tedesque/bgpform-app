<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\bgpRequest;

class ClientAssign extends Component
{

    public $token;

    public $device;
    public $router_table;
    public $asn;
    public $prefix = [];

    public function mount($token)
    {
        $this->token = $token;

        $bgpRequest = bgpRequest::where('token', $token)->firstOrFail();

        if ($bgpRequest->status === 'Concluída') {
            abort(403, 'Esta solicitação já foi concluída.');
        }

        if ($bgpRequest) {
            $this->device = $bgpRequest->device;
            $this->router_table = $bgpRequest->router_table;
            $this->asn = $bgpRequest->asn;
            $this->prefix = $bgpRequest->prefixes->map(function($prefix) {
                return [
                    'prefix' => $prefix->prefix,
                ];
            })->toArray();
        } else {
            // Inicializar com um prefixo vazio
            $this->prefix = [
                ['prefix' => ''],
            ];
        }
    }


    public function render()
    {
        return view('livewire.client-assign');
    }
}
