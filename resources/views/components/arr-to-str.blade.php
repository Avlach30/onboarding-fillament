<div>
    @if (!empty($items))
        <p>{{ $label }}</p>
        <ul>
            @foreach ($items as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>    
    @endif
</div>