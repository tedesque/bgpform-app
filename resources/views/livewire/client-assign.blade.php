<div>
    <div class="max-w-2xl px-4 py-12 mx-auto bg-white rounded-lg shadow-lg ">
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
                @error('device')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tipo de Tabela de Roteamento -->
            <div class="mb-4">
                <label for="router_table" class="block text-gray-700">Tipo de Tabela de Roteamento</label>
                <select id="router_table" wire:model.defer="router_table"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                    <option value="">-- Selecione --</option>
                    <option value="Partial Route">Partial Route</option>
                    <option value="Full Route">Full Route</option>
                    <option value="Default Route">Default Route</option>
                </select>
                @error('router_table')
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
                    <div class="flex">
                        <div>
                            <input type="text" wire:model.defer="prefix.{{ $index }}.ip_prefix"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                            @error('prefix.' . $index . '.ip_prefix')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="button" wire:click.prevent="removePrefix({{ $index }})"
                            class=" text-red-500 top-2 right-2 hover:text-red-700">
                           Remove
                        </button>
                    </div>
                @endforeach

                <button type="button" wire:click.prevent="addPrefix"
                    class="px-4 py-2 mt-2 text-gray bg-blue-500 rounded-md hover:bg-blue-600">
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
