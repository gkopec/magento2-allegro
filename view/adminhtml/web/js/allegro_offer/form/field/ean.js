define([
    'jquery',
    'ko',
    'Magento_Ui/js/form/element/abstract',
    'Macopedia_Allegro/js/allegro_offer/validation/ean'
], function ($, ko, Input) {
    return Input.extend({

        loading: ko.observable(false),
        products: ko.observableArray([]),

        initialize: function () {
            this._super();
            this._validation();
        },

        _validation: function () {
            this.validation = this.validation || {};
            this.validation['allegro-ean'] = true;
            this.validation['max_text_length'] = 18;
        },

        checkProduct: function () {
            this.validate();
            this.products.removeAll();
            if(!this.checkInvalid() && this.value().length) {
                let self = this;
                $.ajax({
                    url: '/rest/V1/allegro/product/search-by-gtin/' + self.value(),
                    method: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        self._showSpinner();
                    },
                    success: function (response) {
                        $.each(response, function (k, product) {
                            self.products.push(product);
                        });
                    },
                    error: function (response) {
                        if (response.statusText === 'abort') {
                            return;
                        }
                        // TODO implement error popup
                        console.log('error 4');
                        console.log(response);
                    },
                    complete: function () {
                        self._hideSpinner();
                    }
                });
            }
        },

        _showSpinner: function () {
            this.loading(this.loading()+1);
        },

        _hideSpinner: function () {
            this.loading(this.loading()-1);
        },

        radioCheck: function () {
            let val = $('input[name="allegro_product"]:checked').val();
            if(val) {
                $('input[name="allegro[allegro_product]"]').val(val).change();
            }
        }
    });
});
