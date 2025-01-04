<div class="px-4 py-6 mx-auto text-white max-w-7xl rounded-xl bg-slate-50 sm:px-6 lg:px-8">

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="flex mt-4 mb-8">
            <div class="flex-col w-72">
                <h1 class="mb-4 text-lg font-bold text-black">Dados de Contato</h1>
                <label for="tech_name" class="block mt-4 text-gray-950">Nome Contato Técnico</label>
                <input type="text" id="tech_name" wire:model.defer="tech_name"
                    class="block w-full p-1 mt-1 text-black border-gray-500 rounded-md shadow-sm" required>
                @error('tech_name')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror

                <label for="tech_mail" class="block mt-4 text-gray-950">Email Técnico</label>
                <input type="text" id="tech_mail" wire:model.defer="tech_mail"
                    class="block w-full p-1 mt-1 text-black border-gray-500 rounded-md shadow-sm" required>
                @error('tech_mail')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror

                <label for="tech_phone" class="block mt-4 text-gray-950">Telefone Técnico</label>
                <input type="text" id="tech_phone" wire:model.defer="tech_phone"
                    class="block p-1 mt-1 text-black border-gray-500 rounded-md shadow-sm" required>
                @error('tech_phone')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <!-- Tipo de Tabela de Roteamento -->
            <div class="flex-col mb-4 px-7">
                <h1 class="mb-4 text-lg font-bold text-black">Dados do ASN</h1>

                <!-- ASN -->
                <div class="mb-4">
                    <label for="asn" class="block mt-4 text-gray-950">AS</label>
                    <input type="number" id="asn" wire:model.defer="asn"
                        class="block w-full p-1 mt-1 text-black border-gray-500 rounded-md shadow-sm" required>
                    @error('asn')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="router_table" class="block text-gray-950">Tabela de Roteamento</label>
                    <select id="router_table" wire:model.defer="router_table"
                        class="block w-full p-1 mt-1 text-black border-gray-500 rounded-md shadow-sm" required>
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
                        class="block w-full p-1 mt-1 text-black border-gray-500 rounded-md shadow-sm">
                    @error('as_set')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="flex-col px-5 w-96">
                <h1 class="mb-4 text-lg font-bold text-black">Prefixos do ASN Principal</h1>
                @foreach ($prefixes as $index => $pfx)
                    <div class="flex gap-1 mb-2 text-black">
                        <input type="text" wire:model.defer="prefixes.{{ $index }}.ip_prefix"
                            placeholder="Ex: 192.168.0.0/24"
                            class="block w-full p-1 mt-1 text-black border-gray-500 rounded-md shadow-sm">
                        <button type="button" wire:click="removePrefix({{ $index }})"
                            class="px-2 text-black bg-red-500 rounded-xl">X</button>
                    </div>
                    @error('prefixes.' . $index . '.type')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                    @error('prefixes.' . $index . '.prefix')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                @endforeach
                <button type="button" wire:click="addPrefix" class="px-3 py-1 mb-4 text-white bg-blue-500 rounded-md">
                    + Adicionar Prefixo
                </button>
                <div class="flex mb-4">
                    <input type="checkbox" id="downstream_checked" wire:click="downstream_checked"
                        wire:change="toggleDownstream" class="block mt-1 mr-2 border-gray-500 rounded-md shadow-sm">
                    <label for="downstream_checked" class="block text-gray-950">Possui downstream?</label>
                </div>
                @if ($downstream_checked)
                    <h1 class="mb-4 text-lg font-bold text-black">Downstreams</h1>
                    @foreach ($children as $cIndex => $child)
                        <div class="p-3 border">
                            <div class="flex gap-1 mb-2">
                                <div class="flex-1">
                                    <label class="block font-semibold text-black">ASN</label>
                                    <input type="number" wire:model.defer="children.{{ $cIndex }}.asn"
                                        class="block w-full p-1 mt-1 text-black border-gray-500 rounded-md shadow-sm">
                                </div>
                                <div class="flex-1">
                                    <label class="block font-semibold text-black">AS_SET</label>
                                    <input type="text" wire:model.defer="children.{{ $cIndex }}.as_set"
                                        class="block w-full p-1 mt-1 text-black border-gray-500 rounded-md shadow-sm">
                                </div>
                                <button type="button" wire:click="removeChild({{ $cIndex }})"
                                    class="self-end h-10 px-2 text-white bg-red-500 rounded-xl">X</button>
                            </div>

                            <div class="flex-row gap-1 mb-2">
                                <h4 class="font-bold text-black">Prefixos do Downstream</h4>
                                @foreach ($child['prefixes'] as $pIndex => $cpfx)
                                    <div class="flex gap-2 mb-2">
                                        <input type="text"
                                            wire:model.defer="children.{{ $cIndex }}.prefixes.{{ $pIndex }}.ip_prefix"
                                            placeholder="Ex: 10.0.0.0/24" class="flex-1 p-1 border rounded-md">
                                        <button type="button"
                                            wire:click="removeChildPrefix({{ $cIndex }}, {{ $pIndex }})"
                                            class="px-2 text-white bg-red-500">X</button>
                                    </div>
                                @endforeach
                                <button type="button" wire:click="addChildPrefix({{ $cIndex }})"
                                    class="px-3 py-1 mb-2 text-white bg-blue-500 rounded-md">+ Adicionar
                                    Prefixo</button>
                            </div>
                        </div>
                    @endforeach

                    <button type="button" wire:click="addChild"
                        class="px-3 py-1 mt-2 mb-4 text-white bg-blue-600 rounded-md ">
                        + Adicionar Downstream
                    </button>
                @endif
            </div>
            <div class="flex-col px-5">
                <div class="flex mb-4">
                    <input type="checkbox" id="multihop" wire:model.defer="multihop"
                        class="block mt-1 mr-2 border-gray-500 rounded-md shadow-sm">
                    <label for="multihop" class="block text-gray-950">Deseja sessão multihop?</label>
                    @error('multihop')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex mb-4">
                    <input type="checkbox" id="md5_checked" wire:click="md5_checked" wire:change="toggleBgpPassword"
                        class="block mt-1 mr-2 border-gray-500 rounded-md shadow-sm">
                    <label for="md5_checked" class="block text-gray-950">Deseja senha para sessão?</label>
                </div>
                @if ($md5_checked)
                    <div class="mb-4">
                        <label for="md5_session" class="block text-gray-950">Insira senha para sessão</label>
                        <input type="text" id="md5_session" wire:model.defer="md5_session"
                            class="block w-full p-1 mt-1 mr-2 text-black border-gray-500 rounded-md shadow-sm">
                        @error('md5_session')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
                <div class="flex mb-4">
                    <input type="checkbox" id="not_owner_as" wire:click="not_owner_as"
                        wire:change="toogleNotOwnerAs" class="block mt-1 mr-2 border-gray-500 rounded-md shadow-sm">
                    <label for="not_owner_as" class="block text-gray-950">Anuncia prefixos alugados?</label>
                </div>
                @if ($not_owner_as)
                    <div
                        class="p-4 mt-2 text-center bg-orange-400 border border-dashed rounded-lg shadow-xl max-w-60 text-gray-950">
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
        <div class="mt-6">
            <button type="submit" class="px-6 py-2 text-white bg-green-500 rounded-md hover:bg-green-600">
                Enviar
            </button>
        </div>
    </form>
</div>
