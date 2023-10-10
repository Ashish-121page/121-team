<section id="blog" class="spacer-double-lg">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="mb-5 pb-5 text-center">
                    <h2 class="display-4">Recents Blog</h2>
                    <p class="w-md-60 mx-auto mb-0 lead">Our work with clients has always been at the intersection of deep industry expertise and extensive capabilities.</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($blog = fetchAll('App\Models\Article')->take(3); as $item)
            <div class="col-6 col-md-4 ">
                <div class="shadow h-100">
                    <div class="card-body p-5">
                        <img class="card-img-top" src="{{ asset('storage/backend/article/'.$item->description_banner) }}" alt="">
                        <a class="d-inline-block text-muted text-uppercase  small mb-2" href="#">Live events</a>
                        <h2 class="h5 ">
                            <a href="{{ url('article/'.$item->slug) }}">{{ $item->title }}</a>
                        </h2>
                        <p>{{ $item->short_description }} </p>
                    </div>
                </div>
            </div>
            
            @endforeach
        </div>
        {{-- <div class="row">
            <div class="col">
                <div class="mt-6 pt-6 text-center"> <a class="mr-2 btn btn-secondary btn-radius-bottom-left  mb-lg-0" href="#">
                <span class="mn-top">View all courses</span>
                </a>
                </div>
            </div>
        </div> --}}
    </div>
</section>