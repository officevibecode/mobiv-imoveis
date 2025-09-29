<div 
    x-data="cookieBanner()" 
    x-show="!hasConsent" 
    x-cloak
    class="fixed bottom-0 left-0 right-0 bg-white border-t-2 border-primary shadow-2xl z-50 p-6"
    role="dialog"
    aria-labelledby="cookie-banner-title"
>
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex-1">
                <h3 id="cookie-banner-title" class="text-lg font-bold text-gray-900 mb-2">
                    🍪 Utilizamos Cookies
                </h3>
                <p class="text-sm text-gray-600">
                    Utilizamos cookies essenciais e, com o seu consentimento, cookies de análise e marketing para melhorar a sua experiência.
                    <a href="/politica-cookies" class="text-primary underline hover:text-primary-700">Saber mais</a>
                </p>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <button 
                    @click="acceptAll()"
                    class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-700 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                >
                    Aceitar Todos
                </button>
                <button 
                    @click="showPreferences = true"
                    class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
                >
                    Preferências
                </button>
                <button 
                    @click="acceptEssential()"
                    class="px-6 py-2 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
                >
                    Apenas Essenciais
                </button>
            </div>
        </div>
    </div>

    <!-- Preferences Modal -->
    <div 
        x-show="showPreferences" 
        @keydown.escape.window="showPreferences = false"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
        x-cloak
    >
        <div 
            @click.away="showPreferences = false"
            class="bg-white rounded-lg max-w-2xl w-full max-h-[80vh] overflow-y-auto p-6"
            role="dialog"
            aria-labelledby="preferences-title"
        >
            <h3 id="preferences-title" class="text-2xl font-bold mb-4">Preferências de Cookies</h3>
            
            <div class="space-y-4">
                <!-- Essential -->
                <div class="border-b pb-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-lg">Cookies Essenciais</h4>
                            <p class="text-sm text-gray-600">Necessários para o funcionamento do site</p>
                        </div>
                        <input type="checkbox" checked disabled class="w-5 h-5">
                    </div>
                </div>

                <!-- Analytics -->
                <div class="border-b pb-4">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h4 class="font-semibold text-lg">Cookies de Análise</h4>
                            <p class="text-sm text-gray-600">Ajudam-nos a melhorar o site (Google Analytics)</p>
                        </div>
                        <input 
                            type="checkbox" 
                            x-model="preferences.analytics"
                            class="w-5 h-5 text-primary focus:ring-primary"
                        >
                    </div>
                </div>

                <!-- Marketing -->
                <div class="border-b pb-4">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h4 class="font-semibold text-lg">Cookies de Marketing</h4>
                            <p class="text-sm text-gray-600">Publicidade personalizada (Facebook Pixel)</p>
                        </div>
                        <input 
                            type="checkbox" 
                            x-model="preferences.marketing"
                            class="w-5 h-5 text-primary focus:ring-primary"
                        >
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button 
                    @click="savePreferences()"
                    class="flex-1 px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-700 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                >
                    Guardar Preferências
                </button>
                <button 
                    @click="showPreferences = false"
                    class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
                >
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function cookieBanner() {
    return {
        hasConsent: localStorage.getItem('cookie_consent') !== null,
        showPreferences: false,
        preferences: {
            analytics: true,
            marketing: true
        },
        
        acceptAll() {
            this.preferences = { analytics: true, marketing: true };
            this.savePreferences();
        },
        
        acceptEssential() {
            this.preferences = { analytics: false, marketing: false };
            this.savePreferences();
        },
        
        savePreferences() {
            localStorage.setItem('cookie_consent', JSON.stringify(this.preferences));
            this.hasConsent = true;
            this.showPreferences = false;
            
            // Update Consent Mode
            if (typeof gtag !== 'undefined') {
                gtag('consent', 'update', {
                    'analytics_storage': this.preferences.analytics ? 'granted' : 'denied',
                    'ad_storage': this.preferences.marketing ? 'granted' : 'denied'
                });
            }
            
            // Reload to apply changes
            if (this.preferences.analytics || this.preferences.marketing) {
                window.location.reload();
            }
        }
    }
}

// Helper function
function hasConsent(type) {
    const consent = JSON.parse(localStorage.getItem('cookie_consent') || '{}');
    return consent[type] === true;
}
</script>
