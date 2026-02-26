<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-theme-outline rounded-pill px-4 py-2 fw-bold text-uppercase tracking-wider shadow-sm']) }}>
    {{ $slot }}
</button>