

    {{-- Crud Routes Start--}}

    Route::group([@if($data['controller_namespace'] != null)'namespace' => '{{ $data['controller_namespace'] }}',@endif 'prefix' => '{{ $prefix }}','as' =>'{{$as}}.'], function () {
        Route::get('', ['uses' => '{{ $data['model'] }}Controller@index', 'as' => 'index']);
        Route::any('/print', ['uses' => '{{ $data['model'] }}Controller@print', 'as' => 'print']);
        Route::get('create', ['uses' => '{{ $data['model'] }}Controller@create', 'as' => 'create']);
        Route::post('store', ['uses' => '{{ $data['model'] }}Controller@store', 'as' => 'store']);
        Route::get('/{{'{'.substr($variable, 1).'}'}}', ['uses' => '{{ $data['model'] }}Controller@show', 'as' => 'show']);
        Route::get('edit/{{'{'.substr($variable, 1).'}'}}', ['uses' => '{{ $data['model'] }}Controller@edit', 'as' => 'edit']);
        Route::post('update/{{'{'. substr($variable, 1) .'}'}}', ['uses' => '{{ $data['model'] }}Controller@update', 'as' => 'update']);
        Route::get('delete/{{'{'. substr($variable, 1).'}' }}', ['uses' => '{{ $data['model'] }}Controller@destroy', 'as' => 'destroy']);
    }); 
    
    {{-- Crud Routes End--}}

