<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <div class="flex justify-end gap-3">
            <x-filament::button type="submit">
                {{ __('app.stock_fees.save_settings') }}
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
