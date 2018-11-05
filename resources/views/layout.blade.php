<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ sharp_page_title($sharpMenu ?? null, $entityKey ?? null) }}</title>
    <link rel="stylesheet" href="/vendor/sharp/sharp.css?version={{ sharp_version() }}">
    <link rel="stylesheet" href="/vendor/sharp/sharp-cms.css?version={{ sharp_version() }}">
    {!! array_get($injectedAssets ?? [], 'head') !!}
</head>
<body>
    <div id="glasspane"></div>


    @yield('content')

    <script type="text/javascript">
        window.BASE_PATH = '{{env('SHARP_BASE_PATH') ? env('SHARP_BASE_PATH') : 'sharp'}}';
    </script>
    <script src="/vendor/sharp/manifest.js?version={{ sharp_version() }}"></script>
    <script src="/vendor/sharp/vendor.js?version={{ sharp_version() }}"></script>
    <script src="/vendor/sharp/api.js?version={{ sharp_version() }}"></script>

    {!! sharp_custom_form_fields() !!}

    <script src="/vendor/sharp/lang.js?version={{ sharp_version() }}&locale={{ app()->getLocale() }}"></script>
    <script src="/vendor/sharp/sharp.js?version={{ sharp_version() }}"></script>
</body>
</html>