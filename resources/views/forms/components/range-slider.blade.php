<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <input
            type="range"
            {{ $attributes->merge($getExtraAttributes()) }}
            x-model="state"
            min="{{ $min }}"
            max="{{ $max }}"
            step="{{ $step }}"
        />
        <span x-text="state"></span>
    </div>
</x-dynamic-component>
