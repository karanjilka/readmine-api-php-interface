Vue.filter('limit', function (value, limit) {
    //console.log(value.substr(0,15));
  return value.substr(0,limit);
});

Vue.directive('select', {
    twoWay: true,
    priority: 1000,

    params: ['options'],

    bind: function() {
        var self = this
        $(this.el)
            .select2({
                data: this.params.options
            })
            .on('change', function() {
                self.set(this.value)
            })
    },
    update: function(value) {
        $(this.el).val(value).trigger('change')
    },
    unbind: function() {
        $(this.el).off().select2('destroy')
    }
});

Vue.directive('datepicker', {
    twoWay: true,
    priority: 1000,
    params: ['dateformat'],
    bind: function() {
        var self = this;
        $(this.el).datepicker({
            dateFormat:this.params.dateformat,
            onSelect: function (date) {
                self.set(this.value)
            }
        });
    },
    update: function(value) {
        $(this.el).datepicker('setDate', value);
    }
});
