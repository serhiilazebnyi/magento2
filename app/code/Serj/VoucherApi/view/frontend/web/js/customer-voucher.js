define([
        'uiComponent',
        'mage/storage',
        'mage/url'
    ], function (uiComponent, storage, urlBuilder) {
    return uiComponent.extend({
        defaults: {
            template: "Serj_VoucherApi/customer-voucher"
        },
        initialize: function () {
            var self = this;
            this._super();
            this.observe(['vouchers']);

            setInterval(function () {
                storage.get(
                    urlBuilder.build('rest/V1/voucher/my-vouchers/'),
                    true,
                    'application/json').success(function (response) {
                    self.vouchers(response);
                })
            }, 2000);
        }
    });
});
