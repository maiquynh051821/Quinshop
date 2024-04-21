$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function removeRow(id,url)
{
    if(confirm('Nếu đã xóa không thể khôi phục. Bạn có chắc chắn muốn xóa không ? ')){
        $.ajax({
            type:'DELETE',
            datatype:'JSON',
            data: {id},
            url: url,
            success: function(result){
                if(result.error === false){
                    alert(result.message);
                    location.reload(); // Load lại trang 
                }else{
                    alert('Quá trình xóa bị lỗi! Vui lòng thử lại');
                }
            }
        })
    }
}