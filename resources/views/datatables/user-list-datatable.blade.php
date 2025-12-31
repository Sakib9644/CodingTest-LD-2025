<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <h3 class="mb-4">Users</h3>

        <table id="datatable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit User</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="user_id">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" id="name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" id="email" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" id="updateUser">Update</button>
                </div>
            </div>
        </div>
    </div>

        <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <script src="//code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script>
        $(document).ready(function () {

            let table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.list') }}",
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'created_at' },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });

            $(document).on('click', '.editUser', function () {
                let id = $(this).data('id');

                $.get(`/users/${id}`, function (data) {
                    $('#user_id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#editModal').modal('show');
                });
            });

            $('#updateUser').click(function () {
                let id = $('#user_id').val();

                $.ajax({
                    url: `/users/${id}`,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: $('#name').val(),
                        email: $('#email').val()
                    },
                    success: function (res) {
                        toastr.success(res.message, 'Success', {
                            positionClass: 'toast-top-right'
                        });

                        $('#editModal').modal('hide');
                        table.ajax.reload(null, false);
                    },
                    error: function () {
                        toastr.error('Validation error', 'Error', {
                            positionClass: 'toast-top-right'
                        });
                    }
                });
            });

        });
        </script>
</x-app-layout>
