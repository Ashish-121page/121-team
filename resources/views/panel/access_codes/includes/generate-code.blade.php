<div class="modal fade" id="createCode" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterLabel">{{ __('Generate Code')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panel.access_codes.generate-code') }}" method="post">
                        @csrf
                        <div class="row">
                            @if (AuthRole() == 'Admin')
                                <div class="col-12">
                                    <div class="form-group {{ $errors->has('number') ? 'has-error' : ''}}">
                                        <label for="number" class="control-label">Marketer<span class="text-danger">*</span></label>
                                        <select id="" name="marketer" class="form-control" required>
                                            <option value="" aria-readonly="true">Select Marketer</option>
                                            @foreach (marketerList() as $marketer)
                                                <option value="{{ $marketer->id }}">{{ $marketer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @else
                                
                            @endif
                            <div class="col-12">
                                <div class="form-group {{ $errors->has('number') ? 'has-error' : ''}}">
                                    <label for="number" class="control-label">{{ 'How many code you want to make' }} <span class="text-danger">*</span></label>
                                    <input class="form-control" name="number_of_code" type="number" value="" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button> --}}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>