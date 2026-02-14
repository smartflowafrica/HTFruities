@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Bulk Order') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('breadcrumb-contents')
    <div class="breadcrumb-content">
        <h2 class="mb-2 text-center">{{ localize('Bulk Order') }}</h2>
        <nav>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item fw-bold" aria-current="page"><a
                        href="{{ route('home') }}">{{ localize('Home') }}</a></li>
                <li class="breadcrumb-item fw-bold" aria-current="page">{{ localize('Bulk Order') }}</li>
            </ol>
        </nav>
    </div>
@endsection

@section('contents')
    @include('frontend.default.inc.breadcrumb')

    <section class="bulk-order-section ptb-120">
        <div class="container">

            {{-- Search & Filter Bar --}}
            <div class="bg-white rounded-2 px-4 py-4 mb-5 shadow-sm">
                <form id="bulkOrderSearchForm" action="{{ route('bulk-order.index') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label class="fw-bold fs-xs text-dark mb-1">{{ localize('Search Products') }}</label>
                            <input type="text" name="search" class="form-control"
                                placeholder="{{ localize('Search by product name...') }}"
                                value="{{ $searchKey ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold fs-xs text-dark mb-1">{{ localize('Category') }}</label>
                            <select name="category_id" class="form-select">
                                <option value="">{{ localize('All Categories') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->collectLocalization('name') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="fa-solid fa-magnifying-glass me-1"></i>{{ localize('Filter') }}
                            </button>
                            <a href="{{ route('bulk-order.index') }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Bulk Order Table --}}
            <div class="bg-white rounded-2 shadow-sm overflow-hidden">

                {{-- Top Action Bar --}}
                <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom"
                    style="background: linear-gradient(135deg, #fff8f0 0%, #fff 100%);">
                    <div>
                        <h5 class="mb-1 fw-bold">
                            <i class="fa-solid fa-boxes-stacked text-primary me-2"></i>{{ localize('Select Products & Quantities') }}
                        </h5>
                        <p class="mb-0 text-muted fs-xs">
                            {{ localize('Set quantities for the products you want, then click "Add Selected to Cart"') }}
                        </p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge bg-primary-light text-primary fs-xs px-3 py-2 selected-count-badge"
                            style="background-color: rgba(255,124,8,0.1) !important;">
                            <span class="selected-count">0</span> {{ localize('item(s) selected') }}
                        </span>
                        <button type="button" class="btn btn-primary btn-md bulk-add-to-cart-btn" disabled>
                            <i class="fa-solid fa-cart-plus me-1"></i>{{ localize('Add Selected to Cart') }}
                        </button>
                    </div>
                </div>

                @if (count($products) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 bulk-order-table">
                            <thead>
                                <tr style="background-color: #f8f9fa;">
                                    <th class="ps-4" style="width: 50px;">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input select-all-checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th style="width: 80px;">{{ localize('Image') }}</th>
                                    <th>{{ localize('Product') }}</th>
                                    <th style="width: 130px;">{{ localize('Unit Price') }}</th>
                                    <th style="width: 170px;" class="text-center">{{ localize('Quantity') }}</th>
                                    <th style="width: 130px;" class="text-end pe-4">{{ localize('Subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    @php
                                        $isVariantProduct = $product->variations()->count() > 1;
                                        $variation = $product->variations->first();
                                        $stock = 0;
                                        if (!$isVariantProduct && $variation && $variation->product_variation_stock) {
                                            $stock = $variation->product_variation_stock->stock_qty;
                                        }
                                        $unitPrice = discountedProductBasePrice($product) ?? productBasePrice($product);
                                    @endphp

                                    <tr class="bulk-order-row" data-product-id="{{ $product->id }}"
                                        data-variation-id="{{ $isVariantProduct ? '' : ($variation ? $variation->id : '') }}"
                                        data-unit-price="{{ $unitPrice }}"
                                        data-is-variant="{{ $isVariantProduct ? '1' : '0' }}"
                                        data-stock="{{ $stock }}">

                                        <td class="ps-4">
                                            @if (!$isVariantProduct && $stock > 0)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input row-checkbox">
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="bulk-order-thumb"
                                                style="width: 60px; height: 60px; overflow: hidden; border-radius: 8px; border: 1px solid #eee;">
                                                <img src="{{ uploadedAsset($product->thumbnail_image) }}"
                                                    alt="{{ $product->collectLocalization('name') }}"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        </td>

                                        <td>
                                            <div>
                                                <a href="{{ route('products.show', $product->slug) }}"
                                                    class="fw-semibold text-dark d-block mb-1"
                                                    style="text-decoration: none;">
                                                    {{ $product->collectLocalization('name') }}
                                                </a>
                                                @if ($product->categories()->count() > 0)
                                                    <span class="text-muted fs-xxs">
                                                        @foreach ($product->categories as $category)
                                                            {{ $category->collectLocalization('name') }}{{ !$loop->last ? ',' : '' }}
                                                        @endforeach
                                                    </span>
                                                @endif

                                                @if ($isVariantProduct)
                                                    <span class="d-block mt-1">
                                                        <a href="javascript:void(0);"
                                                            onclick="showProductDetailsModal({{ $product->id }})"
                                                            class="text-primary fs-xxs fw-bold">
                                                            <i class="fa-solid fa-sliders me-1"></i>{{ localize('Select Options') }}
                                                        </a>
                                                    </span>
                                                @elseif($stock < 1)
                                                    <span class="badge bg-danger-light text-danger fs-xxs mt-1"
                                                        style="background-color: rgba(220,53,69,0.1) !important;">
                                                        {{ localize('Out of Stock') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <span class="fw-bold text-danger">{{ formatPrice($unitPrice) }}</span>
                                            @if ($product->unit)
                                                <small class="text-muted">/{{ $product->unit->collectLocalization('name') }}</small>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if (!$isVariantProduct && $stock > 0)
                                                <div class="qty-control d-inline-flex align-items-center"
                                                    style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                                                    <button type="button" class="qty-btn qty-decrease"
                                                        style="width: 36px; height: 36px; border: none; background: #f8f9fa; cursor: pointer; font-size: 16px; font-weight: bold; color: #666;">
                                                        −
                                                    </button>
                                                    <input type="number" class="qty-input text-center"
                                                        value="0" min="0"
                                                        max="{{ min($stock, $product->max_purchase_qty) }}"
                                                        style="width: 55px; height: 36px; border: none; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6; font-weight: 600; font-size: 14px; outline: none;"
                                                        data-max="{{ min($stock, $product->max_purchase_qty) }}">
                                                    <button type="button" class="qty-btn qty-increase"
                                                        style="width: 36px; height: 36px; border: none; background: #f8f9fa; cursor: pointer; font-size: 16px; font-weight: bold; color: #666;">
                                                        +
                                                    </button>
                                                </div>
                                            @elseif($isVariantProduct)
                                                <span class="text-muted fs-xs">{{ localize('Use options') }}</span>
                                            @else
                                                <span class="text-muted fs-xs">—</span>
                                            @endif
                                        </td>

                                        <td class="text-end pe-4">
                                            <span class="fw-bold row-subtotal"
                                                style="color: #28a745;">{{ formatPrice(0) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Bottom Action & Pagination --}}
                    <div class="px-4 py-3 border-top d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <button type="button" class="btn btn-primary btn-md bulk-add-to-cart-btn" disabled>
                                <i class="fa-solid fa-cart-plus me-1"></i>{{ localize('Add Selected to Cart') }}
                            </button>
                            <span class="text-muted fs-xs">
                                {{ localize('Showing') }}
                                {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}
                                {{ localize('of') }} {{ $products->total() }} {{ localize('results') }}
                            </span>
                        </div>
                        <nav>
                            {{ $products->appends(request()->input())->onEachSide(0)->links() }}
                        </nav>
                    </div>
                @else
                    <div class="text-center py-5">
                        <img src="{{ staticAsset('frontend/default/assets/img/empty-cart.svg') }}" alt=""
                            class="img-fluid mb-3" style="max-width: 200px;">
                        <p class="text-muted fw-semibold">{{ localize('No products found') }}</p>
                    </div>
                @endif
            </div>

            {{-- Order Summary Floating Bar --}}
            <div class="bulk-order-summary-bar" id="bulkOrderSummaryBar"
                style="display: none; position: fixed; bottom: 0; left: 0; right: 0; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); padding: 16px 0; z-index: 1050; box-shadow: 0 -4px 20px rgba(0,0,0,0.15);">
                <div class="container">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-4">
                            <div>
                                <span class="text-white-50 fs-xs">{{ localize('Selected Items') }}</span>
                                <h5 class="text-white mb-0 fw-bold summary-item-count">0</h5>
                            </div>
                            <div style="width: 1px; height: 40px; background: rgba(255,255,255,0.2);"></div>
                            <div>
                                <span class="text-white-50 fs-xs">{{ localize('Estimated Total') }}</span>
                                <h5 class="text-white mb-0 fw-bold summary-total">{{ formatPrice(0) }}</h5>
                            </div>
                        </div>
                        <button type="button" class="btn btn-lg text-white summary-add-btn bulk-add-to-cart-btn"
                            disabled
                            style="background: linear-gradient(135deg, #ff7c08 0%, #ff9a3c 100%); border: none; border-radius: 12px; padding: 12px 32px; font-weight: 700; box-shadow: 0 4px 15px rgba(255,124,8,0.3);">
                            <i class="fa-solid fa-cart-plus me-2"></i>{{ localize('Add Selected to Cart') }}
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <style>
        .bulk-order-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .bulk-order-table tbody tr:hover {
            background-color: #fff8f0 !important;
        }

        .bulk-order-table tbody tr.selected {
            background-color: #fff3e0 !important;
        }

        .qty-btn:hover {
            background: #e9ecef !important;
            color: #ff7c08 !important;
        }

        .qty-input::-webkit-inner-spin-button,
        .qty-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .qty-input[type='number'] {
            -moz-appearance: textfield;
        }

        .bulk-add-to-cart-btn:not(:disabled):hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 124, 8, 0.3);
        }

        .bulk-add-to-cart-btn {
            transition: all 0.2s ease;
        }

        .form-check-input:checked {
            background-color: #ff7c08;
            border-color: #ff7c08;
        }

        @media (max-width: 768px) {
            .bulk-order-summary-bar .container {
                flex-direction: column;
                gap: 12px;
            }

            .bulk-order-table th:first-child,
            .bulk-order-table td:first-child {
                display: none;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        "use strict";

        $(document).ready(function() {
            const currencySymbol = '{{ env("DEFAULT_CURRENCY_SYMBOL", "₦") }}';
            const currencyAlignment = {{ env('DEFAULT_CURRENCY_SYMBOL_ALIGNMENT', 0) }};

            function formatMoney(amount) {
                let formatted = parseFloat(amount).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                if (currencyAlignment == 0) {
                    return currencySymbol + formatted;
                } else {
                    return formatted + currencySymbol;
                }
            }

            function updateRowSubtotal(row) {
                const input = row.find('.qty-input');
                if (input.length === 0) return;

                const qty = parseInt(input.val()) || 0;
                const unitPrice = parseFloat(row.data('unit-price')) || 0;
                const subtotal = qty * unitPrice;

                row.find('.row-subtotal').text(formatMoney(subtotal));

                // Auto-check/uncheck based on qty
                const checkbox = row.find('.row-checkbox');
                if (qty > 0) {
                    checkbox.prop('checked', true);
                    row.addClass('selected');
                } else {
                    checkbox.prop('checked', false);
                    row.removeClass('selected');
                }
            }

            function updateSummary() {
                let totalItems = 0;
                let totalPrice = 0;

                $('.bulk-order-row').each(function() {
                    const input = $(this).find('.qty-input');
                    if (input.length === 0) return;

                    const qty = parseInt(input.val()) || 0;
                    if (qty > 0) {
                        totalItems++;
                        totalPrice += qty * (parseFloat($(this).data('unit-price')) || 0);
                    }
                });

                $('.selected-count').text(totalItems);
                $('.summary-item-count').text(totalItems);
                $('.summary-total').text(formatMoney(totalPrice));

                if (totalItems > 0) {
                    $('.bulk-add-to-cart-btn').prop('disabled', false);
                    $('#bulkOrderSummaryBar').slideDown(200);
                } else {
                    $('.bulk-add-to-cart-btn').prop('disabled', true);
                    $('#bulkOrderSummaryBar').slideUp(200);
                }
            }

            // Qty decrease
            $(document).on('click', '.qty-decrease', function() {
                const input = $(this).siblings('.qty-input');
                let val = parseInt(input.val()) || 0;
                if (val > 0) {
                    input.val(val - 1);
                    updateRowSubtotal($(this).closest('.bulk-order-row'));
                    updateSummary();
                }
            });

            // Qty increase
            $(document).on('click', '.qty-increase', function() {
                const input = $(this).siblings('.qty-input');
                let val = parseInt(input.val()) || 0;
                let max = parseInt(input.data('max')) || 999;
                if (val < max) {
                    input.val(val + 1);
                    updateRowSubtotal($(this).closest('.bulk-order-row'));
                    updateSummary();
                }
            });

            // Manual qty input
            $(document).on('change', '.qty-input', function() {
                let val = parseInt($(this).val()) || 0;
                let max = parseInt($(this).data('max')) || 999;
                if (val < 0) val = 0;
                if (val > max) val = max;
                $(this).val(val);
                updateRowSubtotal($(this).closest('.bulk-order-row'));
                updateSummary();
            });

            // Row checkbox toggle
            $(document).on('change', '.row-checkbox', function() {
                const row = $(this).closest('.bulk-order-row');
                const input = row.find('.qty-input');
                if ($(this).is(':checked')) {
                    if (parseInt(input.val()) === 0) {
                        input.val(1);
                    }
                    row.addClass('selected');
                } else {
                    input.val(0);
                    row.removeClass('selected');
                }
                updateRowSubtotal(row);
                updateSummary();
            });

            // Select all
            $('#selectAll').on('change', function() {
                const isChecked = $(this).is(':checked');
                $('.row-checkbox').each(function() {
                    $(this).prop('checked', isChecked);
                    const row = $(this).closest('.bulk-order-row');
                    const input = row.find('.qty-input');
                    if (isChecked) {
                        if (parseInt(input.val()) === 0) {
                            input.val(1);
                        }
                        row.addClass('selected');
                    } else {
                        input.val(0);
                        row.removeClass('selected');
                    }
                    updateRowSubtotal(row);
                });
                updateSummary();
            });

            // Bulk add to cart
            $(document).on('click', '.bulk-add-to-cart-btn', function() {
                let items = [];

                $('.bulk-order-row').each(function() {
                    const qty = parseInt($(this).find('.qty-input').val()) || 0;
                    const variationId = $(this).data('variation-id');

                    if (qty > 0 && variationId) {
                        items.push({
                            product_variation_id: variationId,
                            quantity: qty
                        });
                    }
                });

                if (items.length === 0) {
                    notifyMe('warning', '{{ localize("Please select at least one product") }}');
                    return;
                }

                // Disable buttons
                $('.bulk-add-to-cart-btn').prop('disabled', true).html(
                    '<i class="fa-solid fa-spinner fa-spin me-1"></i>{{ localize("Adding...") }}'
                );

                $.ajax({
                    type: "POST",
                    url: '{{ route("bulk-order.addToCart") }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        items: items
                    },
                    success: function(data) {
                        if (data.success) {
                            updateCarts(data);
                            notifyMe(data.alert, data.message);

                            // Reset all quantities
                            $('.qty-input').val(0);
                            $('.row-checkbox').prop('checked', false);
                            $('#selectAll').prop('checked', false);
                            $('.bulk-order-row').removeClass('selected');
                            $('.row-subtotal').text(formatMoney(0));
                            updateSummary();
                        } else {
                            notifyMe('error', data.message);
                        }

                        $('.bulk-add-to-cart-btn').html(
                            '<i class="fa-solid fa-cart-plus me-1"></i>{{ localize("Add Selected to Cart") }}'
                        );
                    },
                    error: function() {
                        notifyMe('error', '{{ localize("Something went wrong. Please try again.") }}');
                        $('.bulk-add-to-cart-btn').prop('disabled', false).html(
                            '<i class="fa-solid fa-cart-plus me-1"></i>{{ localize("Add Selected to Cart") }}'
                        );
                    }
                });
            });
        });
    </script>
@endsection
