@extends('backend.layouts.master')

@section('title')
    {{ localize('Orders') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Orders') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="card mb-4" id="section-1">
                        <form class="app-search" action="{{ Request::fullUrl() }}" method="GET">
                            <div class="card-header border-bottom-0">
                                <div class="row justify-content-between g-3">
                                    <div class="col-auto flex-grow-1 d-none">
                                        <div class="tt-search-box">
                                            <div class="input-group">
                                                <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                                                        data-feather="search"></i></span>
                                                <input class="form-control rounded-start w-100" type="text"
                                                    id="search" name="search"
                                                    placeholder="{{ localize('Search by name/phone') }}"
                                                    @isset($searchKey)
                                                value="{{ $searchKey }}"
                                                @endisset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto flex-grow-1">
                                        <div class="input-group mb-3">
                                            @if (getSetting('order_code_prefix') != null)
                                                <div class="input-group-prepend">
                                                    <span
                                                        class="input-group-text rounded-end-0">{{ getSetting('order_code_prefix') }}</span>
                                                </div>
                                            @endif
                                            <input type="text" class="form-control" placeholder="{{ localize('code') }}"
                                                name="code"
                                                @isset($searchCode)
                                                value="{{ $searchCode }}"
                                                @endisset>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select select2" name="payment_status"
                                            data-minimum-results-for-search="Infinity" id="payment_status">
                                            <option value="">{{ localize('Payment Status') }}</option>
                                            <option value="{{ paidPaymentStatus() }}"
                                                @if (isset($paymentStatus) && $paymentStatus == paidPaymentStatus()) selected @endif>
                                                {{ localize('Paid') }}</option>
                                            <option value="{{ unpaidPaymentStatus() }}"
                                                @if (isset($paymentStatus) && $paymentStatus == unpaidPaymentStatus()) selected @endif>
                                                {{ localize('Unpaid') }}</option>
                                        </select>
                                    </div>


                                    @if (request()->routeIs('admin.orders.index'))
                                        <div class="col-auto">
                                            <select class="form-select select2" name="delivery_status"
                                                data-minimum-results-for-search="Infinity" id="update_delivery_status">
                                                <option value="">{{ localize('Delivery Status') }}</option>
                                                <option value="order_placed"
                                                    @if (isset($deliveryStatus) && $deliveryStatus == orderPlacedStatus()) selected @endif>
                                                    {{ localize('Order Placed') }}</option>
                                                <option value="pending" @if (isset($deliveryStatus) && $deliveryStatus == orderPendingStatus()) selected @endif>
                                                    {{ localize('Pending') }}
                                                <option value="processing"
                                                    @if (isset($deliveryStatus) && $deliveryStatus == orderProcessingStatus()) selected @endif>
                                                    {{ localize('Processing') }}
                                                <option value="delivered" @if (isset($deliveryStatus) && $deliveryStatus == orderDeliveredStatus()) selected @endif>
                                                    {{ localize('Delivered') }}
                                                <option value="cancelled"
                                                    @if (isset($deliveryStatus) && $deliveryStatus == orderCancelledStatus()) selected @endif>
                                                    {{ localize('Cancelled') }}
                                                </option>
                                            </select>
                                        </div>
                                    @endif

                                    @if (count($locations) > 0)
                                        <div class="col-auto">
                                            <select class="form-select select2" name="location_id"
                                                data-minimum-results-for-search="Infinity" id="location_id">
                                                <option value="">{{ localize('Location') }}</option>
                                                @foreach ($locations as $location)
                                                    <option value="{{ $location->id }}"
                                                        @if (isset($locationId) && $locationId == $location->id) selected @endif>
                                                        {{ $location->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    <div class="col-auto">
                                        <select class="form-select select2" name="is_pos_order"
                                            data-minimum-results-for-search="Infinity" id="is_pos_order">
                                            <option value="0" @if (isset($posOrder) && $posOrder == 0) selected @endif>
                                                {{ localize('Online Orders') }}
                                            </option>
                                            <option value="1" @if (isset($posOrder) && $posOrder == 1) selected @endif>
                                                {{ localize('POS Orders') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">
                                            <i data-feather="search" width="18"></i>
                                            {{ localize('Search') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <table class="table tt-footable border-top align-middle" data-use-parent-width="true">
                            <thead>
                                <tr>
                                    <th class="text-center" width="40">
                                        <input type="checkbox" id="selectAllOrders" class="form-check-input">
                                    </th>
                                    <th class="text-center">{{ localize('S/L') }}
                                    </th>
                                    <th>{{ localize('Order Code') }}</th>
                                    <th data-breakpoints="xs sm md">{{ localize('Customer') }}</th>
                                    <th>{{ localize('Placed On') }}</th>
                                    <th data-breakpoints="xs">{{ localize('Items') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Payment') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Status') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Type') }}</th>
                                    @if (count($locations) > 0)
                                        <th data-breakpoints="xs sm">{{ localize('Location') }}</th>
                                    @endif
                                    <th data-breakpoints="xs sm" class="text-end">{{ localize('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input order-checkbox" value="{{ $order->id }}">
                                        </td>
                                        <td class="text-center">
                                            {{ $key + 1 + ($orders->currentPage() - 1) * $orders->perPage() }}</td>

                                        <td class="fs-sm">
                                            {{ getSetting('order_code_prefix') }}{{ $order->orderGroup->order_code }}
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-md">
                                                    <img class="rounded-circle"
                                                        src="{{ uploadedAsset(optional($order->user)->avatar) }}"
                                                        alt="avatar"
                                                        onerror="this.onerror=null;this.src='{{ staticAsset('backend/assets/img/placeholder-thumb.png') }}';" />
                                                </div>
                                                <div class="ms-2">
                                                    <h6 class="fs-sm mb-0">{{ optional($order->user)->name }}</h6>
                                                    <span class="text-muted fs-sm">
                                                        {{ optional($order->user)->phone ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="fs-sm">{{ date('d M, Y', strtotime($order->created_at)) }}</span>
                                        </td>

                                        <td class="tt-tb-price">
                                            <span class="fw-bold">
                                                {{ $order->orderItems()->count() }}
                                            </span>
                                        </td>

                                        <td>
                                            @if ($order->payment_status == unpaidPaymentStatus())
                                                <span class="badge bg-soft-danger rounded-pill text-capitalize">
                                                    {{ $order->payment_status }}
                                                </span>
                                            @else
                                                <span class="badge bg-soft-primary rounded-pill text-capitalize">
                                                    {{ $order->payment_status }}
                                                </span>
                                            @endif
                                        </td>


                                        <td>
                                            @if ($order->delivery_status == orderDeliveredStatus())
                                                <span class="badge bg-soft-primary rounded-pill text-capitalize">
                                                    {{ $order->delivery_status }}
                                                </span>
                                            @elseif($order->delivery_status == orderCancelledStatus())
                                                <span class="badge bg-soft-danger rounded-pill text-capitalize">
                                                    {{ localize(Str::title(Str::replace('_', ' ', $order->delivery_status))) }}
                                                </span>
                                            @else
                                                <span class="badge bg-soft-info rounded-pill text-capitalize">
                                                    {{ localize(Str::title(Str::replace('_', ' ', $order->delivery_status))) }}
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <span
                                                class="badge rounded-pill text-capitalize {{ $order->shipping_delivery_type == getScheduledDeliveryType() ? 'bg-soft-warning' : 'bg-secondary' }}">
                                                {{ Str::title(Str::replace('_', ' ', $order->shipping_delivery_type)) }}
                                            </span>
                                        </td>

                                        @if (count($locations) > 0)
                                            <td>
                                                <span class="badge rounded-pill text-capitalize bg-secondary">
                                                    @if ($order->location)
                                                        {{ $order->location->name }}
                                                    @else
                                                        {{ localize('N/A') }}
                                                    @endif
                                                </span>
                                            </td>
                                        @endif

                                        <td class="text-end">
                                            @if (request()->routeIs('admin.deliverymen.cancel-request'))
                                                <a data-note="{{ $order->note }}"
                                                    class="btn btn-sm p-0 tt-view-details note" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="View Notes">
                                                    <i data-feather="edit-2"></i>
                                                </a>
                                            @endif
                                           
                                            @can('manage_orders')
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                    class="btn btn-sm p-0 tt-view-details" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="View Details">
                                                    <i data-feather="eye"></i>
                                                </a>
                                                <a href="{{ route('admin.orders.printInvoice', $order->id) }}"
                                                    class="btn btn-sm p-0 tt-priint-details" target="__blank" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="{{ localize('Print Invoice') }}">
                                                    <i data-feather="printer"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--pagination start-->
                        <div class="d-flex align-items-center justify-content-between px-4 pb-4">
                            <span>{{ localize('Showing') }}
                                {{ $orders->firstItem() }}-{{ $orders->lastItem() }} {{ localize('of') }}
                                {{ $orders->total() }} {{ localize('results') }}</span>
                            <nav>
                                {{ $orders->appends(request()->input())->links() }}
                            </nav>
                        </div>
                        <!--pagination end-->
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Bulk Action Bar --}}
    <div id="bulkActionBar" class="fixed-bottom bg-dark text-white py-3 px-4 d-none" style="z-index: 1050;">
        <div class="container d-flex align-items-center justify-content-between">
            <span>
                <strong id="selectedCount">0</strong> {{ localize('order(s) selected') }}
            </span>
            <div>
                <button type="button" class="btn btn-sm btn-outline-light me-2" id="clearSelection">
                    <i data-feather="x" width="14"></i> {{ localize('Clear') }}
                </button>
                <button type="button" class="btn btn-sm btn-danger" id="bulkDeleteBtn">
                    <i data-feather="trash-2" width="14"></i> {{ localize('Delete Selected') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="bulkDeleteModalLabel">{{ localize('Confirm Deletion') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ localize('Are you sure you want to delete') }} <strong id="modalDeleteCount">0</strong> {{ localize('order(s)?') }}</p>
                    <p class="text-danger mb-0"><small>{{ localize('This action cannot be undone. All related items and updates will also be removed.') }}</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ localize('Cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirmBulkDelete">
                        <span class="spinner-border spinner-border-sm d-none" id="deleteSpinner" role="status"></span>
                        {{ localize('Yes, Delete') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="note" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ localize('Rejection Note') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="note"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ localize('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(function() {
            // existing note modal
            $(document).on('click', '.note', function() {
                const modal = $('#note')
                modal.find('#note').text($(this).data('note'));
                modal.modal('show')
            });

            // ---- Bulk Selection & Delete ----
            const $bulkBar        = $('#bulkActionBar');
            const $selectedCount  = $('#selectedCount');
            const $modalCount     = $('#modalDeleteCount');
            const $deleteSpinner  = $('#deleteSpinner');
            const bulkDeleteModal = new bootstrap.Modal($('#bulkDeleteModal')[0]);

            function updateBulkBar() {
                const total   = $('.order-checkbox').length;
                const checked = $('.order-checkbox:checked').length;
                $selectedCount.text(checked);

                if (checked > 0) {
                    $bulkBar.removeClass('d-none');
                } else {
                    $bulkBar.addClass('d-none');
                }

                // sync select-all state
                $('#selectAllOrders').prop('checked', checked === total && total > 0);
                $('#selectAllOrders').prop('indeterminate', checked > 0 && checked < total);
            }

            // select all / deselect all  (delegated)
            $(document).on('change', '#selectAllOrders', function() {
                $('.order-checkbox').prop('checked', this.checked);
                updateBulkBar();
            });

            // individual checkbox (delegated)
            $(document).on('change', '.order-checkbox', function() {
                updateBulkBar();
            });

            // clear selection
            $('#clearSelection').on('click', function() {
                $('.order-checkbox').prop('checked', false);
                $('#selectAllOrders').prop('checked', false).prop('indeterminate', false);
                updateBulkBar();
            });

            // open confirm modal
            $('#bulkDeleteBtn').on('click', function() {
                const count = $('.order-checkbox:checked').length;
                $modalCount.text(count);
                bulkDeleteModal.show();
            });

            // confirm delete
            $('#confirmBulkDelete').on('click', function() {
                const ids = $('.order-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (ids.length === 0) return;

                $deleteSpinner.removeClass('d-none');
                $(this).prop('disabled', true);

                $.ajax({
                    url: '{{ route("admin.orders.bulkDelete") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order_ids: ids
                    },
                    success: function(res) {
                        bulkDeleteModal.hide();
                        window.location.reload();
                    },
                    error: function(xhr) {
                        $deleteSpinner.addClass('d-none');
                        $('#confirmBulkDelete').prop('disabled', false);
                        alert('{{ localize("Something went wrong. Please try again.") }}');
                    }
                });
            });
        })
    </script>
@endsection

