<x-dashboard-layout>
    <x-slot name="title_page">Create Captain</x-slot>
    <x-slot name="title">Create Captain</x-slot>

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
                        <form action="{{ route('captains.store') }}" method="POST" class="form" novalidate="novalidate">
                            @csrf
                            <!-- CSRF Token -->
                            <!--begin::Step 1-->
                            <div class="current" data-kt-stepper-element="content">
                                <div class="w-100">

                                    <!-- Captain Name -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark"
                                            for="branchName">
                                            <span class="required">Captain Name</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify the captain name"></i>
                                        </label>
                                        <input type="text" class="form-control form-control-lg form-control-solid"
                                            name="captain_name" />
                                        @error('captain_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- City -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark" for="city">
                                            <span class="required">City</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify the city"></i>
                                        </label>
                                        <select class="form-select form-select-lg form-select-solid" id="city"
                                            name="city_id">
                                            <option value="">Select City</option> <!-- Default option -->
                                            @foreach($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark"
                                            for="address">
                                            <span class="required">Address</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify the address"></i>
                                        </label>
                                        <input type="text" class="form-control form-control-lg form-control-solid"
                                            id="address" name="address" />
                                        @error('address')
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
                                            name="description" />
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Mobile Number -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark"
                                            for="mobileNumber">
                                            <span class="required">Mobile Number</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify the mobile number"></i>
                                        </label>
                                        <input type="text" class="form-control form-control-lg form-control-solid"
                                            id="mobileNumber" name="mobile_number" />
                                        @error('mobile_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- ID Number -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark"
                                            for="id_number">
                                            <span class="required">ID Number</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify the id_number"></i>
                                        </label>
                                        <input type="text" class="form-control form-control-lg form-control-solid"
                                            id="id_number" name="id_number" />
                                        @error('id_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Date Of Birth -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark"
                                            for="date_of_birth">
                                            <span class="required">Date Of Birth</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify the date_of_birth"></i>
                                        </label>
                                        <input type="date" class="form-control form-control-lg form-control-solid"
                                            id="date_of_birth" name="date_of_birth" />
                                        @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark"
                                            for="status">
                                            <span class="required">Status</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify the status"></i>
                                        </label>
                                        <select class="form-select form-select-lg form-select-solid" id="status"
                                            name="status">
                                            <option value="0" selected>Active</option>
                                            <option value="1">Inactive</option>
                                        </select>
                                        @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                               <!-- Display the "Update" button outside of the form -->
                        <div class="text-end mt-5">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                        </form>
                        <!--end::Form-->
                            <!--end::Step 1-->
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
