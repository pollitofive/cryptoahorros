<x-filament-panels::page>
    <form wire:submit="update">
        {{ $this->form }}

        <div class="mt-6">
            <div class="inline-block">
                <button style="background-color: #22C55E !important;" type="submit" class="select-none rounded-lg py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                    Save
                </button>
            </div>
            <div  class="inline-block ml-3">
                <a href="{{ URL::previous() }}" class="select-none border border-gray-500 rounded-lg py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</x-filament-panels::page>
