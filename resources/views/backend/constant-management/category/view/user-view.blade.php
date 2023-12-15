<div class="col-md-12">
  

    <div class="row">
        <div class="col-md-12 col-12">
          <div class="accordion" id="accordionExample">
  
                @if(count($category) > 0)
                    @foreach($category as $key=> $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="btn shadow-none collapsed collapseicon bg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}" style="width: 100%;text-align: left;border-bottom: 2px solid #6666cc;">
                                    
                                    <i class="fas fa-angle-right iconchange" ></i>
                                    {{ $item['name'] }} 
                                    {{-- {{ $item['type'] == 1 ? "" : "(Self)" }} --}}
                                </button>
                            </h2>
                            <div id="collapse{{$key}}" class="accordion-collapse accordion-collapse collapse">
                                <div class="accordion-body">                                   
                                    <div class="row" id="appendbox-{{$key}}">

                                          {{-- Adding A New Item --}}
                                          <div class="col-3 d-flex align-items-center">
                                            <div class="d-flex justify-content-between gap-2">
                                                <div class="">
                                                    <span class="btn btn-outline-primary additems" data-parentdata="appendbox-{{$key}}">
                                                        <i class="fas fa-plus"></i> Add New Item
                                                    </span>
                                                    <span class="btn btn-outline-primary savebtn d-none" data-parentdata="appendbox-{{$key}}" data-parent-id="{{ $item['id'] }}">
                                                        Save
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    {{-- ` Getting Sub Categories --}}
                                    @php
                                        $user_selected_category_id = json_decode(auth()->user()->selected_category);    
                                        
                                        if ($item['user_id'] == auth()->id()) {
                                            $subcategories = App\Models\Category::where('parent_id',$item['id'])->get();
                                        }else{
                                            $subcategories = App\Models\Category::whereIn('id',$user_selected_category_id)->where('parent_id',$item['id'])->get();
                                        }
                                    @endphp
                                    @forelse ($subcategories as $index => $subcategory)
                                        <div class="col-3 my-2">
                                            <div class="justify-content-between gap-2 d-none" id="pbox_edit-{{$key}}-{{ $index }}">
                                                <input type="text" name="changeme" value="{{ $subcategory->name }}" class="form-control w-70" placeholder="Enter New Value" id="edit_box_{{$key}}-{{ $index }}">

                                                <div class="w-25">

                                                    <button class="btn btn-outline-primary shadow-none btn-icon updatechange" type="button" data-input-parent="edit_box_{{$key}}-{{ $index }}" data-typevalue="{{ $subcategory->id }}" >
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                    
                                                    <button class="btn btn-outline-danger shadow-none btn-icon discardchange" data-box-parent="pbox_edit-{{$key}}-{{ $index }}" data-box-text="pbox_show-{{$key}}-{{$index}}" type="button">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            {{-- original style --}}
                                            <div class="d-flex justify-content-between gap-2" id="pbox_show-{{$key}}-{{$index}}">                                                
                                                    <div class="w-70">
                                                        <span id="text-represent-{{$key}}-{{$index}}">{{ $subcategory->name }}</span>
                                                    </div>
                                                    <div class="w-25">
                                                        <button class="btn btn-outline-primary shadow-none btn-icon editchange" type="button" data-box-parent="pbox_show-{{$key}}-{{$index}}" data-box-edit="pbox_edit-{{$key}}-{{ $index }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                        <a href="{{ route('panel.constant_management.category.delete',encrypt($subcategory->id)) }}"  class="btn btn-outline-danger shadow-none btn-icon">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-3">
                                            There's Nothing To Show Here...
                                        </div>
                                    @endforelse

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center">
                        There is no Custom Category
                    </div>
                @endif
            
          </div>
        </div>
    </div>

</div>


<script>
    $("input").keypress(function (e) { 
        console.log(e.target.value);
        var keyCode = e.which;
        var keyChar = String.fromCharCode(keyCode);
        var specialChars = ["#",'$','=','{','}','|','\\',';','"',"'",'?','/','~','`','!']; // Array of special characters

        if (specialChars.includes(keyChar)) {
            e.preventDefault(); // Prevent entering special characters
        }
    });    

</script>
