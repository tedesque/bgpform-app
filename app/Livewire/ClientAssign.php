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
            
        } else {
            // Inicializar com um prefixo vazio
            $this->prefix = [
                ['prefix' => ''],
            ];
        }
    }

    public function addPrefix()
    {
        $this->prefix[] = ['ip_prefix' => ''];
    }

    public function removePrefix($index)
    {
        unset($this->prefix[$index]);
        $this->prefix = array_values($this->prefix);
    }

    public function submit()
    {

        // Buscar a solicitação pelo token
        $bgpRequest = BgpRequest::where('token', $this->token)->firstOrFail();

        // Atualizar ou criar os detalhes do cliente
        $assign = $bgpRequest->updateOrCreate(
            ['id' => $bgpRequest->id],
            [
                'device' => $this->device,
                'router_table' => $this->router_table,
                'asn' => $this->asn,
            ]
        );

        // Em seguida, criar os novos prefixos
        foreach ($this->prefix as $prefixData) {
            if (!empty($prefixData['type']) && !empty($prefixData['prefix'])) {
                $bgpRequest->prefixes()->create([
                    'prefix' => $prefixData['prefix'],
                ]);
            }
        }

        // Atualizar o status da solicitação
        $bgpRequest->update(['status' => 'concluido']);

        // Redirecionar ou exibir uma mensagem de sucesso
        session()->flash('success', 'Dados enviados com sucesso!');
    }

    public function render()
    {
        return view('livewire.client-assign')->layout('layouts.guest');
    }
}
