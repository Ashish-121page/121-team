@extends('backend.layouts.main')
@section('title', 'Proposal')
@section('content')
    @php
    /**
     * Proposal
     *
     * @category  zStarter
     *
     * @ref  zCURD
     * @author    GRPL
     * @license  121.page
     * @version  <GRPL 1.1.0>
     * @link        https://121.page/
     */
    $breadcrumb_arr = [['name' => 'Add Proposal', 'url' => 'javascript:void(0);', 'class' => '']];
    @endphp
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <style>
            .error {
                color: red;
            }

        </style>
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add Proposal</h5>
                            <span>Create a record for Proposal</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 mx-auto">
                <!-- start message area-->
                @include('backend.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3>Create Proposal</h3>
                    </div>
                    @php
                        $user_shop_id = App\Models\UserShop::whereUserId(auth()->id())->first();
                    @endphp
                    <div class="card-body">
                        <form action="{{ route('panel.proposals.store') }}" method="post" enctype="multipart/form-data"
                            id="ProposalForm">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <input type="hidden" name="user_shop_id" value="{{ $user_shop_id->id }}">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('customer_name') ? 'has-error' : '' }}">
                                        <label for="customer_name" class="control-label">Customer Name<span
                                                class="text-danger">*</span> </label>
                                        <input required class="form-control customerNameChange" name="customer_name"
                                            type="text" id="customer_name" value="{{ old('customer_name') }}"
                                            placeholder="Enter Customer Name">
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('customer_mob_no') ? 'has-error' : '' }}">
                                        <label for="customer_mob_no" class="control-label">Customer Mobile Number<span
                                                class="text-danger">*</span> </label>
                                        <input required class="form-control" name="customer_mob_no" type="number"
                                            id="customer_mob_no" value="{{ old('customer_mob_no') }}"
                                            placeholder="Enter Customer Details">
                                    </div>
                                </div>
                                {{-- <div class="col-md-12 col-12">
                                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                        <label for="slug" class="control-label">Slug<span class="text-danger">*</span>
                                        </label>
                                        <input readonly required class="form-control" name="slug" type="text" id="slug"
                                            value="{{ old('slug') }}" placeholder="Enter Slug">
                                    </div>
                                </div> --}}

                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="proposal_note" class="control-label">Proposal Note <span
                                                class="text-danger">*</span> </label>
                                        <textarea class="form-control" rows="7" name="proposal_note" id="proposal_note"
                                            placeholder="Enter Proposal Note">{{ old('proposal_note') }}</textarea>
                                    </div>
                                </div>



                                <div class="col-md-12 ml-auto">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
        <script>
            $('#ProposalForm').validate();

            $('.customerNameChange').on('change keyup paste', function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $('#slug').val(Text);
            });
        </script>
    @endpush
@endsection
