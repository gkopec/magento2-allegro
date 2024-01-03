define([
    'jquery',
    'ko',
    'uiRegistry',
    'Magento_Ui/js/form/element/abstract',
    'Macopedia_Allegro/js/allegro_offer/validation/ean',
], function ($, ko, uiRegistry, Input) {
    return Input.extend({

        loading: ko.observable(false),
        errorMessage: ko.observable(''),
        products: ko.observableArray([]),
        selectedProduct: ko.observable(''),

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
            this.errorMessage('');
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
                        if(!response || !response.length){
                            self.errorMessage('No product has been found');
                        }
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

        productClick: function (product, event) {
            let ean = uiRegistry.get('index = ean');
            if(ean.selectedProduct() == product.id) {
                return;
            }
            ean.selectedProduct(product.id);
            $(event.currentTarget).find('[name="allegro_product"]').prop('checked', true);
            let cat = uiRegistry.get('index = category');
            let par = uiRegistry.get('index = parameters');
            par.value(JSON.parse(product.parameters_json));
            cat.initialValue = product.category;
            cat._initializeValue();
        }
    });
});
