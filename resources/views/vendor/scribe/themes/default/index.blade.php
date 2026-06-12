@php
    use Knuckles\Scribe\Tools\WritingUtils as u;
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{!! $metadata['title'] !!}</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{!! $assetPathPrefix !!}css/theme-default.style.css" media="screen">
    <link rel="stylesheet" href="{!! $assetPathPrefix !!}css/theme-default.print.css" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

@if(isset($metadata['example_languages']))
    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
        @foreach($metadata['example_languages'] as $lang)
            body .content .{{ $lang }}-example code { display: none; }
        @endforeach
    </style>
@endif

@if($tryItOut['enabled'] ?? true)
    <script>
        var tryItOutBaseUrl = "{!! $tryItOut['base_url'] ?? $baseUrl !!}";
        var useCsrf = Boolean({!! $tryItOut['use_csrf'] ?? null !!});
        var csrfUrl = "{!! $tryItOut['csrf_url'] ?? null !!}";
    </script>
    <script src="{{ u::getVersionedAsset($assetPathPrefix.'js/tryitout.js') }}"></script>
@endif

    <script src="{{ u::getVersionedAsset($assetPathPrefix.'js/theme-default.js') }}"></script>

    <!-- Custom Web Admin UI/UX Styles for API Docs -->
    <style>
        /* Typography scale optimization - minimum 14px (text-sm) */
        body, html, .content, p, li, td, th, pre, code, span, a, button, input {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
        
        .tocify-wrapper {
            background-color: #0c0c0c !important;
            font-size: 14px !important; /* Set minimum to 14px (text-sm) */
            border-right: 1px solid #1a1a1a !important;
        }
        
        .tocify-wrapper > .search input {
            background: #1e1e1e !important;
            border-color: #2a2a2a !important;
            font-size: 14px !important;
            border-radius: 6px !important;
            padding: 8px 12px 8px 30px !important;
        }
        
        .tocify-wrapper > .search input:focus {
            border-color: #E4252C !important;
        }

        .tocify-wrapper .tocify-item > a {
            font-size: 14px !important;
            padding-top: 8px !important;
            padding-bottom: 8px !important;
            color: #ccc !important;
        }

        .tocify-wrapper .tocify-item > a:hover {
            color: #fff !important;
            background: #1a1a1a !important;
        }

        .tocify-wrapper .tocify-subheader {
            background: #121212 !important;
        }

        .tocify-wrapper .tocify-subheader .tocify-item > a {
            font-size: 14px !important; /* Set subheaders to 14px as well */
            padding-left: 25px !important;
            color: #aaa !important;
        }

        .tocify-wrapper .tocify-focus {
            background-color: #E4252C !important; /* Brand Red for active focus */
            color: #fff !important;
            box-shadow: none !important;
        }
        
        .tocify-wrapper .tocify-focus > a {
            color: #fff !important;
            font-weight: 700 !important;
        }
        
        .tocify-wrapper .toc-footer {
            border-top: 1px dashed #222 !important;
        }
        
        .tocify-wrapper .toc-footer li {
            font-size: 14px !important; /* Minimum 14px */
            color: #888 !important;
        }
        
        #toc > ul > li > a > span {
            background-color: #E4252C !important; /* Brand Red count bubble */
        }
        
        /* Language selector styling */
        .lang-selector {
            background-color: #0c0c0c !important;
            border-bottom: 5px solid #121212 !important;
        }
        
        .lang-selector button {
            font-size: 14px !important;
            font-weight: 600 !important;
            padding: 8px 16px !important;
            line-height: normal !important;
        }
        
        .lang-selector button.active {
            background-color: #E4252C !important; /* Brand Red active lang */
            color: #fff !important;
        }

        .page-wrapper .dark-box {
            background-color: #0c0c0c !important;
        }
        
        .page-wrapper .lang-selector {
            border-bottom: 5px solid #0c0c0c !important;
        }
        
        /* Content overrides */
        .content {
            font-size: 14px !important; /* Set standard text size to 14px */
            background-color: #fafafa !important;
        }
        
        .content h1, .content h2, .content h3 {
            color: #010101 !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        .content h1 {
            font-size: 24px !important;
        }

        .content h2 {
            font-size: 18px !important;
            border-left: 4px solid #E4252C !important;
            padding-left: 10px !important;
            margin-top: 2em !important;
        }
        
        .content a {
            color: #E4252C !important;
        }
        
        .content a:hover {
            color: #EF3F3C !important;
        }
        
        /* Table styles inside content */
        .content table {
            font-size: 14px !important;
        }
        
        .content table th, .content table td {
            font-size: 14px !important;
            padding: 10px 12px !important;
        }
        
        /* Badges / Request methods color overrides */
        .badge {
            font-size: 14px !important;
            padding: 4px 8px !important;
            border-radius: 6px !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
        }
        
        .badge.badge-green {
            background-color: rgba(16, 185, 129, 0.1) !important;
            color: #10b981 !important;
            border: 1px solid rgba(16, 185, 129, 0.2) !important;
        }
        
        .badge.badge-red, .badge.badge-darkred {
            background-color: rgba(228, 37, 44, 0.1) !important;
            color: #E4252C !important;
            border: 1px solid rgba(228, 37, 44, 0.2) !important;
        }
        
        /* Notice block styling */
        .content aside.notice {
            background-color: rgba(228, 37, 44, 0.05) !important;
            border-left: 5px solid #E4252C !important;
            font-size: 14px !important;
            border-radius: 6px !important;
            padding: 12px 20px !important;
        }
        
        .content aside.warning {
            background-color: rgba(245, 158, 11, 0.05) !important;
            border-left: 5px solid #f59e0b !important;
            font-size: 14px !important;
            border-radius: 6px !important;
            padding: 12px 20px !important;
        }
        
        .content aside.success {
            background-color: rgba(16, 185, 129, 0.05) !important;
            border-left: 5px solid #10b981 !important;
            font-size: 14px !important;
            border-radius: 6px !important;
            padding: 12px 20px !important;
        }
    </style>
</head>

<body data-languages="{{ json_encode($metadata['example_languages'] ?? []) }}">

@include("scribe::themes.default.sidebar")

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        {!! $intro !!}

        {!! $auth !!}

        @include("scribe::themes.default.groups")

        {!! $append !!}
    </div>
    <div class="dark-box">
        @if(isset($metadata['example_languages']))
            <div class="lang-selector">
                @foreach($metadata['example_languages'] as $name => $lang)
                    @php if (is_numeric($name)) $name = $lang; @endphp
                    <button type="button" class="lang-button" data-language-name="{{$lang}}">{{$name}}</button>
                @endforeach
            </div>
        @endif
    </div>
</div>
</body>
</html>
