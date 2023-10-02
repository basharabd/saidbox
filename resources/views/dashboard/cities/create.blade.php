<x-dashboard-layout>
    <x-slot name="title_page">Create City</x-slot>
    <x-slot name="title">Create City</x-slot>

    <div class="modal-body py-lg-10 px-lg-10">
        <!--begin::Stepper-->
        <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid" id="kt_modal_create_app_stepper">
            <!--begin::Content-->
            <div class="flex-row-fluid py-lg-5 px-lg-15">
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-body">
                        <!--begin::Form-->
                        <form action="{{ route('cities.store') }}" method="POST" class="form" novalidate="novalidate" id="kt_modal_create_app_form">
                            @csrf <!-- CSRF Token -->
                            <!--begin::Step 1-->
                            <div class="current" data-kt-stepper-element="content">
                                <div class="w-100">
                                    <!-- Label 1 -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark">
                                            <span class="required">City Name</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify your unique app name"></i>
                                        </label>
                                        <input type="text" class="form-control form-control-lg form-control-solid" name="name" placeholder="City Name" />
                                    </div>
                                </div>
                            </div>
                            <!--end::Step 1-->
                            <!--begin::Actions-->
                            <!--end::Actions-->
                            <div>
                                <button type="submit" class="btn btn-success">Submit</button>
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
