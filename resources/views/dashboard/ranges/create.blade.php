<x-dashboard-layout>
    <x-slot name="title_page">Create Range</x-slot>
    <x-slot name="title">Create Range</x-slot>

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
                        <form action="{{ route('ranges.store') }}" method="POST" class="form" novalidate="novalidate"
                            id="kt_modal_create_app_form">
                            @csrf
                            <!-- CSRF Token -->
                            <!--begin::Step 1-->
                            <div class="current" data-kt-stepper-element="content">
                                <div class="w-100">
                                    <!-- Label 1 - City ID -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark">
                                            <span class="required">From City</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify your unique app name"></i>
                                        </label>
                                        <select class="form-select form-select-lg form-select-solid" name="city_id">
                                            <option value="">Select From City</option>
                                            @foreach ($cities as $cityId => $cityName)
                                            <option value="{{ $cityId }}" {{ old('city_id')==$cityId ? 'selected' : ''
                                                }}>{{ $cityName }}</option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Label 2 - To City ID -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark">
                                            <span class="required">To City </span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify your unique app name"></i>
                                        </label>
                                        <select class="form-select form-select-lg form-select-solid" name="to_city_id">
                                            <option value="">Select To City </option>
                                            @foreach ($cities as $cityId => $cityName)
                                            <option value="{{ $cityId }}" {{ old('to_city_id')==$cityId ? 'selected'
                                                : '' }}>{{ $cityName }}</option>
                                            @endforeach
                                        </select>
                                        @error('to_city_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Label 3 - Price -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark">
                                            <span class="required">Price</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify your unique app name"></i>
                                        </label>
                                        <input type="text" class="form-control form-control-lg form-control-solid"
                                            name="price" />
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
