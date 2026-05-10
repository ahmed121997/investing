<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <div class="flex justify-end gap-3">
            {{ $this->save }}
        </div>
    </form>
</x-filament-panels::page>
