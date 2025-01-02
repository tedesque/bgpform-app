<div class="max-w-5xl px-4 py-6 mx-auto rounded-xl bg-slate-50 sm:px-6 lg:px-8">

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="flex mt-4 mb-8">
            <div class="flex-col">
                <h1 class="mb-4 text-lg font-bold text-black">Dados de Contato</h1>
                <label for="tech_name1" class="block mt-4 text-gray-950">Nome Contato Técnico Principal</label>
                <input type="text" id="tech_name1" wire:model.defer="tech_name1"
                    class="block w-full mt-1 text-black border-gray-500 rounded-md shadow-sm" required>
                @error('tech_name1')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror

                <label for="tech_mail1" class="block mt-4 text-gray-950">Email Técnico Principal</label>
                <input type="text" id="tech_mail1" wire:model.defer="tech_mail1"
                    class="block w-full mt-1 text-black border-gray-500 rounded-md shadow-sm" required>
                @error('tech_mail1')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror

                <label for="tech_phone1" class="block mt-4 text-gray-950">Telefone Técnico Principal</label>
                <input type="text" id="tech_phone1" wire:model.defer="tech_phone1"
                    class="block mt-1 text-black border-gray-500 rounded-md shadow-sm" required>
                @error('tech_phone1')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <!-- Tipo de Tabela de Roteamento -->
            <div class="flex-col px-10 mb-4">
                <h1 class="mb-4 text-lg font-bold text-black">Dados do ASN</h1>

                <!-- ASN -->
                <div class="mb-4">
                    <label for="asn" class="block mt-4 text-gray-950">AS</label>
                    <input type="number" id="asn" wire:model.defer="asn"
                        class="block w-full mt-1 text-black border-gray-500 rounded-md shadow-sm" required>
                    @error('asn')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="router_table" class="block text-gray-950">Tipo de Tabela de Roteamento</label>
                    <select id="router_table" wire:model.defer="router_table"
                        class="block w-full mt-1 text-black border-gray-500 rounded-md shadow-sm" required>
                        <option value="">-- Selecione --</option>
                        <option value="Full Route">Full Route</option>
                        <option value="Partial Route">Partial Route</option>
                        <option value="Default Route">Default Route</option>
                    </select>
                    @error('router_table')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="as_set" class="block mt-4 text-gray-950">AS-SET</label>
                    <input type="text" id="as_set" wire:model.defer="as_set" placeholder="Opcional"
                        class="block w-full mt-1 text-black border-gray-500 rounded-md shadow-sm">
                    @error('as_set')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="flex-col">



                <div class="mb-4">
                    <label for="multihop" class="block text-gray-950">Multihop</label>
                    <input type="checkbox" id="multihop" wire:model.defer="multihop"
                        class="block mt-1 border-gray-500 rounded-md shadow-sm">
                    @error('multihop')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="md5_checked" class="block text-gray-950">Deseja senha para sessão?</label>
                    <input type="checkbox" id="md5_checked" wire:click="md5_checked" wire:change="setBgpPassword()"
                        class="block mt-1 border-gray-500 rounded-md shadow-sm">
                </div>


                @if ($md5_checked)
                    <div class="mb-4">
                        <label for="md5_session" class="block text-gray-950">Insira senha para sessão</label>
                        <input type="text" id="md5_session" wire:model.defer="md5_session"
                            class="block w-full mt-1 text-black border-gray-500 rounded-md shadow-sm">
                        @error('md5_session')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                <div class="mb-4">
                    <label for="not_owner_as" class="block text-gray-950">Esta anunciando prefixos alugados?</label>
                    <input type="checkbox" id="not_owner_as" wire:click="not_owner_as" wire:change="setIsNotOwnerAS"
                        class="block mt-1 border-gray-500 rounded-md shadow-sm">
                    @if ($not_owner_as)
                        <div
                            class="flex p-4 mt-2 text-center bg-orange-400 border border-dashed rounded-lg shadow-xl max-w-80 text-gray-950">
                            Com a finalidade de garantir a lisura e a correta propagação dos prefixos anunciados,
                            solicitamos a gentileza de encaminhar a LOA (Letter Of Aggrement) autorizando seu ASN
                            anunciar
                            os prefixos informados para o email engenharia@altarede.com.br
                            Caso não encontremos a LOA junto ao processo de liberação do peering, essa requisição
                            será
                            rejeitada.

                        </div>
                    @endif
                </div>

            </div>



        </div>







        <!-- Prefixos -->
        <div class="mb-4">
            <h2 class="mb-2 text-xl font-semibold">Prefixos</h2>
            @foreach ($prefix as $index => $prefix)
                <div class="flex">
                    <div>
                        <input type="text" wire:model.defer="prefix.{{ $index }}.ip_prefix"
                            class="block w-full mt-1 text-black border-gray-500 rounded-md shadow-sm" required>
                        @error('prefix.' . $index . '.ip_prefix')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="button" wire:click.prevent="removePrefix({{ $index }})"
                        class="text-red-500 top-2 right-2 hover:text-red-700">
                        Remove
                    </button>
                </div>
            @endforeach

            <button type="button" wire:click.prevent="addPrefix"
                class="px-4 py-2 mt-2 bg-blue-500 rounded-md text-gray hover:bg-blue-600">
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
