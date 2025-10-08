<div class="modal fade client-measurement-modal" id="clientMeasurementModal" tabindex="-1" aria-labelledby="clientMeasurementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="clientMeasurementModalLabel">Log Client Measurement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form>
            <div class="row d-flex align-items-center mb-25">
            <div class="col-lg-3">
                <div class="form-label mb-0">
                    <label>date</label>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="form-input">
                    <input type="date" class="form-control date-inp" name="" id="">
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Progress Picture</label>
                    <input type="file" class="form-control" name="" id="">
                </div>
            </div>
            </div>
            <div class="row d-flex align-items-center border-sm mb-25">
            <div class="col-lg-3">
                <div class="form-label mb-0">
                    <label>Body Weight ( kg )</label>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="form-input">
                    <input type="text" class="form-control text-inp" name="" id="">
                </div>
            </div>
            </div>
            <div class="row d-flex align-items-center border-sm mb-25">
            <div class="col-lg-3">
                <div class="form-label mb-0">
                    <label>Body Fat ( % )</label>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="form-input">
                    <input type="text" class="form-control text-inp" name="" id="">
                </div>
            </div>
            </div>
            <div class="text-center">
            <button type="submit" class="btn btn-submit btn-primary">Submit</button>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>
<!-- Goals Modal -->
<div class="modal fade" id="goalModal" tabindex="-1" aria-labelledby="goalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="goalModalLabel">Create a goal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form>
            <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="form-group">
                <label for="weight">Weight</label>
                <select class="form-control" name="weight" id="weight">
                    <option>Select</option>
                </select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="form-group">
                <label for="target">Target</label>
                <select class="form-control" name="target" id="target">
                    <option>Select</option>
                </select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="form-group">
                <label for="body_fats">Body fats</label>
                <select class="form-control" name="body_fats" id="body_fats">
                    <option>Select</option>
                </select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="form-group">
                <label for="target">Target</label>
                <select class="form-control" name="target" id="target">
                    <option>Select</option>
                </select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="form-group">
                <label for="muscle">Muscle</label>
                <select class="form-control" name="muscle" id="muscle">
                    <option>Select</option>
                </select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="form-group">
                <label for="target">Target</label>
                <select class="form-control" name="target" id="target">
                    <option>Select</option>
                </select>
                </div>
            </div>
            <div class="action-container text-end mb-4">
                <a href="javascript:void(0)" class="btn-link"><i class="ti ti-plus f-16"></i>Add new muscle</a>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-submit">Submit</button>
            </div>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>
<div class="modal fade" id="logModal" tabindex="-1" aria-labelledby="logModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="logModalLabel">Create log</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form id="measurement_log">
            <div class="row">
            <input type="hidden" id="client_measurement_part" name="client_measurement_part">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="form-group">
                <label for="weight">Measurement</label>
                <input type="text" class="form-control" id="client_measurement" name="client_measurement" autocomplete="off">
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-12">
                <div class="form-group">
                <label for="weight">Date</label>
                <input type="date" class="form-control" id="client_measurement_date" name="client_measurement_date" autocomplete="off">
                </div>
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-submit" onclick="submit_log();">Submit</button>
            </div>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>
<script>
function submit_log()
{
    var client_measurement = $('#client_measurement').val();
    var client_measurement_date = $('#client_measurement_date').val();
    var client_measurement_part = $('#client_measurement_part').val();
    var client = "{{$user->id}}";

    var csrf = "{{ csrf_token() }}";

    if(client_measurement_date != '' && client_measurement != '')
   {
     $.ajax({
        url:"{{route('trainer.add-measurement-log')}}",
        type:"post",
        data:'_token='+csrf+'&client_measurement='+client_measurement+'&client_measurement_date='+client_measurement_date+'&client_measurement_part='+client_measurement_part+'&client='+client,
        dataType:'json',
        success:function(data)
        {
            $('#logModal').modal('hide');
            if(data.status == 1)
            {
                $('#client_measurement').val('');
                $('#client_measurement_date').val('');
                Swal.fire({
                title: "Success !",
                text: "Measurement added ",
                type: "success",
                confirmButtonClass: "btn btn-primary",
                buttonsStyling: !1,
                icon: "success"
            });
            change_part(client_measurement_part);
            }
        }

        });
   }
   else
   {
        $('#logModal').modal('hide');
        Swal.fire({
        title: "Warning!",
        text: "Please fill all the mandatory fields",
        type: "warning",
        confirmButtonClass: "btn btn-primary",
        buttonsStyling: !1,
        icon: "warning"
    });
    }
}
</script>
