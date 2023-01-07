<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            processing: true,
            serverside: true,
            ajax: "{{ url('pegawaiAjax') }}",
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'nama',
                name: 'Nama'
            }, {
                data: 'email',
                name: 'Email'
            }, {
                data: 'aksi',
                name: 'Aksi'
            }]
        });
    });
    //global setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
        }
    });
    //proses simpan
    $('body').on('click', '.tombol-tambah', function(e) {
        e.preventDefault();
        $('#exampleModal').modal('show');

        $('.tombol-simpan').click(function() {
            $.ajax({
                url: 'pegawaiAjax',
                type: 'POST',
                data: {
                    nama: $('#nama').val(),
                    email: $('#email').val()
                },
                success: function(response) {
                    if (response.errors) {
                        console.log(response.errors);
                        $('.alert-danger').removeClass('d-none');
                        $('.alert-danger').html("<ul>");
                        $.each(response.errors, function(key, value) {
                            $('.alert-danger').find('ul').append("<li>" + value +
                                "</li>");
                        });
                    } else {
                        $('.alert-success').removeClass('d-none');
                        $('.alert-success').html(response.success);
                    }
                    $('#myTable').DataTable().ajax.reload();
                }
            });
        });
    });
    $('#exampleModal').on('hidden.bs.modal', function() {
        $('#nama').val('');
        $('#email').val('');

        $('.alert-danger').addClass('d-none');
        $('.alert.danger').html('');

        $('.alert-success').addClass('d-none');
        $('.alert-success').html('');
    });
</script>
