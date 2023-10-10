<div class="card-body">
    <div class="d-flex justify-content-between mb-2 flex-wrap">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    <option value="50"{{ $users->perPage() == 50 ? 'selected' : ''}}>50</option>
                    <option value="100"{{ $users->perPage() == 100 ? 'selected' : ''}}>100</option>
                    <option value="500"{{ $users->perPage() == 500 ? 'selected' : ''}}>500</option>
                </select>
                entries
            </label>
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive hideTable" >
        <table id="user_table" class="table">
            <thead>
                <tr>
                    <th class="text-center">S.No </th>
                    <th class="">Name</th>
                    <th class="">Register At</th>
                    <th class="">Status</th>
                    <th class="">Active Packages</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    @php
                        $userPackageCount = App\Models\UserPackage::whereUserId($user->id)->count();
                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ getFormattedDate($user->created_at) }}</td>
                        <td><span
                                class="badge badge-{{ $user->status == 0 ? 'danger' : 'success' }}">{{ $user->status == 0 ? 'Inactive' : 'Active' }}</span>
                        </td>
                        <td>{{ $userPackageCount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer d-flex justify-content-between">
    <div class="pagination">
        {{ $users->appends(request()->except('page'))->links() }}
    </div>
    <div>
       @if($users->lastPage() > 1)
            <label for="">Jump To: 
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                    @for ($i = 1; $i <= $users->lastPage(); $i++)
                        <option value="{{ $i }}" {{ $users->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </label>
       @endif
    </div>
</div>
