<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    
    @if(isset($metaDescription))
    <meta name="description" content="{{ $metaDescription }}">
    @endif
    
    @if(isset($canonical))
    <link rel="canonical" href="{{ $canonical }}">
    @endif
    
    @if(isset($noindex) && $noindex)
    <meta name="robots" content="noindex, nofollow">
    @endif

    <!-- Google Consent Mode (default denied) -->
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        
        gtag('consent', 'default', {
            'analytics_storage': 'denied',
            'ad_storage': 'denied',
            'wait_for_update': 500
        });
        
        // Check existing consent
        const consent = JSON.parse(localStorage.getItem('cookie_consent') || '{}');
        if (consent.analytics || consent.marketing) {
            gtag('consent', 'update', {
                'analytics_storage': consent.analytics ? 'granted' : 'denied',
                'ad_storage': consent.marketing ? 'granted' : 'denied'
            });
        }
    </script>

    <!-- Google Analytics (GA4) - Only loads with consent -->
    <script>
        if (hasConsent('analytics')) {
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtag/js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{{ env("GA4_ID", "G-XXXXXXXXXX") }}');
            
            gtag('js', new Date());
            gtag('config', '{{ env("GA4_ID", "G-XXXXXXXXXX") }}');
        }
        
        function hasConsent(type) {
            const consent = JSON.parse(localStorage.getItem('cookie_consent') || '{}');
            return consent[type] === true;
        }
    </script>

    <!-- Facebook Pixel - Only loads with consent -->
    <script>
        if (hasConsent('marketing')) {
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ env("FACEBOOK_PIXEL_ID", "XXXXXXXXXX") }}');
            fbq('track', 'PageView');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body class="antialiased bg-gray-50">
    @yield('content')

    <!-- Cookie Banner -->
    <x-cookie-banner />

    @livewireScripts
    @stack('scripts')
</body>
</html>
