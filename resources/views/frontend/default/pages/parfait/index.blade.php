@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Build Your Parfait') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('breadcrumb-contents')
    <div class="breadcrumb-content">
        <h2 class="mb-2">{{ localize('Build Your Parfait') }}</h2>
        <nav>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item fw-bold" aria-current="page"><a
                        href="{{ route('home') }}">{{ localize('Home') }}</a></li>
                <li class="breadcrumb-item fw-bold" aria-current="page">{{ localize('Customizer') }}</li>
            </ol>
        </nav>
    </div>
@endsection

@section('contents')
    <section class="tt-section pt-4 pb-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <p class="lead text-muted">{{ localize('Create your perfect layered treat in 4 simple steps!') }}</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Visual Stack Builder (Left Side on Desktop) -->
                <div class="col-lg-5 order-lg-2">
                    <div class="sticky-top" style="top: 100px; z-index: 1;">
                        <div class="card shadow-sm border-0 bg-light">
                            <div class="card-body text-center p-4 position-relative" style="min-height: 400px; overflow: hidden;">
                                <h5 class="card-title text-primary mb-3">{{ localize('Your Parfait Cup') }}</h5>
                                
                                <!-- Visual Container -->
                                <div id="parfait-visual" class="position-relative mx-auto mt-4" style="width: 200px; height: 350px; border: 2px solid rgba(0,0,0,0.1); border-radius: 0 0 100px 100px; border-top: none; background: rgba(255,255,255,0.8); overflow: hidden;">
                                    <!-- Layers will be absolutely positioned here -->
                                    <div id="layer-base" class="visual-layer" style="bottom: 0; height: 30%; background: #f0f0f0; width: 100%; position: absolute; transition: all 0.5s ease;"></div>
                                    <div id="layer-fruit" class="visual-layer" style="bottom: 30%; height: 30%; background: transparent; width: 100%; position: absolute; transition: all 0.5s ease;"></div>
                                    <div id="layer-toppings" class="visual-layer" style="bottom: 60%; height: 20%; background: transparent; width: 100%; position: absolute; transition: all 0.5s ease;"></div>
                                    <div id="layer-drizzle" class="visual-layer" style="bottom: 80%; height: 15%; background: transparent; width: 100%; position: absolute; transition: all 0.5s ease;"></div>
                                </div>

                                <!-- Total Price Badge -->
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-success fs-5 shadow">
                                        {{ getSetting('currency_symbol') }}<span id="total-price-display">0.00</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wizard Steps (Right Side on Desktop -> Logic: Inputs) -->
                <div class="col-lg-7 order-lg-1">
                    <form id="parfait-form">
                        @csrf
                        <input type="hidden" name="product_id" value="1"> <!-- Placeholder for Base Product ID -->
                        
                        <!-- Progress Bar -->
                        <div class="progress mb-4" style="height: 10px;">
                            <div id="wizard-progress" class="progress-bar bg-primary" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <!-- Step 1: Base -->
                        <div class="wizard-step active" id="step-1">
                            <h3 class="step-title mb-4">1. {{ localize('Choose Your Base') }}</h3>
                            <div class="row g-3">
                                @foreach ($bases as $base)
                                    <div class="col-md-6">
                                        <div class="option-card h-100 position-relative">
                                            <input type="radio" class="btn-check" name="base" id="base_{{ $base->id }}" 
                                                value="{{ $base->name }}" 
                                                data-price="{{ $base->price }}" 
                                                data-image="{{ $base->image ? asset('storage/'.$base->image) : '' }}"
                                                data-color="#FFF8E1" 
                                                autocomplete="off" required>
                                            <label class="btn btn-outline-secondary w-100 p-4 h-100 d-flex flex-column align-items-center justify-content-center" for="base_{{ $base->id }}">
                                                @if($base->image)
                                                    <img src="{{ asset('storage/'.$base->image) }}" class="mb-3 rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <i class="fas fa-ice-cream fa-3x mb-3 text-primary"></i>
                                                @endif
                                                <span class="fw-bold fs-5 d-block">{{ $base->name }}</span>
                                                <small class="text-muted mt-2">
                                                    @if($base->price > 0)
                                                        + {{ formatPrice($base->price) }}
                                                    @else
                                                        {{ $base->description ?? 'Free' }}
                                                    @endif
                                                </small>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 text-end">
                                <button type="button" class="btn btn-primary btn-lg px-5 next-step">{{ localize('Next: Add Fruits') }} <i data-feather="arrow-right"></i></button>
                            </div>
                        </div>

                        <!-- Step 2: Fruit -->
                        <div class="wizard-step d-none" id="step-2">
                            <h3 class="step-title mb-4">2. {{ localize('Layer Fruits') }}</h3>
                             <div class="row g-3">
                                @foreach ($fruits as $fruit)
                                    <div class="col-6 col-md-4">
                                        <input type="radio" class="btn-check" name="fruit" id="fruit_{{ $fruit->id }}" 
                                            value="{{ $fruit->name }}" 
                                            data-price="{{ $fruit->price }}" 
                                            data-image="{{ $fruit->image ? asset('storage/'.$fruit->image) : '' }}"
                                            data-color="#FFCDD2"
                                            autocomplete="off">
                                        <label class="btn btn-outline-light text-dark border w-100 p-3 h-100" for="fruit_{{ $fruit->id }}">
                                             @if($fruit->image)
                                                <img src="{{ asset('storage/'.$fruit->image) }}" class="mb-2 rounded" style="width: 100%; height: 80px; object-fit: cover;">
                                            @endif
                                            <span class="d-block fw-bold">{{ $fruit->name }}</span>
                                            @if($fruit->price > 0)
                                                <small class="text-primary">(+{{ formatPrice($fruit->price) }})</small>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                                <div class="col-6 col-md-4">
                                     <input type="radio" class="btn-check" name="fruit" id="fruit_none" value="" data-price="0" autocomplete="off" checked>
                                    <label class="btn btn-outline-secondary w-100 p-3 h-100 d-flex align-items-center justify-content-center" for="fruit_none">{{ localize('No Fruit') }}</label>
                                </div>
                            </div>
                            <div class="mt-4 d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary btn-lg prev-step"><i data-feather="arrow-left"></i> {{ localize('Back') }}</button>
                                <button type="button" class="btn btn-primary btn-lg px-5 next-step">{{ localize('Next: Add Crunch') }} <i data-feather="arrow-right"></i></button>
                            </div>
                        </div>

                        <!-- Step 3: Toppings -->
                        <div class="wizard-step d-none" id="step-3">
                            <h3 class="step-title mb-4">3. {{ localize('Add Crunch') }}</h3>
                            <div class="row g-3">
                                @foreach ($toppings as $topping)
                                    <div class="col-md-6">
                                        <div class="form-check p-3 border rounded h-100 position-relative">
                                            <input class="form-check-input" type="checkbox" name="toppings[]" 
                                                value="{{ $topping->name }}" 
                                                id="top_{{ $topping->id }}" 
                                                data-price="{{ $topping->price }}" 
                                                data-image="{{ $topping->image ? asset('storage/'.$topping->image) : '' }}">
                                            <label class="form-check-label fw-bold w-100 stretched-link d-flex align-items-center" for="top_{{ $topping->id }}">
                                                @if($topping->image)
                                                    <img src="{{ asset('storage/'.$topping->image) }}" class="me-3 rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    {{ $topping->name }}
                                                    @if($topping->price > 0)
                                                        <br><small class="text-primary">(+{{ formatPrice($topping->price) }})</small>
                                                    @endif
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary btn-lg prev-step"><i data-feather="arrow-left"></i> {{ localize('Back') }}</button>
                                <button type="button" class="btn btn-primary btn-lg px-5 next-step">{{ localize('Next: Final Touch') }} <i data-feather="arrow-right"></i></button>
                            </div>
                        </div>

                        <!-- Step 4: Drizzle -->
                        <div class="wizard-step d-none" id="step-4">
                            <h3 class="step-title mb-4">4. {{ localize('Final Touch') }}</h3>
                            <div class="row g-3 mb-4">
                                @foreach ($drizzles as $drizzle)
                                    <div class="col-6 col-md-4">
                                         <input type="radio" class="btn-check" name="drizzle" id="drizzle_{{ $drizzle->id }}" 
                                            value="{{ $drizzle->name }}" 
                                            data-price="{{ $drizzle->price }}" 
                                            data-image="{{ $drizzle->image ? asset('storage/'.$drizzle->image) : '' }}"
                                            autocomplete="off">
                                        <label class="btn btn-outline-dark w-100 p-3 h-100" for="drizzle_{{ $drizzle->id }}">
                                             @if($drizzle->image)
                                                <img src="{{ asset('storage/'.$drizzle->image) }}" class="mb-2 rounded" style="width: 100%; height: 60px; object-fit: cover;">
                                            @endif
                                            <span class="d-block">{{ $drizzle->name }}</span>
                                            @if($drizzle->price > 0)
                                                <small class="text-warning">(+{{ formatPrice($drizzle->price) }})</small>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                                <div class="col-6 col-md-4">
                                     <input type="radio" class="btn-check" name="drizzle" id="drizzle_none" value="" data-price="0" autocomplete="off" checked>
                                    <label class="btn btn-outline-secondary w-100 p-3 h-100 d-flex align-items-center justify-content-center" for="drizzle_none">{{ localize('No Drizzle') }}</label>
                                </div>
                            </div>
                            
                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-secondary btn-lg prev-step"><i data-feather="arrow-left"></i> {{ localize('Back') }}</button>
                                <button type="submit" class="btn btn-success btn-lg px-5 shadow-lg perform-add-to-cart">
                                    <i data-feather="shopping-bag" class="me-2"></i> {{ localize('Add to Cart') }} - {{ getSetting('currency_symbol') }}<span class="final-price-display">0.00</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let currentStep = 1;
            const totalSteps = 4;

            // --- Navigation ---
            $('.next-step').click(function() {
                // Validation (Simulated for Step 1 Base)
                if(currentStep === 1 && !$('input[name="base"]:checked').val()) {
                    notifyMe('error', '{{ localize("Please select a base layer") }}');
                    return;
                }

                if (currentStep < totalSteps) {
                    $('#step-' + currentStep).addClass('d-none').removeClass('active');
                    currentStep++;
                    $('#step-' + currentStep).removeClass('d-none').addClass('active');
                    updateProgress();
                }
            });

            $('.prev-step').click(function() {
                if (currentStep > 1) {
                    $('#step-' + currentStep).addClass('d-none').removeClass('active');
                    currentStep--;
                    $('#step-' + currentStep).removeClass('d-none').addClass('active');
                    updateProgress();
                }
            });

            function updateProgress() {
                let percent = (currentStep / totalSteps) * 100;
                $('#wizard-progress').css('width', percent + '%').attr('aria-valuenow', percent);
            }

            // --- Price Calculation & Visual Update ---
            $('input').on('change', function() {
                updateTotal();
                updateVisuals();
            });

            function updateTotal() {
                let total = 0;
                // Base
                let basePrice = parseFloat($('input[name="base"]:checked').data('price')) || 0;
                total += basePrice;
                // Fruit
                let fruitPrice = parseFloat($('input[name="fruit"]:checked').data('price')) || 0;
                total += fruitPrice;
                // Toppings
                $('input[name="toppings[]"]:checked').each(function() {
                    total += parseFloat($(this).data('price')) || 0;
                });
                // Drizzle
                let drizzlePrice = parseFloat($('input[name="drizzle"]:checked').data('price')) || 0;
                total += drizzlePrice;

                $('#total-price-display').text(total.toFixed(2));
                $('.final-price-display').text(total.toFixed(2));
            }

            function updateVisuals() {
                // Base Visualization
                let baseImg = $('input[name="base"]:checked').data('image');
                let baseColor = $('input[name="base"]:checked').data('color');
                let baseEl = $('#layer-base');
                
                if (baseImg) {
                    baseEl.css({'background-image': 'url(' + baseImg + ')', 'background-size': 'cover', 'background-color': 'transparent'});
                } else if(baseColor) {
                     baseEl.css({'background-image': 'none', 'background-color': baseColor});
                } else {
                     baseEl.css({'background-image': 'none', 'background-color': '#f0f0f0'});
                }

                // Fruit Visualization
                 let fruitImg = $('input[name="fruit"]:checked').data('image');
                 let fruitEl = $('#layer-fruit');
                 if (fruitImg) {
                    fruitEl.css({'background-image': 'url(' + fruitImg + ')', 'background-size': 'cover', 'opacity': 1});
                } else {
                    fruitEl.css({'background-image': 'none', 'opacity': 0.5}); // Dim placeholder if no image
                }
                
                // Topping Visualization (Simple)
                let topEl = $('#layer-toppings');
                let firstTopping = $('input[name="toppings[]"]:checked').first();
                let topImg = firstTopping.data('image');
                 if (topImg) {
                    topEl.css({'background-image': 'url(' + topImg + ')', 'background-size': 'cover', 'opacity': 1});
                } else if (firstTopping.length > 0) {
                     topEl.css({'background-color': '#D7CCC8', 'opacity': 0.8});
                } else {
                    topEl.css({'background-image': 'none', 'background-color': 'transparent'});
                }

                 // Drizzle Visualization
                 let drizzleImg = $('input[name="drizzle"]:checked').data('image');
                 let drizzleEl = $('#layer-drizzle');
                 if (drizzleImg) {
                    drizzleEl.css({'background-image': 'url(' + drizzleImg + ')', 'background-size': 'cover'});
                } else {
                    drizzleEl.css({'background-image': 'none'});
                }
            }

            // --- Add to Cart AJAX ---
             $('.perform-add-to-cart').click(function(e) {
                e.preventDefault();
                let form = $('#parfait-form');
                
                $.ajax({
                    type: "POST",
                    url: '{{ route('parfait.addToCart') }}',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            notifyMe('success', response.message);
                            updateCarts(response); // Update global cart UI
                        } else {
                            notifyMe('error', response.message);
                        }
                    },
                    error: function(err) {
                        notifyMe('error', 'Something went wrong');
                    }
                });
            });
            
            // Init
            updateTotal();
        });
    </script>
@endsection
