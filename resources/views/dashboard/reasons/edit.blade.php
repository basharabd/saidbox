<x-dashboard-layout>
    <x-slot name="title_page">Edit Reason</x-slot>
    <x-slot name="title">Edit Reason</x-slot>

    <div class="modal-body py-lg-10 px-lg-10">
        <!--begin::Stepper-->
        <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid"
            id="kt_modal_create_app_stepper">
            <!--begin::Content-->
            <div class="flex-row-fluid py-lg-5 px-lg-15">
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-body">
                        <!--begin::Form-->
                        <form action="{{ route('reason.update', $reason->id) }}" method="POST" class="form"
                            novalidate="novalidate" id="kt_modal_create_app_form">
                            @csrf
                            @method('PUT')
                            <!-- Use the PUT method for updating -->

                            <!-- CSRF Token -->
                            <!--begin::Step 1-->
                            <div class="current" data-kt-stepper-element="content">
                                <div class="w-100">

                                    <!-- Reason Name -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark"
                                            for="reason">
                                            <span class="required">Reason Name</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify the reason name"></i>
                                        </label>
                                        <input type="text" class="form-control form-control-lg form-control-solid"
                                            id="reason" name="reason" value="{{ $reason->reason }}" />
                                        @error('reason')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark"
                                            for="description">
                                            <span class="required">Description</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify the description"></i>
                                        </label>
                                        <input type="text" class="form-control form-control-lg form-control-solid"
                                            id="description" name="description"  value="{{ $reason->description }}"/>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>



                                </div>
                            </div>
                            <!--end::Step 1-->

                            <!-- Display the "Update" button outside of the form -->
                            <div class="text-end mt-5">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Stepper-->
    </div>
</x-dashboard-layout>
