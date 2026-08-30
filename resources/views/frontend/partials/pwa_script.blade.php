<!-- Android Install Banner -->
<div id="android-install-banner" class="position-fixed bottom-0 start-0 w-100 bg-white border-top shadow-lg" style="display: none; z-index: 9999; padding: 15px;">
    <div class="d-flex align-items-center gap-3">
        <img src="{{ asset('images/icons/icon-192x192.png') }}" class="rounded shadow-sm" style="width: 40px; height: 40px;">
        <div>
            <span class="d-block fw-bold text-dark" style="font-size: 0.875rem; line-height: 1.25;">Pepperlemon App</span>
            <span class="d-block fw-semibold text-secondary" style="font-size: 0.65rem;">Fast, easy, & offline-ready</span>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button id="android-install-dismiss" class="btn btn-link text-secondary fw-bold text-decoration-none p-2" style="font-size: 0.75rem;">Later</button>
        <button id="android-install-btn" class="btn btn-pl-primary fw-bold px-3 py-2 shadow-sm" style="font-size: 0.75rem; border-radius: 8px;">Install</button>
    </div>
</div>

<!-- iOS Install Banner -->
<div id="ios-install-banner" class="position-fixed bg-white border shadow-lg rounded-4" style="display: none; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; width: 90%; max-width: 380px; padding: 12px 16px;">
    <div class="close-btn position-absolute bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="top: -10px; right: -10px; width: 24px; height: 24px; cursor: pointer; font-size: 14px;" onclick="document.getElementById('ios-install-banner').style.display='none'"><i class="bi bi-x"></i></div>
    <div class="d-flex align-items-center gap-3">
        <img src="{{ asset('images/icons/icon-192x192.png') }}" class="rounded shadow-sm" style="width: 40px; height: 40px;">
        <div class="text-secondary" style="line-height: 1.25; font-size: 0.75rem;">
            Install <b>Pepperlemon</b> on your iPhone: tap <i class="bi bi-box-arrow-up mx-1 text-primary"></i> and then <b>Add to Home Screen</b> <i class="bi bi-plus-square mx-1"></i>
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
                
                // Check for service worker updates every hour
                setInterval(() => {
                    registration.update();
                }, 60 * 60 * 1000);
            }).catch((registrationError) => {
                console.log('SW registration failed: ', registrationError);
            });
        });

        // Automatically reload the page once if the service worker updates and takes control
        let refreshing = false;
        navigator.serviceWorker.addEventListener('controllerchange', () => {
            if (!refreshing) {
                refreshing = true;
                window.location.reload();
            }
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
