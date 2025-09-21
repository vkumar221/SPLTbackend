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

