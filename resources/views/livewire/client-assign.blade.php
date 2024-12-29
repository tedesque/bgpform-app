<div>
    <!-- resources/views/livewire/client-dashboard.blade.php -->

    <div class="max-w-3xl px-4 py-10 mx-auto">
        <h1 class="mb-6 text-2xl font-bold">Preencha os Dados do Circuito</h1>

        @if (session()->has('success'))
            <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="submit">
            <!-- Roteador -->
            <div class="mb-4">
                <label for="device" class="block text-gray-700">Roteador</label>
                <input type="text" id="device" wire:model.defer="device"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                @error('roteador')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tipo de Tabela de Roteamento -->
            <div class="mb-4">
                <label for="tabela_roteamento" class="block text-gray-700">Tipo de Tabela de Roteamento</label>
                <select id="tabela_roteamento" wire:model.defer="tabela_roteamento"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                    <option value="">-- Selecione --</option>
                    <option value="Partial Route">Partial</option>
                    <option value="Full Route">Full Route</option>
                    <option value="Default Route">Default</option>
                </select>
                @error('tabela_roteamento')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- ASN -->
            <div class="mb-4">
                <label for="asn" class="block text-gray-700">ASN</label>
                <input type="number" id="asn" wire:model.defer="asn"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                @error('asn')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Prefixos -->
            <div class="mb-4">
                <h2 class="mb-2 text-xl font-semibold">Prefixos</h2>
                @foreach ($prefix as $index => $prefix)
                    <div class="relative p-4 mb-4 border rounded-md">
                        <button type="button" wire:click.prevent="removePrefix({{ $index }})"
                            class="absolute text-red-500 top-2 right-2 hover:text-red-700">
                            &times;
                        </button>
                        <!-- Tipo -->
                        <div class="mb-2">

                        <!-- Prefixo -->
                        <div>
                            <label class="block text-gray-700">Pefixo</label>
                            <input type="text" wire:model.defer="prefixos.{{ $index }}.prefix"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                            @error('prefixos.' . $index . '.prefix')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endforeach

                <button type="button" wire:click.prevent="addPrefix"
                    class="px-4 py-2 mt-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                    Adicionar Prefixo
                </button>
                @error('prefixos')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Botão de Envio -->
            <div class="mt-6">
                <button type="submit" class="px-6 py-2 text-white bg-green-500 rounded-md hover:bg-green-600">
                    Enviar
                </button>
            </div>
        </form>
    </div>

</div>
