<div class="pt-10">
    <div class="max-w-2xl px-4 py-12 mx-auto bg-white rounded-lg shadow-lg ">
        <h1 class="mb-6 text-xl">Preencha os Dados do Circuito <span class="font-extrabold">{{ $circuit_id }}</span>
        </h1>

        @if (session()->has('success'))
            <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="submit">
            <div class="mt-4 mb-8 flex-row">
                <h1 class="font-bold text-lg mb-4">Dados de Contato</h1>
                <label for="tech_name1" class="block text-gray-700 mt-4">Nome Contato Técnico Principal</label>
                <input type="text" id="tech_name1" wire:model.defer="tech_name1"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                @error('tech_name1')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror

                <label for="tech_mail1" class="block text-gray-700 mt-4">Email Técnico Principal</label>
                <input type="text" id="tech_mail1" wire:model.defer="tech_mail1"
                    class="block mt-1 border-gray-300 w-full rounded-md shadow-sm" required>
                @error('tech_mail1')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror

                <label for="tech_phone1" class="block text-gray-700 mt-4">Telefone Técnico Principal</label>
                <input type="text" id="tech_phone1" wire:model.defer="tech_phone1"
                    class="block mt-1 border-gray-300 rounded-md shadow-sm" required>
                @error('tech_phone1')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror

            </div>

            <!-- Tipo de Tabela de Roteamento -->
            <div class="mb-4">
                <h1 class="font-bold text-lg mb-4">Dados do ASN</h1>
                <label for="router_table" class="block text-gray-700">Tipo de Tabela de Roteamento</label>
                <select id="router_table" wire:model.defer="router_table"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                    <option value="">-- Selecione --</option>
                    <option value="Full Route">Full Route</option>
                    <option value="Partial Route">Partial Route</option>
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
            <div class="mb-4">
                <label for="not_owner_as" class="block text-gray-700">Esta anunciando prefixos alugados?</label>
                <input type="checkbox" id="not_owner_as" wire:click="not_owner_as" wire:change="setIsNotOwnerAS"
                    class="block mt-1 border-gray-300 rounded-md shadow-sm">
            </div>

            @if ($not_owner_as)
                <div class="mb-4">
                    <span class="text-red-600">
                        Com a finalidade de garantir a lisura e a correta propagação dos prefixos anunciados,
                        solicitamos a gentileza de encaminhar a LOA (Letter Of Aggrement) autorizando seu ASN anunciar
                        os prefixos informados para o email <b>engenharia@altarede.com.br</b>
                        <p>
                            Caso não encontremos a LOA junto ao processo de liberação do peering, essa requisição será
                            rejeitada.
                        </p>
                    </span>

                </div>
            @endif

            <div class="mb-4">
                <label for="multihop" class="block text-gray-700">Multihop</label>
                <input type="checkbox" id="multihop" wire:model.defer="multihop"
                    class="block mt-1 border-gray-300 rounded-md shadow-sm">
                @error('multihop')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="md5_checked" class="block text-gray-700">Deseja senha para sessão?</label>
                <input type="checkbox" id="md5_checked" wire:click="md5_checked" wire:change="setBgpPassword()"
                    class="block mt-1 border-gray-300 rounded-md shadow-sm">
            </div>


            @if ($md5_checked)
                <div class="mb-4">
                    <label for="md5_session" class="block text-gray-700">Insira senha para sessão</label>
                    <input type="text" id="md5_session" wire:model.defer="md5_session"
                        class="block mt-1 border-gray-300 w-full rounded-md shadow-sm">
                    @error('md5_session')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            @endif

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
