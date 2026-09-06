@if (session()->has('impersonating_admin_id'))
    <a
        href="{{ route('admin.stop-impersonating') }}"
        class="fi-btn fi-btn-size-sm fi-btn-color-gray"
    >
        {{ __('app.stop_impersonating') }}
    </a>
@endif
