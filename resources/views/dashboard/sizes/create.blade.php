<x-dashboard-layout>
    <x-slot name="title_page">Create Size</x-slot>
    <x-slot name="title">Create Size</x-slot>

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
                        <form action="{{ route('sizes.store') }}" method="POST" class="form" novalidate="novalidate"
                            id="kt_modal_create_app_form">
                            @csrf
                            <!-- CSRF Token -->
                            <!--begin::Step 1-->
                            <div class="current" data-kt-stepper-element="content">
                                <div class="w-100">




                                    <!-- Size Type -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark" for="size_type">
                                            <span class="required">Size Type</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify the size type"></i>
                                        </label>
                                        <input type="text" class="form-control form-control-lg form-control-solid" id="size_type" name="size_type" />
                                        @error('size_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- price -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark" for="price">
                                            <span class="required">Price</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify the price"></i>
                                        </label>
                                        <input type="number" class="form-control form-control-lg form-control-solid" id="price" name="price" />
                                        @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>
                            </div>

                            <!--end::Step 1-->



                        <!-- Display the "Update" button outside of the form -->
                        <div class="text-end mt-5">
                            <button type="submit" class="btn btn-success">Save</button>
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
