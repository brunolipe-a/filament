@props([
    'action' => null,
    'alignment' => null,
    'name',
    'record',
    'recordAction' => null,
    'recordUrl' => null,
    'shouldOpenUrlInNewTab' => false,
    'tooltip' => null,
    'url' => null,
])

<td
    {{ $attributes->class([
        'filament-tables-cell',
        'dark:text-white' => config('tables.dark_mode'),
        match ($alignment) {
            'left' => 'text-left',
            'center' => 'text-center',
            'right' => 'text-right',
            default => null,
        },
    ]) }}
    @if ($tooltip)
        x-data="{}"
        x-tooltip.raw="{{ $tooltip }}"
    @endif
>
    <div wire:loading.remove>
        @if ($action || ((! $url) && $recordAction))
            <button
                wire:click="{{ $action ? "callTableColumnAction('{$name}', " : "{$recordAction}(" }}'{{ $this->getTableRecordKey($record) }}')"
                wire:target="{{ $action ? "callTableColumnAction('{$name}', " : "{$recordAction}(" }}'{{ $this->getTableRecordKey($record) }}')"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-70 cursor-wait"
                type="button"
                class="block text-left"
            >
                {{ $slot }}
            </button>
        @elseif ($url || $recordUrl)
            <a
                href="{{ $url ?: $recordUrl }}"
                {{ $shouldOpenUrlInNewTab ? 'target="_blank"' : null }}
                class="block"
            >
                {{ $slot }}
            </a>
        @else
            {{ $slot }}
        @endif
    </div>
    <x-tables::loading-cell-content wire:loading.block />
</td>
