jQuery.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    }
});

function loadMore() {
    const page = jQuery('#page').val(); //lay gia tri cua trường input có id là "page"
    jQuery.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: { page },
        url: '/services/load-product',
        success: function (result) {
            if (result.html !== '') {
                jQuery('#loadProduct').append(result.html);
                jQuery('#page').val(page + 1);
            } else {
                alert('Đã load xong Sản Phẩm');
                jQuery('#button-loadMore').css('display', 'none');
            }
        },
        error: function (xhr, status, error) {
            console.error('An error occurred:', status, error);
            alert('Đã xảy ra lỗi , vui lòng thử lại.');
        }
    });
}
