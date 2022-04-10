(function ($) {

    $.fn.generateSlug = function () {
        $(this).on('keyup', function (e) {
            let target = $('#' + $(this).data('slug'));
            return target.val(slugger($(this).val()));
        })
    }


})(jQuery);

Function.prototype.method = function (name, func) {
    // pastikan method belum ada sebelumnya.
    if (!this.prototype[name]) {
        this.prototype[name] = func;
        return this;
    }
};

Number.method("bulatkan", function () {
    return Math.floor(this);
});

function notif(type, option = Object) {
    // console.log(this);
    return toastr[type](option.title, option.message, {
        closeButton: true,
        tapToDismiss: false,
    });
}

function slugger(value) {
    return value.trim()
        .toLowerCase()
        .replace(/[^a-z\d-]/gi, '-')
        .replace(/-+/g, '-').replace(/^-|-$/g, "");
}


