<!-- Android Install Banner -->
<div id="android-install-banner" class="hidden">
    <div class="flex items-center gap-3">
        <img src="{{ asset('images/icons/icon-192x192.png') }}" class="w-10 h-10 rounded-lg shadow-sm">
        <div>
            <span class="block text-sm font-bold text-gray-900 leading-tight">Pepperlemon App</span>
            <span class="block text-[10px] text-gray-500 font-semibold">Fast, easy, & offline-ready</span>
        </div>
    </div>
    <div class="flex gap-2">
        <button id="android-install-dismiss" class="text-xs text-gray-400 font-bold px-2 py-2">Later</button>
        <button id="android-install-btn" class="bg-primary text-white text-xs font-bold px-4 py-2 rounded-lg shadow-sm">Install</button>
    </div>
</div>

<!-- iOS Install Banner -->
<div id="ios-install-banner">
    <div class="close-btn" onclick="document.getElementById('ios-install-banner').style.display='none'"><i class="fa-solid fa-xmark"></i></div>
    <div class="flex items-center gap-3">
        <img src="{{ asset('images/icons/icon-192x192.png') }}" class="w-10 h-10 rounded-lg shadow-sm">
        <div class="leading-tight text-gray-700">
            Install <b>Pepperlemon</b> on your iPhone: tap <i class="fa-solid fa-arrow-up-from-bracket mx-1 text-blue-500 text-sm"></i> and then <b>Add to Home Screen</b> <i class="fa-regular fa-square-plus mx-1"></i>
        </div>
    </div>
</div>

<!-- PWA Registration & Install Logic -->
<script>
    // Register Service Worker
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js').then((registration) => {
                console.log('SW registered: ', registration);
            }).catch((registrationError) => {
                console.log('SW registration failed: ', registrationError);
            });
        });
    }

    // Install Prompt Logic
    let deferredPrompt;
    const androidBanner = document.getElementById('android-install-banner');
    const androidInstallBtn = document.getElementById('android-install-btn');
    const androidDismissBtn = document.getElementById('android-install-dismiss');
    const iosBanner = document.getElementById('ios-install-banner');

    if (androidBanner && androidInstallBtn && androidDismissBtn && iosBanner) {
        // Detect iOS Safari
        const isIos = () => {
            const userAgent = window.navigator.userAgent.toLowerCase();
            return /iphone|ipad|ipod/.test(userAgent);
        }
        
        // Detect if already installed (standalone mode)
        const isInStandaloneMode = () => {
            return ('standalone' in window.navigator && window.navigator.standalone) || 
                   window.matchMedia('(display-mode: standalone)').matches || 
                   window.matchMedia('(display-mode: fullscreen)').matches ||
                   window.matchMedia('(display-mode: minimal-ui)').matches;
        };

        if (isInStandaloneMode()) {
            const desktopBtn = document.getElementById('desktop-download-app-btn');
            const mobileBtn = document.getElementById('mobile-download-app-btn');
            if(desktopBtn) desktopBtn.style.display = 'none';
            if(mobileBtn) mobileBtn.style.display = 'none';
        }

        if (isIos() && !isInStandaloneMode()) {
            // Show iOS hint after 2 seconds if not dismissed previously
            if(!localStorage.getItem('iosInstallDismissed')) {
                setTimeout(() => {
                    iosBanner.style.display = 'block';
                }, 2000);
            }
        }

        // Handle Android install prompt
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            
            // Don't show if already in standalone mode
            if (isInStandaloneMode()) return;
            
            deferredPrompt = e;
            
            if(!localStorage.getItem('androidInstallDismissed')) {
                androidBanner.style.display = 'flex';
                androidBanner.classList.remove('hidden');
            }
        });

        // Hide banner immediately when installation is complete
        window.addEventListener('appinstalled', () => {
            androidBanner.style.display = 'none';
            deferredPrompt = null;
            
            // Also hide header buttons
            const desktopBtn = document.getElementById('desktop-download-app-btn');
            const mobileBtn = document.getElementById('mobile-download-app-btn');
            if(desktopBtn) desktopBtn.style.display = 'none';
            if(mobileBtn) mobileBtn.style.display = 'none';
            
            console.log('App successfully installed');
        });

        androidInstallBtn.addEventListener('click', async () => {
            androidBanner.style.display = 'none';
            if(deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                if (outcome === 'accepted') {
                    console.log('User accepted the A2HS prompt');
                }
                deferredPrompt = null;
            }
        });

        androidDismissBtn.addEventListener('click', () => {
            androidBanner.style.display = 'none';
            localStorage.setItem('androidInstallDismissed', 'true');
        });

        // Global manual trigger
        window.triggerPwaInstall = async () => {
            if (isInStandaloneMode()) {
                alert('App is already installed!');
                return;
            }
            if (isIos()) {
                iosBanner.style.display = 'block';
            } else if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                if (outcome === 'accepted') {
                    console.log('User accepted the manual A2HS prompt');
                }
                deferredPrompt = null;
                androidBanner.style.display = 'none';
            } else {
                alert('Please install from your browser menu by selecting "Add to Home Screen".');
            }
        };
    }
</script>
