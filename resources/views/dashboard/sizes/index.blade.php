<x-dashboard-layout>
    <x-slot name="title_page">
        Size Page
    </x-slot>

    <x-slot name="title">
        Size
    </x-slot>
     <x-alert></x-alert>
    <!--begin::Tables Widget 9-->
    <div class="card card-xl-stretch mb-5 mb-xl-8">
        <!--begin::Body-->
        <div class="card-body py-3">
            <div class="card-body py-3 d-flex justify-content-end">
                <a href="{{ route('sizes.create') }}" class="btn btn-primary">Add Size</a>
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
                            <th class="min-w-120px">Size Type</th>
                            <th class="min-w-120px">Price</th>
                            <th class="min-w-120px">Actions</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        @foreach($sizes as $size)
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
                                            {{ $size->size_type}}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">
                                            {{ $size->price }}
                                        </a>
                                    </div>
                                </div>
                            </td>






                            <td>
                                <!-- Action icons with links (replace placeholders) -->
                                <a href="{{route('sizes.edit' , $size->id)}}"
                                    class="btn btn-icon btn-light btn-sm mx-1">
                                    <!-- Replace with your edit icon -->
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Button to trigger the delete confirmation modal -->
                                <a href="#" class="btn btn-icon btn-danger btn-sm mx-1"
                                    onclick="showDeleteConfirmation({{ $size->id }})">
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
                                                Are you sure you want to delete this Size?
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
            deleteForm.action = "{{ route('sizes.destroy', '') }}" + '/' + cityId; // Set the correct delete route

            var deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();
        }
    </script>










</x-dashboard-layout>
