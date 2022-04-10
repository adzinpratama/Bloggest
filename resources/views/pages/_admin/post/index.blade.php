<x-layouts.admin-main>
    <x-slot name="title">{{ trans('common.link.post') }}</x-slot>
    {{ $slot }}
    <x-slot name="css_vendor">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/vendors/css/editors/quill/katex.min.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="stylesheet" type="text/css"
            href="https://fonts.googleapis.com/css2?family=Inconsolata&amp;family=Roboto+Slab&amp;family=Slabo+27px&amp;family=Sofia&amp;family=Ubuntu+Mono&amp;display=swap">
        {{ $css_vendor ?? '' }}
    </x-slot>
    <x-slot name="css_page">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/css/plugins/forms/form-quill-editor.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-email.css') }}">
    </x-slot>
    <x-slot name="js_vendor">
        <script src="{{ asset('app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/editors/quill/highlight.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/editors/quill/quill.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    </x-slot>
    <x-slot name="js_page">
        <script src="/assets/js/pages/common.js"></script>
        {{ $js_page ?? '' }}
        {{-- <script src="{{ asset('app-assets/js/scripts/pages/app-email.js') }}"></script> --}}
        {{-- <script src="{{ asset('assets/js/pages/post.js') }}"></script> --}}
    </x-slot>
    <script>


    </script>
</x-layouts.admin-main>
