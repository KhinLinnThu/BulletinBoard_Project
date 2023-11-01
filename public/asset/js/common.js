// checkbox all delete
$('#select_all_id').click(function () {
    $('.checked_id').prop('checked', $(this).prop('checked'))
});
$('.checked_id').on('click', function () {
    if ($('.checked_id:checked').length == $('.checked_id').length) {
        $('#select_all_id').prop('checked', true);
    } else {
        $('#select_all_id').prop('checked', false);
    }
});

// input profile create
function showPreview(event) {
    if (event.target.files.length > 0) {
        var src = URL.createObjectURL(event.target.files[0]);
        var preview = document.getElementById("image-file-preview");
        preview.src = src;
        preview.style.display = "block";
    }
}
