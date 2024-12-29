<x-filament-panels::page>
    <div class="max-w-3xl py-10 mx-auto">
        <h1 class="mb-6 text-2xl font-bold">Preencha os Dados do Circuito</h1>
        <h2>Designador do Circuito: {{ $this->record->circuit_id }}</h2>
        <h2>Velocidade: {{ $this->record->circuit_speed }} Gbps</h2>
        <form wire:submit.prevent="submit">
            {{ $this->form }}

            <div class="mt-6">
                <x-filament::button type="submit">
                    Enviar
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>
