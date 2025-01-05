<div class="px-4 py-6 mx-auto bg-white shadow max-w-7xl rounded-xl sm:px-6 lg:px-8">
    @if (session()->has('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6">
        <!-- Seção: Dados de Contato + ASN + Roteamento -->
        <div class="grid grid-cols-1 gap-6 text-gray-800 bg-white rounded-md md:grid-cols-2 lg:grid-cols-3">

            <!-- Coluna 1: Dados de Contato -->
            <div class="flex flex-col p-4 border border-gray-200 rounded-md">
                <h1 class="mb-4 text-lg font-bold">Dados de Contato</h1>

                <label for="tech_name" class="mt-4 text-sm font-semibold">Nome Contato Técnico</label>
                <input type="text" id="tech_name" wire:model.defer="tech_name"
                    class="block w-full p-2 mt-1 text-gray-900 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none"
                    required />
                @error('tech_name')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror

                <label for="tech_mail" class="mt-4 text-sm font-semibold">Email Técnico</label>
                <input type="text" id="tech_mail" wire:model.defer="tech_mail"
                    class="block w-full p-2 mt-1 text-gray-900 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none"
                    required />
                @error('tech_mail')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror

                <label for="tech_phone" class="mt-4 text-sm font-semibold">Telefone Técnico</label>
                <input type="text" id="tech_phone" wire:model.defer="tech_phone"
                    class="block w-full p-2 mt-1 text-gray-900 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none"
                    required />
                @error('tech_phone')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Coluna 2: Dados do ASN -->
            <div class="flex flex-col p-4 border border-gray-200 rounded-md">
                <h1 class="mb-4 text-lg font-bold">Dados do ASN</h1>

                <label for="asn" class="mt-4 text-sm font-semibold">AS</label>
                <input type="number" id="asn" wire:model.defer="asn"
                    class="block w-full p-2 mt-1 text-gray-900 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none"
                    required />
                @error('asn')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror

                <label for="router_table" class="mt-4 text-sm font-semibold">Tabela de Roteamento</label>
                <select id="router_table" wire:model.defer="router_table"
                    class="block w-full p-2 mt-1 text-gray-900 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none"
                    required>
                    <option value="">-- Selecione --</option>
                    <option value="Full Route">Full Route</option>
                    <option value="Partial Route">Partial Route</option>
                    <option value="Default Route">Default Route</option>
                </select>
                @error('router_table')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror

                <label for="as_set" class="mt-4 text-sm font-semibold">AS-SET (Opcional)</label>
                <input type="text" id="as_set" wire:model.defer="as_set"
                    class="block w-full p-2 mt-1 text-gray-900 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none"
                    placeholder="Ex: AS-XXXX" />
                @error('as_set')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Coluna 3: Prefixos do ASN Principal -->
            <div class="flex flex-col p-4 border border-gray-200 rounded-md">
                <h1 class="mb-4 text-lg font-bold">Prefixos do ASN Principal</h1>

                @foreach ($prefixes as $index => $pfx)
                    <div class="flex items-start gap-2 mb-2">
                        <input type="text" wire:model.defer="prefixes.{{ $index }}.ip_prefix"
                            placeholder="Ex: 192.168.0.0/24"
                            class="block w-full p-2 text-gray-900 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none" />
                        <button type="button" wire:click="removePrefix({{ $index }})"
                            class="px-2 text-sm text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none">
                            Remover
                        </button>
                    </div>
                @endforeach
                <button type="button" wire:click="addPrefix"
                    class="px-3 py-1 mb-4 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none">
                    + Adicionar Prefixo
                </button>

                <!-- Checkbox: Possui downstream? -->
                <div class="flex items-center mt-4 mb-2">
                    <input type="checkbox" id="downstream_checked" wire:click="downstream_checked"
                        wire:change="toggleDownstream" class="mr-2 focus:outline-none focus:ring-0" />
                    <label for="downstream_checked" class="text-sm font-semibold text-gray-800">
                        Possui downstream?
                    </label>
                </div>
            </div>
        </div> <!-- Fim do grid -->

        <!-- Seção Downstreams -->
        @if ($downstream_checked)
            <div class="p-4 bg-white border border-gray-200 rounded-md">
                <h1 class="mb-4 text-lg font-bold text-gray-800">Downstreams</h1>
                @foreach ($children as $cIndex => $child)
                    <div class="p-3 mb-4 border border-gray-300 border-dashed rounded bg-gray-50">
                        <div class="flex flex-col gap-2 mb-3 sm:flex-row">
                            <!-- ASN do Downstream -->
                            <div class="flex-1">
                                <label class="block mb-1 text-sm font-semibold text-gray-800">
                                    ASN do Downstream
                                </label>
                                <input type="number" wire:model.defer="children.{{ $cIndex }}.asn"
                                    class="w-full p-2 text-gray-900 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none" />
                            </div>

                            <!-- AS_SET do Downstream -->
                            <div class="flex-1">
                                <label class="block mb-1 text-sm font-semibold text-gray-800">
                                    AS_SET (Opcional)
                                </label>
                                <input type="text" wire:model.defer="children.{{ $cIndex }}.as_set"
                                    class="w-full p-2 text-gray-900 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none"
                                    placeholder="Ex: AS-XXXX" />
                            </div>

                            <button type="button" wire:click="removeChild({{ $cIndex }})"
                                class="self-end px-3 py-1 mt-2 text-sm text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none sm:mt-auto">
                                Remover
                            </button>
                        </div>

                        <!-- Prefixos do Downstream -->
                        <div>
                            <h4 class="mb-2 text-sm font-bold text-gray-800">Prefixos do Downstream</h4>
                            @foreach ($child['prefixes'] as $pIndex => $cpfx)
                                <div class="flex items-start gap-2 mb-2">
                                    <input type="text"
                                        wire:model.defer="children.{{ $cIndex }}.prefixes.{{ $pIndex }}.ip_prefix"
                                        placeholder="Ex: 10.0.0.0/24"
                                        class="block w-full p-2 text-gray-900 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none" />
                                    <button type="button"
                                        wire:click="removeChildPrefix({{ $cIndex }}, {{ $pIndex }})"
                                        class="px-2 text-sm text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none">
                                        Remover
                                    </button>
                                </div>
                            @endforeach

                            <button type="button" wire:click="addChildPrefix({{ $cIndex }})"
                                class="px-3 py-1 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none">
                                + Adicionar Prefixo
                            </button>
                        </div>
                    </div>
                @endforeach

                <button type="button" wire:click="addChild"
                    class="px-3 py-1 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none">
                    + Adicionar Downstream
                </button>
            </div>
        @endif

        <!-- Seção Opções Adicionais (multihop, bgp md5, etc.) -->
        <div class="grid grid-cols-1 gap-6 text-gray-800 bg-white rounded-md md:grid-cols-2 lg:grid-cols-3">

            <!-- Sessão 1 -->
            <div class="flex flex-col p-4 border border-gray-200 rounded-md">
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="multihop" wire:model.defer="multihop"
                        class="mr-2 focus:outline-none focus:ring-0" />
                    <label for="multihop" class="text-sm font-semibold">Deseja sessão multihop?</label>
                </div>
                @error('multihop')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror

                <div class="flex items-center mb-4">
                    <input type="checkbox" id="md5_checked" wire:click="md5_checked" wire:change="toggleBgpPassword"
                        class="mr-2 focus:outline-none focus:ring-0" />
                    <label for="md5_checked" class="text-sm font-semibold">Deseja senha para sessão?</label>
                </div>
                @if ($md5_checked)
                    <div class="mb-4">
                        <label for="md5_session" class="block mb-1 text-sm font-semibold">Senha da Sessão BGP</label>
                        <input type="text" id="md5_session" wire:model.defer="md5_session"
                            class="block w-full p-2 mt-1 text-gray-900 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none" />
                        @error('md5_session')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
            </div>

            <!-- Sessão 2 -->
            <div class="flex flex-col p-4 border border-gray-200 rounded-md">
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="not_owner_as" wire:click="not_owner_as"
                        wire:change="toogleNotOwnerAs" class="mr-2 focus:outline-none focus:ring-0" />
                    <label for="not_owner_as" class="text-sm font-semibold">Anuncia prefixos alugados?</label>
                </div>
                @if ($not_owner_as)
                    <div
                        class="p-4 mt-2 text-sm text-gray-800 bg-orange-100 border border-orange-300 rounded-md shadow">
                        <p>
                            Para garantir a lisura e a propagação dos prefixos anunciados,
                            precisamos da LOA (Letter Of Agreement) autorizando seu ASN anunciar
                            os prefixos informados. Caso a LOA não seja enviada, esta requisição
                            será rejeitada.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Sessão 3 (exemplo de espaço vazio ou algo adicional) -->
            <div class="p-4 border border-gray-200 rounded-md">
                <!-- Espaço para algo futuro ou para manter layout equilibrado -->
            </div>
        </div>

        <!-- Botão de Enviar -->
        <div>
            <button type="submit"
                class="px-6 py-2 text-white bg-green-500 rounded-md hover:bg-green-600 focus:outline-none">
                Enviar
            </button>
        </div>
    </form>
</div>
