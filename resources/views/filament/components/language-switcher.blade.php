@php
    $locales = config('filament-translation-manager.locales', []);
    $currentLocale = app()->getLocale();
    $localeLabels = [
        'ar' => 'العربية',
        'en' => 'English',
    ];
@endphp

@if (count($locales) > 1)
    <div class="fi-language-switcher mx-2">
        <x-filament::dropdown placement="bottom-end" teleport>
            <x-slot name="trigger">
                <x-filament::button
                    color="gray"
                    icon="heroicon-o-language"
                    outlined
                    size="sm"
                >
                    {{ $localeLabels[$currentLocale] ?? strtoupper($currentLocale) }}
                </x-filament::button>
            </x-slot>

            <x-filament::dropdown.list>
                @foreach ($locales as $locale)
                    <x-filament::dropdown.list.item
                        :color="$locale === $currentLocale ? 'primary' : 'gray'"
                        :href="route('filament.language.switch', $locale)"
                        :icon="$locale === $currentLocale ? 'heroicon-o-check' : null"
                        tag="a"
                    >
                        {{ $localeLabels[$locale] ?? strtoupper($locale) }}
                    </x-filament::dropdown.list.item>
                @endforeach
            </x-filament::dropdown.list>
        </x-filament::dropdown>
    </div>
@endif
