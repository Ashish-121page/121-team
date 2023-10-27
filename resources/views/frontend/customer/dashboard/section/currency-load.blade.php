<div class="">

    

    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between">

                <div class="extra">
                    <h5 class="">Currencies</h5>
                </div>
                
                <div class="icons">
                    <button class="btn btn-icon btn-outline-success" title="Upload New Data with Excel" id="addcurrencyopen">
                        <i class="fas fa-plus-circle"></i>
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
                            <th scope="col">Edit</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        @foreach ($currency_record   as $item)
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
                                            Set Default
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary updatecurrencybtn" data-crrid="{{ $item->id }}" data-crrname="{{ $item->currency }}" data-crrvalue="{{ $item->exchange }}" >
                                        <i class="fas fa-pencil-alt"></i>   
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        
                        
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    
</div>