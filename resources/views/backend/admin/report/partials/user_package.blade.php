<div class="card-body">
    <div class="d-flex justify-content-between mb-2 flex-wrap">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    <option value="50"{{ $user_packages->perPage() == 50 ? 'selected' : ''}}>50</option>
                    <option value="100"{{ $user_packages->perPage() == 100 ? 'selected' : ''}}>100</option>
                    <option value="500"{{ $user_packages->perPage() == 500 ? 'selected' : ''}}>500</option>
                </select>
                entries
            </label>
        </div>
        {{-- <div>
            <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
        </div> --}}
        <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive">
        <table id="table" class="table">
            <thead>     
                <tr>
                    <th  class="text-center ">S.No </th>
                    <th class="">Name</th>                       
                    <th class="">Total Package Price</th>
                    <th class="">Total</th>
                    <th class="">Expiry Date</th> 
                    <th class="">Active Packages</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user_packages as  $user_package)
                @php
                    $ids = App\Models\UserPackage::whereUserId($user_package->user_id)->pluck('order_id');
                    $total_price = App\Models\Order::whereIn('id',$ids)->sum('total');
                    $active_packages = App\Models\UserPackage::whereUserId($user_package->user_id)->where('to','>=',now())->first();
                @endphp
                <tr>
                    <td class="text-center ">{{ $loop->iteration }}</td>
                    <td>{{ NameById($user_package->user_id) ?? 'N/A'}}</td>
                    <td>{{ format_price($total_price) ?? '0' }}</td>
                    <td>{{ App\Models\UserPackage::whereUserId($user_package->user_id)->count() ?? '0' }}</td>
                    <td>{{ getFormattedDate($user_package->to) }}</td>
                    @if (isset($active_packages->package_id))
                    <td>{{ getPackageRecordById($active_packages->package_id)->name ?? ''}}</td>
                    @else
                        <td>Package Deleted</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer d-flex justify-content-between">
    <div class="pagination">
        {{ $user_packages->appends(request()->except('page'))->links() }}
    </div>
    <div>
       @if($user_packages->lastPage() > 1)
            <label for="">Jump To: 
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                    @for ($i = 1; $i <= $user_packages->lastPage(); $i++)
                        <option value="{{ $i }}" {{ $user_packages->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </label>
       @endif
    </div>
</div>
