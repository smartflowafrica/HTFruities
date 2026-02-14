$(document).ready(function () {
    const basePrice = 5.00;

    // --- UI Interactions ---

    // Update Summary & Price on Change
    $('input[name="base"], input[name="fruit"], input[name="toppings[]"], input[name="drizzle"]').on('change', function () {
        updateSummary();
    });

    function updateSummary() {
        let currentTotal = basePrice;

        // 1. Base
        const $base = $('input[name="base"]:checked');
        if ($base.length) {
            $('#summary-base').text($base.val());
            $('.visual-base').text($base.val()).fadeIn();
            currentTotal += parseFloat($base.data('price') || 0);

            // Enable Add to Cart if base is selected (minimum requirement)
            $('#add-to-cart-btn').prop('disabled', false);
        } else {
            $('#summary-base').text('-');
            $('.visual-base').fadeOut();
            $('#add-to-cart-btn').prop('disabled', true);
        }

        // 2. Fruit
        const $fruit = $('input[name="fruit"]:checked');
        if ($fruit.length) {
            $('#summary-fruit').text($fruit.val());
            $('.visual-fruit').text($fruit.val()).fadeIn();
            currentTotal += parseFloat($fruit.data('price') || 0);
        } else {
            $('#summary-fruit').text('-');
            $('.visual-fruit').fadeOut();
        }

        // 3. Toppings (Multi-select)
        const toppings = [];
        $('input[name="toppings[]"]:checked').each(function () {
            toppings.push($(this).val());
            currentTotal += parseFloat($(this).data('price') || 0);
        });

        if (toppings.length > 0) {
            $('#summary-toppings').text(toppings.join(', '));
            $('.visual-topping').text(toppings.join(' + ')).fadeIn();
        } else {
            $('#summary-toppings').text('-');
            $('.visual-topping').fadeOut();
        }

        // 4. Drizzle
        const $drizzle = $('input[name="drizzle"]:checked');
        if ($drizzle.length && $drizzle.val() !== 'None') {
            $('#summary-drizzle').text($drizzle.val());
            $('.visual-drizzle').text($drizzle.val() + ' Drizzle').fadeIn();
            currentTotal += parseFloat($drizzle.data('price') || 0);
        } else {
            $('#summary-drizzle').text('-');
            $('.visual-drizzle').fadeOut();
        }

        // Update Total Price
        $('#total-price').text('₦' + currentTotal.toFixed(2));

        // Hide/Show Empty State
        if ($base.length) {
            $('.empty-state').hide();
        } else {
            $('.empty-state').show();
        }
    }

    // --- Add to Cart Logic ---
    $('#add-to-cart-btn').on('click', function () {
        const formData = $('#parfait-form').serializeArray();

        // Add needed tokens
        formData.push({ name: '_token', value: $('meta[name="csrf-token"]').attr('content') });
        // Add base product ID (Placeholder for now, will be updated dynamically or via setup)
        formData.push({ name: 'product_id', value: 13 });

        $(this).prop('disabled', true).text('Adding...');

        $.ajax({
            url: '/build-your-parfait/add',
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.success) {
                    // Update cart count in header if it exists
                    // updateCartHeader(); 

                    // Show success message (using notify or alert)
                    alert('Parfait added to cart!');

                    // Redirect to cart or stay
                    window.location.href = '/carts';
                }
            },
            error: function (err) {
                console.error(err);
                alert('Something went wrong. Please try again.');
                $('#add-to-cart-btn').prop('disabled', false).text('Add to Cart');
            }
        });
    });
});
