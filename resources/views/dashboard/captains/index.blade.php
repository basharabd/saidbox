<x-dashboard-layout>
    <x-slot name="title_page">
        Captains Page
    </x-slot>

    <x-slot name="title">
        Captains
    </x-slot>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!--begin::Tables Widget 9-->
    <div class="card card-xl-stretch mb-5 mb-xl-8">
        <!--begin::Body-->
        <div class="card-body py-3">
            <div class="card-body py-3 d-flex justify-content-end">
                <a href="{{ route('captains.create') }}" class="btn btn-primary">Add captain</a>
            </div>

            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fw-bolder text-muted">
                            <th class="w-25px">
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" data-kt-check="true"
                                        data-kt-check-target=".widget-9-check" />
                                </div>
                            </th>
                            <th class="min-w-120px">Captain Name</th>
                            <th class="min-w-120px">Mobile Number</th>
                            <th class="min-w-120px">Date Of Birth</th>
                            <th class="min-w-120px">IDNumber</th>
                            <th class="min-w-120px">Address</th>
                            <th class="min-w-120px">Description</th>
                            <th class="min-w-120px">City</th>
                             <th class="min-w-120px">Status</th>
                            <th class="min-w-120px">Actions</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        @foreach($captains as $captain)
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" data-kt-check="true"
                                        data-kt-check-target=".widget-9-check" />
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">
                                            {{ $captain->captain_name}}
                                            <!-- Access the city name through the relationship -->
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">
                                            {{ $captain->mobile_number }}
                                            <!-- Access the to city name through the relationship -->
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">
                                            {{ $captain->date_of_birth }}
                                        </a>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">
                                            {{ $captain->id_number }}
                                        </a>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">
                                            {{ $captain->address }}
                                        </a>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">
                                            {{ $captain->description }}
                                        </a>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">
                                            {{ $captain->city->name }}
                                        </a>
                                    </div>
                                </div>
                            </td>


                            <!-- Your table cell for each record -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">

                                        </a>
                                    </div>
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input status-toggle" type="checkbox"
                                            id="statusToggle_{{ $captain->id }}" data-captain-id="{{ $captain->id }}" {{
                                            $captain->status == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold text-gray-400 ms-3"
                                            for="statusToggle_{{ $captain->id }}"></label>
                                    </div>
                                </div>
                            </td>






                            <td>
                                <!-- Action icons with links (replace placeholders) -->
                                <a href="{{route('captains.edit' , $captain->id)}}"
                                    class="btn btn-icon btn-light btn-sm mx-1">
                                    <!-- Replace with your edit icon -->
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Button to trigger the delete confirmation modal -->
                                <a href="#" class="btn btn-icon btn-danger btn-sm mx-1"
                                    onclick="showDeleteConfirmation({{ $captain->id }})">
                                    <i class="fas fa-trash"></i>
                                </a>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteConfirmationModal" tabindex="-1"
                                    aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm
                                                    Deletion</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this captain?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <form id="deleteForm" action="" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Tables Widget 9-->


    <script>
        function showDeleteConfirmation(cityId) {
            var deleteForm = document.getElementById('deleteForm');
            deleteForm.action = "{{ route('captains.destroy', '') }}" + '/' + cityId; // Set the correct delete route

            var deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();
        }
    </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).on('change', '.status-toggle', function () {
            var isChecked = $(this).prop('checked');
            var captainId = $(this).data('captain-id');
            var newStatus = isChecked ? 0 : 1;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ route('update-captain-status') }}', // Updated route name
                data: {
                    captain_id: captainId,
                    status: newStatus
                },
                cache: false,
                success: function (response) {
                    if (response.success) {
                        // Update the status text on the page for the specific record
                        $('#statusText_' + captainId).removeClass('text-success text-danger');
                        $('#statusText_' + captainId).addClass(newStatus === 0 ? 'text-success' : 'text-danger');
                        $('#statusText_' + captainId).text(newStatus === 0 ? 'Active' : 'Inactive');
                    } else {
                        // Handle any server-side errors or validation failures
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    // Handle client-side errors
                    console.error(error);
                }
            });
        });
    });
</script>









</x-dashboard-layout>
