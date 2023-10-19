<div class="">

    

    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between">

                <div class="extra">

                </div>
                
                <div class="icons">
                    <a href="#" class="btn btn-icon btn-outline-primary"  title="Download and Upload Current Data" id="importfile">
                        <i class="fas fa-download"></i>
                    </a>


                    <button class="btn btn-icon btn-outline-success" title="Upload New Data with Excel" id="exportfile">
                        <i class="fas fa-upload"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>





    {{-- Currency Table --}}
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-light">
                    <thead>
                        <tr>
                            <th scope="col">S.no</th>
                            <th scope="col">Currency</th>
                            <th scope="col">Rate</th>
                            <th scope="col">Default</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        @foreach ($record as $item)
                            <tr class="">
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{ $item->currency }}</td>
                                <td>{{ $item->exchange }}</td>
                                <td>
                                    @if ($item->default_currency == 1)
                                        <button class="btn btn-outline-primary btn-sm border-rounded" type="button" disabled>
                                            Default  
                                        </button>
                                    @else
                                        <a href="{{ route('panel.currency.make.default',$item->id) }}" class="btn btn-sm btn-outline-primary">
                                            Make Default
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        
                        
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    
</div>