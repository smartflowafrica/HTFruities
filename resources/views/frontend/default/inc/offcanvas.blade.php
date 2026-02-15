<div class="offcanvas_menu position-fixed">
    <div class="tt-short-info d-none d-md-none d-lg-none d-xl-block">
        <button class="offcanvas-close"><i class="fa-solid fa-xmark"></i></button>
        <a href="{{ route('home') }}" class="logo-wrapper d-inline-block mb-5"><img
                src="{{ uploadedAsset(getSetting('navbar_logo')) }}" alt="logo"></a>
        <div class="offcanvas-content">
            <h4 class="mb-4">{{ 'About Us' }}</h4>
            <p>{{ getSetting('about_us') }}</p>
            <a href="{{ route('home.pages.aboutUs') }}" class="btn btn-primary mt-4">{{ 'About Us' }}</a>
        </div>
    </div>

    <div class="mobile-menu d-md-block d-lg-block d-xl-none mb-4">
        <button class="offcanvas-close"><i class="fa-solid fa-xmark"></i></button>

        <nav class="mobile-menu-wrapperoffcanvas-contact">
            <ul>
                @if (getSetting('show_theme_changes') != 0 || getSetting('show_theme_changes') == null)
                    @if (\App\Models\Theme::where('is_active', 1)->count() > 1)
                        @php
                            $theme = \App\Models\Theme::where('code', getTheme())->first();
                            $activeThemes = [];
                            if (getSetting('active_themes') != null) {
                                $activeThemes = \App\Models\Theme::whereIn('id', json_decode(getSetting('active_themes')))->get();
                            }
                        @endphp
                        <li class="has-submenu mt-5">
                            <a href="javascript:void(0);">{{ localize('Home') }}<span class="ms-1 fs-xs float-end"><i
                                        class="fa-solid fa-angle-right"></i></span></a>
                            <ul>
                                @foreach ($activeThemes as $key => $theme)
                                    <li>
                                        <a href="{{ route('theme.change', $theme->code) }}"
                                            class="d-flex align-items-center">
                                            <span>{{ localize($theme->name) }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif

                @if (!is_null(getSetting('header_menu_labels')))
                    @php
                        $labels = json_decode(getSetting('header_menu_labels')) ?? [];
                        $menus = json_decode(getSetting('header_menu_links')) ?? [];
                    @endphp

                    @foreach ($menus as $menuKey => $menuItem)
                        <li>
                            <a href="{{ $menuItem }}">{{ localize($labels[$menuKey]) }}</a>
                        </li>
                    @endforeach
                @else
                    <li>
                        <a href="{{ route('home') }}">{{ localize('Home') }}</a>
                    </li>
                    @php
                        $categories = [];
                        if (getSetting('navbar_categories') != null) {
                            $categories = \App\Models\Category::whereIn('id', json_decode(getSetting('navbar_categories')))->get();
                        }
                    @endphp
                    @if (getSetting('show_navbar_categories') != 0 || getSetting('show_navbar_categories') == null)
                    <li class="has-submenu">
                        <a href="javascript:void(0);">{{ localize('Categories') }}<span class="ms-1 fs-xs float-end"><i class="fa-solid fa-angle-right"></i></span></a>
                        <ul>
                            @foreach ($categories as $navbarCat)
                                <li>
                                    <a href="{{ route('products.index') }}?&category_id={{ $navbarCat->id }}">{{ $navbarCat->collectLocalization('name') }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('parfait.builder') }}" class="text-primary fw-bold">{{ localize('Build Your Parfait') }}</a>
                    </li>

                    <li>
                        <a href="{{ route('bulk-order.index') }}">{{ localize('Bulk Order') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('events.index') }}">{{ localize('Events') }}</a>
                    </li>
                @endif





                @if (getSetting('show_navbar_pages') != 0 || getSetting('show_navbar_pages') == null)
                    <li class="has-submenu">
                        <a href="javascript:void(0)">{{ localize('Pages') }}<span class="ms-1 fs-xs float-end"><i
                                    class="fa-solid fa-angle-right"></i></span></a>
                        <ul>
                            @php
                                $pages = [];
                                if (getSetting('navbar_pages') != null) {
                                    $pages = \App\Models\Page::whereIn('id', json_decode(getSetting('navbar_pages')))->get();
                                }
                            @endphp

                            <li><a href="{{ route('home.blogs') }}">{{ localize('Blogs') }}</a></li>
                            <li><a href="{{ route('home.pages.aboutUs') }}">{{ localize('About Us') }}</a></li>
                            <li><a href="{{ route('home.pages.contactUs') }}">{{ localize('Contact Us') }}</a></li>
                            @foreach ($pages as $navbarPage)
                                <li><a
                                        href="{{ route('home.pages.show', $navbarPage->slug) }}">{{ $navbarPage->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif



                @auth
                    <li>
                        <a href="{{ route('logout') }}">{{ localize('Sign Out') }}</a>
                    </li>
                @endauth
                @guest
                    <li>
                        <a href="{{ route('login') }}">{{ localize('Sign In') }}</a>
                    </li>
                @endguest

                {{-- Light/Dark Mode Toggle --}}
                <li>
                    <a href="javascript:void(0)" class="tt-theme-toggle w-100 d-flex align-items-center justify-content-between">
                        <span class="mode-label">{{ localize('Appearance') }}</span>
                        <div class="d-flex align-items-center">
                            <span class="tt-theme-light"><i class="fas fa-moon fs-lg"></i></span>
                            <span class="tt-theme-dark"><i class="fas fa-sun fs-lg"></i></span>
                        </div>
                    </a>
                </li>
            </ul>
        </nav>

    </div>

    <div class="offcanvas-contact mt-4">
        <h5 class="mb-4 mt-5">{{ 'Contact Info' }}</h5>
        <address>
            {{ getSetting('topbar_location') }} <br>
            <a href="tel:{{ getSetting('navbar_contact_number') }}">{{ getSetting('navbar_contact_number') }}</a> <br>
            <a href="mailto:{{ getSetting('topbar_email') }}">{{ getSetting('topbar_email') }}</a>
        </address>
    </div>
    <div class="offcanvas-contact social-contact mt-4">
        <a href="{{ getSetting('facebook_link') }}" target="_blank" class="social-btn"><i
                class="fab fa-facebook-f"></i></a>
        <a href="{{ getSetting('twitter_link') }}" target="_blank" class="social-btn"><i
                class="fab fa-twitter"></i></a>
        <a href="{{ getSetting('linkedin_link') }}" target="_blank" class="social-btn"><i
                class="fab fa-linkedin"></i></a>
        <a href="{{ getSetting('youtube_link') }}" target="_blank" class="social-btn"><i
                class="fab fa-youtube"></i></a>
    </div>
</div>
