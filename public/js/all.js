$(document).ready(function () {
    console.log('loaded all.js');


    $('.js-show-email').on('click', function (e) {
        e.preventDefault();
        let link = $(this);

        $.ajax({
            type: "GET",
            url: window.location.href + '/email',
            success: function (data) {
                console.log(data);

                link.parent().html(data.email ?? '-');
            }
        });
    });

    $('.js-show-phone').on('click', function (e) {
        e.preventDefault();
        let link = $(this);

        $.ajax({
            type: "GET",
            url: window.location.href + '/phone',
            success: function (data) {
                console.log(data);

                link.parent().html(data.phone ?? '-');
            }
        });
    });
});
