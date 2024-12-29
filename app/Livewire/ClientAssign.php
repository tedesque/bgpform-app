<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BgpRequest;

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

        $BgpRequest = BgpRequest::where('token', $token)->firstOrFail();

        if ($BgpRequest->request_status === 'Concluida') {
            abort(403, 'Esta solicitação já foi concluída.');
        }

        if ($BgpRequest) {
            $this->device = $BgpRequest->device;
            $this->router_table = $BgpRequest->router_table;
            $this->asn = $BgpRequest->asn;
            
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
        $BgpRequest = BgpRequest::where('token', $this->token)->firstOrFail();

        // Atualizar ou criar os detalhes do cliente
        $assign = $BgpRequest->updateOrCreate(
            ['id' => $BgpRequest->id],
            [
                'device' => $this->device,
                'router_table' => $this->router_table,
                'asn' => $this->asn,
            ]
        );

        // Em seguida, criar os novos prefixos
        foreach ($this->prefix as $prefixData) {
            if (!empty($prefixData['ip_prefix'])) {
                $BgpRequest->prefixes()->create([
                    'ip_prefix' => $prefixData['ip_prefix'],
                ]);
            }
        }

        // Atualizar o status da solicitação
        $BgpRequest->update(['request_status' => 'Concluida']);

        // Redirecionar ou exibir uma mensagem de sucesso
        session()->flash('success', 'Dados enviados com sucesso!');
    }

    public function render()
    {
        return view('livewire.client-assign')->layout('layouts.client');
    }
}
