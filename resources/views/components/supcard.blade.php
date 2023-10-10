<div class='border-bottom  p-3'>
    <div class='row'>
        <div class='col-md-2 pr-0'>
            <img src='{{$profile}}'
                style='width: 55px;border-radius: 30px;' alt='' srcset='' class='text-center mx-auto'>
        </div>
        <div class='d-flex justify-content-between col-md-10 pl-0 mt-lg-0 mt-md-0 mt-3'>
            <div class='text-muted mb-0' style='width: 57%;'>
                <span class='text-muted'>
                    <i class='fa fa-reply'></i>
                    {{$phone}} -
                    <span>
                        {{$name}}
                    </span>
                    <div><small class='text-muted'>Request sent on {{$request_date}}</small></div>

                </span></div>
            <div class=''>
                <a href='{{$shoplink}}'
                    target='_blank' class='btn  btn-outline-primary btn-sm'>E-card</a>
            </div>
        </div>
    </div>
</div>