@if ($banner != null) 
    <section class="home-slider position-relative home-mt" id="home">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" style="">
                    <img src="{{ asset($banner->path) }}" class="d-block w-100" alt="Banner Image" style="height: 370px;object-fit: cover;">
                </div>
            </div>
        </div>
    </section>   
@endif