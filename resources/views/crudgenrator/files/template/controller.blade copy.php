/**
 * Class {{ $data['model'] }}Controller
 *

 *
 * @ref zCURD
 * @author  GRPL
 * @license 121.page
 * @version <GRPL 1.1.0>
 * @link    https://121.page/
 */
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
    protected $path;
    public function __construct()
    {
        $this->path =   storage_path() . "/app/public/{{ $data['slashviewpath'] }}{{ $data['name'] }}/";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            {{ $indexvariable }} = fetchAll('App\Models\{{ $data['model'] }}');
            return view('{{ $data['dotviewpath'] }}{{ $data['name'] }}.index',compact('{{ substr($indexvariable, 1) }}'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
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
            @foreach($data['fields']['input'] as $key => $input_type)
                @if($input_type == "file")
                    if($request->hasFile('{{ $data['fields']['name'][$key] }}_file')) {
                        $image = $request->file('{{ $data['fields']['name'][$key] }}_file');
                        $path = $this->path;
                        $imageName = 'image_'.rand(00000, 99999).'.' . $image->getClientOriginalExtension();
                        $image->move($path, $imageName);
                        $request['{{ $data['fields']['name'][$key] }}']=$imageName;
                    } else{
                        $request['{{ $data['fields']['name'][$key] }}']= null; 
                    }
                @endif
            @endforeach

            {{ $variable }} = {{ $data['model'] }}::create($request->all());
            return redirect()->route('{{ $data['dotroutepath'].$data['name']}}.index')->with('success','{{ $heading }} Created Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
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
            
            {{-- {{ $variable }} = {{ $data['model'] }}::find($id); --}}
            if({{ $variable }}){
                @foreach($data['fields']['input'] as $key => $input_type)
                    @if($input_type == "file")
                        if($request->hasFile('{{ $data['fields']['name'][$key] }}_file')) {
                            if ({{ $variable }}->{{ $data['fields']['name'][$key] }} != null) {
                                unlinkfile(substr($this->path, 0, -1), {{ $variable }}->{{ $data['fields']['name'][$key] }});
                            }
                            $image = $request->file('{{ $data['fields']['name'][$key] }}_file');
                            $path = $this->path;
                            $imageName = 'image_'.rand(00000, 99999).'.' . $image->getClientOriginalExtension();
                            $image->move($path, $imageName);
                            $request['{{ $data['fields']['name'][$key] }}']=$imageName;
                        } 
                    @endif
                @endforeach
    
                $chk = {{ $variable }}->update($request->all());

                return redirect()->route('{{ $data['dotroutepath'].$data['name']}}.index')->with('success','Record Updated!');
            }
            return back()->with('error','{{ $heading }} not found');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
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
            {{-- {{ $variable }} = {{ $data['model'] }}::find($id); --}}
            if({{ $variable }}){              
                    {{ $variable }}->delete();
                    return back()->with('success', 'Record Deleted!');
            }
            return back()->with('error','{{ $heading }} not found');
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
