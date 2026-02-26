<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-danger rounded-pill px-4 py-2 fw-bold text-uppercase tracking-wider shadow-sm']) }}>
    {{ $slot }}
</button>