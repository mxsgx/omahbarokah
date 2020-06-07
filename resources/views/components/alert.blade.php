<div {{ $attributes->merge(['class' => 'alert alert-' . $type . ($dismissible ? ' alert-dismissible fade show' : '') ]) }}>
    {{ $slot }}

    @if($dismissible)
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    @endif
</div>
