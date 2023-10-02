<x-dashboard-layout>
    <x-slot name="title_page">Edit Branch</x-slot>
    <x-slot name="title">Edit Branch</x-slot>

    <div class="modal-body py-lg-10 px-lg-10">
        <!--begin::Stepper-->
        <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid" id="kt_modal_create_app_stepper">
            <!--begin::Content-->
            <div class="flex-row-fluid py-lg-5 px-lg-15">
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-body">
                        <!--begin::Form-->
                        <form action="{{ route('branches.update', $branch->id) }}" method="POST" class="form" novalidate="novalidate" id="kt_modal_create_app_form">
                            @csrf
                            @method('PUT') <!-- Use the PUT method for updating -->

                            <!-- CSRF Token -->
                            <!--begin::Step 1-->
                            <div class="current" data-kt-stepper-element="content">
                                <div class="w-100">
                                    <!-- City -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark" for="city">
                                            <span class="required">City</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify the city"></i>
                                        </label>
                                        <select class="form-select form-select-lg form-select-solid" id="city" name="city_id">
                                            <option value="">Select City</option> <!-- Default option -->
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" {{ $branch->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Branch Name -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark" for="branchName">
                                            <span class="required">Branch Name</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify the branch name"></i>
                                        </label>
                                        <input type="text" class="form-control form-control-lg form-control-solid" id="branchName" name="branch_name" value="{{ $branch->branch_name }}" />
                                        @error('branch_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark" for="address">
                                            <span class="required">Address</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify the address"></i>
                                        </label>
                                        <input type="text" class="form-control form-control-lg form-control-solid" id="address" name="address" value="{{ $branch->address }}" />
                                        @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark" for="email">
                                            <span class="required">Email</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify the email"></i>
                                        </label>
                                        <input type="email" class="form-control form-control-lg form-control-solid" id="email" name="email" value="{{ $branch->email }}" />
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Mobile Number -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark" for="mobileNumber">
                                            <span class="required">Mobile Number</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify the mobile number"></i>
                                        </label>
                                        <input type="text" class="form-control form-control-lg form-control-solid" id="mobileNumber" name="mobile_number" value="{{ $branch->mobile_number }}" />
                                        @error('mobile_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2 text-dark" for="status">
                                            <span class="required">Status</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify the status"></i>
                                        </label>
                                        <select class="form-select form-select-lg form-select-solid" id="status" name="status">
                                            <option value="0" {{ $branch->status == 0 ? 'selected' : '' }}>Active</option>
                                            <option value="1" {{ $branch->status == 1 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
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
