<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="yandex-verification" content="cf2d6c1411b1fdb6" />
    <meta name="google-site-verification" content="EMu2ydYvPZg7PdxGkU9yyGkhkS1E3GZDKcYeBPUleF0" />

    @section('meta')
        <meta name="description" content="">
    @endsection

    <title>@yield('title', 'Реквизитка.бай | Реквизиты юридических лиц и ИП Беларусь')</title>

    <link rel="icon" type="image/x-icon" sizes="16x16" href="/favicon.ico">

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
        .item a {
            color: #0a0;
            display: inline-block;
            margin-bottom: 10px;
        }
        a.logo {
            display: inline-block;
            text-decoration: none;
            font-size: 30px;
            color: #333;
        }
        a.logo img {
            width: 50px;
        }
        a.page {
            color: #ccc;
            text-decoration: none;
        }
    </style>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-KZWE2RBRP1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-KZWE2RBRP1');
    </script>

</head>
<body>

<div class="container">

    <div class="row mt-4">
        <div class="col-12">
            <a class="logo" href="/"><img src="/img/logo-192x192.png" alt="Реквизитка.бай"> Реквизитка.бай</a>
        </div>
    </div>

    @include('includes.search-row')

    @yield('content')

</div>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(91936579, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/91936579" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>
