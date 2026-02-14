<section class="py-4 bg-white border-bottom">
    <div class="container">
        <div class="row g-4 justify-content-center text-center">
            <!-- Successful Deliveries -->
            <div class="col-6 col-md-4 border-end">
                <div class="stats-item">
                    @php
                        $successfulDeliveries = \App\Models\Order::where('delivery_status', 'delivered')->count();
                        // Optional: Add a base number to look more established if count is low
                        // $successfulDeliveries += 500; 
                    @endphp
                    <h2 class="mb-1 fw-bold text-primary display-5">{{ number_format($successfulDeliveries) }}+</h2>
                    <p class="mb-0 text-muted fw-bold">{{ localize('Successful Deliveries') }}</p>
                </div>
            </div>

            <!-- Happy Customers -->
            <div class="col-6 col-md-4 border-end-md">
                <div class="stats-item">
                    @php
                        $happyCustomers = \App\Models\User::where('user_type', 'customer')->count();
                    @endphp
                    <h2 class="mb-1 fw-bold text-secondary display-5">{{ number_format($happyCustomers) }}+</h2>
                    <p class="mb-0 text-muted fw-bold">{{ localize('Happy Customers') }}</p>
                </div>
            </div>
            
             <!-- Products Available -->
             <div class="col-12 col-md-4">
                <div class="stats-item">
                    @php
                        $productsCount = \App\Models\Product::isPublished()->count();
                    @endphp
                    <h2 class="mb-1 fw-bold text-danger display-5">{{ number_format($productsCount) }}+</h2>
                    <p class="mb-0 text-muted fw-bold">{{ localize('Products Available') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
