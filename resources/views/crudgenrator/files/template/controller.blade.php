<{{ $data['wildcard'] }}php

@if($data['controller_namespace'])

namespace App\Http\Controllers\{{ $data['controller_namespace'] }};
use App\Http\Controllers\Controller;

@else
namespace App\Http\Controllers;
@endif
use Illuminate\Http\Request;
use App\Models\{{ $data['model'] }};

class {{ $data['model'] }}Controller extends Controller
{
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
         $length = 10;
         if(request()->get('length')){
             $length = $request->get('length');
         }
         {{ $indexvariable }} = {{ $data['model'] }}::query();
         
            if($request->get('search')){
                {{ $indexvariable }}->where('id','like','%'.$request->search.'%')
                @foreach(explode(',',$data['search']) as $col)
                ->orWhere('{{ $col }}','like','%'.$request->search.'%')
                @endforeach;
            }
            
            if($request->get('from') && $request->get('to')) {
                {{ $indexvariable }}->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                {{ $indexvariable }}->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                {{ $indexvariable }}->orderBy($request->get('desc'),'desc');
            }
            {{ $indexvariable }} = {{ $indexvariable }}->paginate($length);

            if ($request->ajax()) {
                return view('{{ $data['dotviewpath'] }}{{ $data['name'] }}.load', ['{{ substr($indexvariable, 1) }}' => {{ $indexvariable }}])->render();  
            }
 
        return view('{{ $data['dotviewpath'] }}{{ $data['name'] }}.index', compact('{{ substr($indexvariable, 1) }}'));
    }

    {{-- public function index(Request $request)
    {
        try{
            {{ $indexvariable }} = fetchAll('App\Models\{{ $data['model'] }}');
            return view('{{ $data['dotviewpath'] }}{{ $data['name'] }}.index',compact('{{ substr($indexvariable, 1) }}'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    } --}}
        public function print(Request $request){
            {{ $indexvariable }} = collect($request->records['data']);
                return view('{{ $data['dotviewpath'] }}{{ $data['name'] }}.print', ['{{ substr($indexvariable, 1) }}' => {{ $indexvariable }}])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('{{ $data['dotviewpath'] }}{{ $data['name'] }}.create');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        @if(count($data['validations']['field']) > 0 && $data['validations']['field'][0] != null)

        $this->validate($request, [
            @foreach($data['validations']['field'] as $index => $item)
            '{{ $item }}'     => '{{ $data['validations']['rules'][$index] }}',
            @endforeach
        ]);
        @endif

        try{
            @foreach($data['fields']['input'] as $key => $input_type)@if($input_type == "checkbox" || $input_type == "radio")
           
            if(!$request->has('{{ $data['fields']['name'][$key] }}')){
                $request['{{ $data['fields']['name'][$key] }}'] = 0;
            }
            @endif @endforeach

            @foreach($data['fields']['input'] as $key => $input_type)@if($input_type == "file")

            if($request->hasFile("{{ $data['fields']['name'][$key] }}_file")){
                $request['{{ $data['fields']['name'][$key] }}'] = $this->uploadFile($request->file("{{ $data['fields']['name'][$key] }}_file"), "{{ $data['name'] }}")->getFilePath();
            } else {
                return $this->error("Please upload an file for {{ $data['fields']['name'][$key] }}");
            }
            @endif @endforeach

            {{ $variable }} = {{ $data['model'] }}::create($request->all());
        @if(array_key_exists('mail',$data) && $data['mail'] == 1)

        /**
        *     $mailcontent_data = App\Models\MailSmsTemplate::where('code','=',"Welcome")->first();
        *    $arr=[
        *        '{name}'=>"User",
        *        '{id}'=>"MYID",
        *        '{phone}'=>"",
        *        '{email}'=>"",
        *    ];
        *   customMail("Admin",getSetting('admin_email'),$mailcontent_data,$arr,null ,null ,$action_btn = null ,asset('storage/backend/logos/white-logo-662.png') ,"white-logo-662.png" ,$attachment_mime = null); 
        */
        @endif
        @if(array_key_exists('notification',$data) && $data['notification'] == 1)
        
        /**
        *   $data_notification = [
        *       'title' => "New Information ",
        *      'notification' => "{{ $data['model'] }} Created Successfully!",
        *      'link' => "#",
        *      'user_id' => auth()->id(),
        *   ];
        *   pushOnSiteNotification($data_notification); 
        */
        @endif
            return redirect()->route('{{ $data['dotroutepath'].$data['name']}}.index')->with('success','{{ $heading }} Created Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show({{ $data['model'] }} {{ $variable }})
    {
        try{
            return view('{{ $data['dotviewpath'] }}{{ $data['name'] }}.show',compact('{{ substr($variable, 1) }}'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit({{ $data['model'] }} {{ $variable }})
    {   
        try{
            {{-- {{ $variable }} = {{ $data['model'] }}::find($id); --}}
            return view('{{ $data['dotviewpath'] }}{{ $data['name'] }}.edit',compact('{{ substr($variable, 1) }}'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,{{ $data['model'] }} {{ $variable }})
    {
        @if(count($data['validations']['field']) > 0 && $data['validations']['field'][0] != null)

        $this->validate($request, [
            @foreach($data['validations']['field'] as $index => $item)
            '{{ $item }}'     => '{{ $data['validations']['rules'][$index] }}',
            @endforeach
        ]);
        @endif
        
        try{
            @foreach($data['fields']['input'] as $key => $input_type)@if($input_type == "checkbox" || $input_type == "radio")
           
            if(!$request->has('{{ $data['fields']['name'][$key] }}')){
                $request['{{ $data['fields']['name'][$key] }}'] = 0;
            }
            @endif @endforeach
            {{-- {{ $variable }} = {{ $data['model'] }}::find($id); --}}
            if({{ $variable }}){
                @foreach($data['fields']['input'] as $key => $input_type)@if($input_type == "file")

                if($request->hasFile("{{ $data['fields']['name'][$key] }}_file")){
                    $request['{{ $data['fields']['name'][$key] }}'] = $this->uploadFile($request->file("{{ $data['fields']['name'][$key] }}_file"), "{{ $data['name'] }}")->getFilePath();
                    $this->deleteStorageFile({{ $variable }}->{{ $data['fields']['name'][$key] }});
                } else {
                    $request['{{ $data['fields']['name'][$key] }}'] = {{ $variable }}->{{ $data['fields']['name'][$key] }};
                }
                @endif @endforeach
    
                $chk = {{ $variable }}->update($request->all());

                return redirect()->route('{{ $data['dotroutepath'].$data['name']}}.index')->with('success','Record Updated!');
            }
            return back()->with('error','{{ $heading }} not found')->withInput($request->all());
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy({{ $data['model'] }} {{ $variable }})
    {
        try{
            if({{ $variable }}){
                @foreach($data['fields']['input'] as $key => $input_type) @if($input_type == "file")
    
                $this->deleteStorageFile({{ $variable }}->{{ $data['fields']['name'][$key] }});
                @endif @endforeach
                
                {{ $variable }}->delete();
                return back()->with('success','{{ $heading }} deleted successfully');
            }else{
                return back()->with('error','{{ $heading }} not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
