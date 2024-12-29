<?php

namespace App\Filament\Resources\RequestResource\Pages;

use App\Filament\Resources\RequestResource;
use App\Models\bgpRequest;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Forms;

class ClientAssign extends Page
{
    use InteractsWithRecord;

    protected static string $resource = RequestResource::class;

    protected static string $view = 'filament.resources.request-resource.pages.client-assign';

    public function mount(string $record): void
    {
        $this->record = \App\Models\bgpRequest::where('token', $record)->firstOrFail();
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('device')
                ->label('Roteador')
                ->maxLength(255)
                ->required(),

            Forms\Components\Select::make('router_table')
                ->label('Tipo de Tabela de Roteamento')
                ->options([
                    'Partial Route' => 'Partial Route',
                    'Full Route' => 'Full Route',
                    'Default Route' => 'Default Route',
                ])
                ->required(),

            Forms\Components\TextInput::make('asn')
                ->label('ASN')
                ->required()
                ->numeric(),

            Forms\Components\Repeater::make('prefixos')
                ->label('Prefixos')
                ->schema([
                    Forms\Components\TextInput::make('prefix')
                        ->label('Prefixo')
                        ->required()
                        ->maxLength(255),
                ])
                ->required()
                ->minItems(1)
                ->maxItems(20)
                ->createItemButtonLabel('Adicionar Prefixo'),

        ];
    }

    public function submit()
    {
        $data = $this->form->getState();


        // Buscar a solicitação pelo token
        $assign = bgpRequest::where('token', $this->record)->firstOrFail();

        // Criar ou atualizar os detalhes do cliente
        $assign->clientDetails()->updateOrCreate(
            ['request_id' => $assign->id],
            $data
        );

        // Atualizar o status da solicitação
        $assign->update(['request_status' => 'Concluída']);

        // Redirecionar com uma mensagem de sucesso
        $this->notify('success', 'Dados enviados com sucesso!');
    }
}
