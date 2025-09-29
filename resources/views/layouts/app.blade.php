<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-seo-head 
        :title="$seoTitle ?? 'MOBIV Imóveis'"
        :description="$seoDescription ?? 'Encontre o imóvel perfeito em Portugal'"
        :canonical="$canonical ?? null"
        :noindex="$noindex ?? false"
        :image="$ogImage ?? null"
    />

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
<body class="font-sans antialiased bg-white text-ink">
    <!-- Skip to main content -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-primary focus:text-white focus:rounded-lg focus:shadow-lg">
        Saltar para o conteúdo
    </a>

    <!-- Navbar -->
    <nav class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm" role="navigation" aria-label="Navegação principal">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <a href="/" class="flex items-center gap-3 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 rounded-lg transition" aria-label="MOBIV Imóveis - Página inicial">
                    <span class="text-2xl font-bold text-primary">MOBIV</span>
                    <span class="text-sm text-muted font-medium">Imóveis</span>
                </a>

                <div class="flex items-center gap-6">
                    <a href="/imoveis" class="text-ink hover:text-primary font-medium transition focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 rounded px-2 py-1 {{ request()->is('imoveis*') ? 'text-primary' : '' }}" aria-current="{{ request()->is('imoveis*') ? 'page' : 'false' }}">
                        Imóveis
                    </a>
                    <a href="https://wa.me/351914337546" target="_blank" rel="noopener noreferrer" class="hidden sm:inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold transition focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" aria-label="Contactar via WhatsApp (abre em nova janela)">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        <span>Contactar</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main id="main-content" role="main">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-ink text-white mt-20" role="contentinfo">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">MOBIV Imóveis</h3>
                    <p class="text-gray-400 text-sm">A sua imobiliária de confiança em Portugal.</p>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Links Úteis</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/imoveis" class="text-gray-400 hover:text-white transition focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-ink rounded">Imóveis</a></li>
                        <li><a href="/politica-privacidade" class="text-gray-400 hover:text-white transition focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-ink rounded">Política de Privacidade</a></li>
                        <li><a href="/termos-uso" class="text-gray-400 hover:text-white transition focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-ink rounded">Termos de Uso</a></li>
                        <li><a href="/politica-cookies" class="text-gray-400 hover:text-white transition focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-ink rounded">Política de Cookies</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Contactos</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <a href="tel:+351914337546" class="hover:text-white transition">+351 914 337 546</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:office@vibecode.pt" class="hover:text-white transition">office@vibecode.pt</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} MOBIV Imóveis. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Cookie Banner -->
    <x-cookie-banner />

    @livewireScripts
    @stack('scripts')
</body>
</html>
