<div class="max-w-2xl px-4 py-6 mx-auto rounded-xl bg-slate-50 sm:px-6 lg:px-8">

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <h1 class="mb-4 text-lg font-bold text-black">Insira o token:</h1>
        <div class="flex mt-4 mb-8">
            <div class="flex w-full">
                <input type="text" id="token" wire:model.defer="token"
                    class="block w-full mt-1 text-black border-gray-500 rounded-md shadow-sm" required>
                @error('tech_name1')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <!-- Botão de Envio -->
        <div class="mt-6">
            <button type="submit" class="px-6 py-2 text-white bg-green-500 rounded-md hover:bg-green-600">
                Enviar
            </button>
        </div>
    </form>


</div>
