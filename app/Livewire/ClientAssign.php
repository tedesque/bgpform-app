<?php

namespace App\Livewire;

use App\Models\AsnEntity;
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
    public bool $not_owner_as = false;
    public bool $md5_checked = false;
    public bool $downstream_checked = false;

    public $tech_name;
    public $tech_phone;
    public $tech_mail;
    public $asn;
    public $as_set;
    public $prefixes = [];
    public $children = [];

    public function mount($token)
    {
        $this->token = $token;

        $BgpRequest = BgpRequest::where('token', $token)->firstOrFail();
        $AsnEntity = AsnEntity::where('bgp_request_id', $BgpRequest->id);


        if ($BgpRequest->request_status === 'Concluida') {
            abort(403, 'Esta solicitação já foi concluída.');
        }

        if ($BgpRequest) {
            $this->circuit_id = $BgpRequest->circuit_id;
            $this->router_table = $BgpRequest->router_table;
            $this->multihop = $BgpRequest->multihop;
            $this->md5_session = $BgpRequest->md5_session;
            $this->not_owner_as = $BgpRequest->not_owner_as;
        }

        $this->prefixes = [
            ['ip_prefix' => '']
        ];
        $this->children = [
            [
                'asn' => '',
                'as_set' => '',
                'tech_name' => '',
                'tech_phone' => '',
                'tech_mail' => '',
                'prefixes' => [
                    ['ip_prefix' => '']
                ],
                'children' => [],
            ],
        ];
    }

    public function toggleBgpPassword()
    {
        !$this->md5_checked ? $this->md5_checked = true : $this->md5_checked = false;
    }

    public function toggleDownstream()
    {
        !$this->downstream_checked ? $this->downstream_checked = true : $this->downstream_checked = false;
    }

    public function toogleNotOwnerAs()
    {
        !$this->not_owner_as ? $this->not_owner_as = true : $this->not_owner_as = false;
    }


    public function addPrefix()
    {
        $this->prefixes[] = ['ip_prefix' => ''];
    }

    public function removePrefix($index)
    {
        unset($this->prefixes[$index]);
        $this->prefixes = array_values($this->prefixes);
    }

    public function addChild()
    {
        $this->children[] = [
            'asn' => '',
            'as_set' => '',
            'prefixes' => [
                ['ip_prefix' => '']
            ],
            'children' => [],
        ];
    }

    public function removeChild($index)
    {
        unset($this->children[$index]);
        $this->children = array_values($this->children);
    }

    public function addChildPrefix($childIndex)
    {
        $this->children[$childIndex]['prefixes'][] = ['ip_prefix' => ''];
    }

    public function removeChildPrefix($childIndex, $prefixIndex)
    {
        unset($this->children[$childIndex]['prefixes'][$prefixIndex]);
        $this->children[$childIndex]['prefixes'] = array_values($this->children[$childIndex]['prefixes']);
    }


    public function submit()
    {
        $BgpRequest = BgpRequest::where('token', $this->token)->firstOrFail();

        $asnParent = AsnEntity::create([
            'asn' => $this->asn,
            'as_set' => $this->as_set,
            'bgp_request_id' => $BgpRequest->id,
            'parent_id' => null,
            'tech_name' => $this->tech_name,
            'tech_mail' => $this->tech_mail,
            'tech_phone' => $this->tech_phone,
        ]);


        foreach ($this->prefixes as $p) {
            if (!empty($p['ip_prefix'])) {
                $asnParent->prefixes()->create([
                    'ip_prefix' => $p['ip_prefix']
                ]);
            }
        }

        $this->createChildren($asnParent, $this->children, $BgpRequest->id);


        $assign = $BgpRequest->updateOrCreate(
            ['id' => $BgpRequest->id],
            [
                'router_table' => $this->router_table,
                'multihop' => $this->multihop,
                'not_owner_as' => $this->not_owner_as,
                'md5_session' => $this->md5_session
            ]
        );

        $BgpRequest->update(['request_status' => 'Concluida']);

        session()->flash('success', 'Dados enviados com sucesso!');
        $this->redirect('/endmessage');
    }

    protected function createChildren(AsnEntity $parent, array $childrenData, int $bgpRequest)
    {
        foreach ($childrenData as $child) {
            if (empty($child['asn'])) {
                continue;
            }
            $childAsn = AsnEntity::create([
                'asn' => $child['asn'],
                'as_set' => $child['as_set'],
                'parent_id' => $parent->id,
                'bgp_request_id' => $bgpRequest,
            ]);

            if (!empty($child['prefixes'])) {
                foreach ($child['prefixes'] as $cp) {
                    if (!empty($cp['ip_prefix'])) {
                        $childAsn->prefixes()->create([
                            'ip_prefix' => $cp['ip_prefix']
                        ]);
                    }
                }
            }
            if (!empty($child['children'])) {
                $this->createChildren($childAsn, $child['children'], $bgpRequest);
            }
        }
    }

    public function render()
    {
        return view('livewire.client-assign')->layout('layouts.client');
    }
}
