<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset(config('constants.admin_path').'js/plugins/popper.min.js')}}"></script>
<script src="{{ asset(config('constants.admin_path').'js/plugins/simplebar.min.js')}}"></script>
<script src="{{ asset(config('constants.admin_path').'js/plugins/bootstrap.min.js')}}"></script>
<script src="{{ asset(config('constants.admin_path').'js/icon/custom-font.js')}}"></script>
<script src="{{ asset(config('constants.admin_path').'js/script.js')}}"></script>
<script src="{{ asset(config('constants.admin_path').'js/theme.js')}}"></script>
<script src="{{ asset(config('constants.admin_path').'js/plugins/feather.min.js')}}"></script>
<script src="{{ asset(config('constants.admin_path').'js/plugins/dataTables.min.js')}}"></script>
<script src="{{ asset(config('constants.admin_path').'js/plugins/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{ asset(config('constants.admin_path').'js/plugins/ckeditor/classic/ckeditor.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.1/sweetalert2.min.js"></script>
<script>
@if(Session::has('success'))
Swal.fire({
    title: "Success !",
    text: "{{ Session::get('success') }}",
    type: "success",
    confirmButtonClass: "btn btn-primary",
    buttonsStyling: !1,
    icon: "success"
});
@endif
@if(Session::has('error'))
Swal.fire({
    title: "Warning!",
    text: "{{ Session::get('error') }}",
    type: "warning",
    confirmButtonClass: "btn btn-primary",
    buttonsStyling: !1,
    icon: "warning"
});
@endif
</script>
<script>
    function loading()
    {
        Swal.fire({
        title: 'Please wait...',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
        });
    }
</script>
<script>
    document.querySelectorAll('.custom-file-input').forEach(function (input) {
    input.addEventListener('change', function () {
        const wrapper = this.closest('.custom-file-wrapper');
        const fileNameSpan = wrapper.querySelector('.file-name');
        fileNameSpan.textContent = this.files[0]?.name || '';
    });
    });
</script>
<script>
    document.querySelectorAll('.toggle').forEach(toggle => {
    toggle.addEventListener('click', () => {
        const parts = toggle.querySelectorAll('.toggle-part');
        parts.forEach(part => part.classList.toggle('active'));
    });
    });
</script>

