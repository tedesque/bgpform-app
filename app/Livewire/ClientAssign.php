<?php

namespace App\Livewire;

use Filament\Notifications\Notification;
use Livewire\Component;
use App\Models\BgpRequest;

class ClientAssign extends Component
{
    public $token;
    public $circuit_id;
    public $router_table;
    public $multihop;
    public $md5_session;
    public $tech_name1;
    public $tech_phone1;
    public $tech_mail1;
    public $tech_name2;
    public $tech_phone2;
    public $tech_mail2;
    public $asn;
    public $as_set;
    public bool $not_owner_as = false;
    public bool $md5_checked = false;
    public $prefix = [];

    public function mount($token)
    {
        $this->token = $token;

        $BgpRequest = BgpRequest::where('token', $token)->firstOrFail();

        if ($BgpRequest->request_status === 'Concluida') {
            abort(403, 'Esta solicitação já foi concluída.');
        }

        if ($BgpRequest) {
            $this->router_table = $BgpRequest->router_table;
            $this->asn = $BgpRequest->asn;
            $this->as_set = $BgpRequest->as_set;
            $this->circuit_id = $BgpRequest->circuit_id;
            $this->md5_session = $BgpRequest->md5_session;
            $this->not_owner_as = $BgpRequest->not_owner_as;
            $this->tech_name1 = $BgpRequest->tech_name1;
            $this->tech_phone1 = $BgpRequest->tech_phone1;
            $this->tech_mail1 = $BgpRequest->tech_mail1;
            $this->tech_name2 = $BgpRequest->tech_name2;
            $this->tech_phone2 = $BgpRequest->tech_phone2;
            $this->tech_mail2 = $BgpRequest->tech_mail2;
            $this->multihop = $BgpRequest->multihop;
            $this->not_owner_as = $BgpRequest->not_owner_as;
            $this->md5_checked;



        } else {
            // Inicializar com um prefixo vazio
            $this->prefix = [
                ['prefix' => ''],
            ];
        }
    }

    public function setBgpPassword()
    {
        if (!$this->md5_checked) {
            $this->md5_checked = true;
        } else {
            $this->md5_checked = false;
        }
    }

    public function setIsNotOwnerAS()
    {
        if (!$this->not_owner_as) {
            $this->not_owner_as = true;
        } else {
            $this->not_owner_as = false;
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
                'router_table' => $this->router_table,
                'asn' => $this->asn,
                'as_set' => $this->as_set,
                'multihop' => $this->multihop,
                'not_owner_as' => $this->not_owner_as,
                'tech_name1' => $this->tech_name1,
                'tech_phone1' => $this->tech_phone1,
                'tech_mail1' => $this->tech_mail1,
                'tech_name2' => $this->tech_name2,
                'tech_phone2' => $this->tech_phone2,
                'tech_mail2' => $this->tech_mail2,
                'multihop' => $this->multihop,
                'md5_session' => $this->md5_session
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
        $this->redirect('/endmessage');
    }

    public function render()
    {
        return view('livewire.client-assign')->layout('layouts.client');
    }
}
