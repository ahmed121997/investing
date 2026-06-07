@php
    use Illuminate\Support\Str;

    $stock = $record->stock;
    $sector = $stock?->sector;
@endphp

<div style="display: flex; flex-direction: column; gap: 0.25rem;">
    <div style="display: flex; align-items: center; gap: 0.25rem; flex-wrap: wrap;">
        <span>{{ Str::limit($getState(), 15, '...') }}</span>

        @if ($stock?->code)
            <span>({{ $stock->code }})</span>
        @endif

        @if ($record->year)
            <span style="display: inline-flex; align-items: center; background-color: #dcfce7; color: #166534; padding: 0.125rem 0.375rem; border-radius: 9999px; font-size: 0.65rem; font-weight: 400; line-height: 1;">
                {{ $record->year }}
            </span>
        @endif

        @if ($sector?->name_ar)
            <span
                title="{{ $sector->name_ar }}"
                style="display: inline-flex; align-items: center; background-color:#e17100; color: #d5d7db; padding: 0.125rem 0.375rem; border-radius: 9999px; font-size: 0.65rem; font-weight: 400; line-height: 1;"
            >
                {{ Str::limit($sector->name_ar, 5, '...') }}
            </span>
        @endif
    </div>
</div>
