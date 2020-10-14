(function () {
    $('body').on('blur change', '#billing_postcode', function(){
        console.log("Test");
        var wrapper = $(this).closest('.form-row');

        if(! /(^\d{5}$)|(^[A-z0-9]{6}$)|(^[A-z0-9]{3}\s[A-z0-9]{3}$)|(^\d{5}-\d{4}$)|(^[A-z0-9]{3,10}$)/.test( $(this).val() ) ) {
            wrapper.addClass('woocommerce-invalid'); // error
            wrapper.removeClass('woocommerce-validated');
        } else {
            wrapper.removeClass('woocommerce-invalid');
            wrapper.addClass('woocommerce-validated'); // success
        }
    });

    $('body').on('blur change', '#billing_phone', function(){
        var wrapper = $(this).closest('.form-row');

        if(! /(^\+?[0-9]{10,15}$)/.test( $(this).val() ) ) { 
            wrapper.addClass('woocommerce-invalid'); // error
            wrapper.removeClass('woocommerce-validated');
        } else {
            wrapper.removeClass('woocommerce-invalid');
            wrapper.addClass('woocommerce-validated'); // success
        }
    });

    /**
     * Delete attribute title for tag input.custom-number__value
     */
    var isMobileVersion = document.getElementsByClassName('custom-number__value');
    if (isMobileVersion.length > 0) {
        document.getElementsByClassName('custom-number__value')[0].removeAttribute('title');
    }
	
})();