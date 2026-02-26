<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-theme rounded-pill px-4 py-2 fw-bold text-uppercase tracking-wider']) }}>
    {{ $slot }}
</button>