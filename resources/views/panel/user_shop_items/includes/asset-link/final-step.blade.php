@extends('backend.layouts.main')
@section('title', 'Asset Link')

<!-- push external head elements to head -->
@push('head')
@endpush
@section('content')

@php
    $products = App\Models\Product::whereIn('id',$product)->groupBy('model_code')->get();
@endphp

    <div class="row">

        <div class="col-12">
            <div class="alert alert-warning" role="alert">
                <i class="ik ik-info mr-1" title="Do not Go Back or Refesh This page"></i>
               Do not Go Back or Refesh This page
             </div>
        </div>
        <div class="col-12 text-center ">
            <div class="h5">Products Created - {{ count($products) }} </div>
        </div>
        <div class="col-12 mb-3 d-flex flex-wrap justify-content-center">

            @forelse ($products as $i => $get_product)
            {{-- @php
                $get_product = App\Models\Product::find($item);
            @endphp --}}

                <div class="d-flex flex-column text-center m-2" style="width: max-content;background-color: #F4F4F5;">
                    <img src="{{ asset(getShopProductImage($get_product->id)->path ?? 'frontend/assets/img/placeholder.png' ) }}" alt="{{ $get_product->title ?? '--' }}"
                        class="img-fluid p-2"
                        style="height: 100px;width: 100px;object-fit: contain;border-radius: 10px !important">
                    <span>Model: {{ Str::limit($get_product->model_code, 10, '...') ?? '--' }} </span>
                    <a href="{{ route('panel.products.edit',$get_product->id) }}" class="btn btn-link text-primary " target="_blank">
                        Fill Details <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>

            @empty
                <div class="col-12 text-center">
                    <div class="h5">No Product Found</div>
                </div>
            @endforelse

        </div>

        <div class="col-12 d-flex justify-content-center ">
            <a  href="{{ route('panel.user_shop_items.create') . '?type=direct&type_ide=' . encrypt(auth()->id()) }}&assetvault=true" class="btn btn-outline-primary">
                Fill Later
            </a>
        </div>


    </div>



@endsection

<!-- push external js -->

@push('script')
@endpush
