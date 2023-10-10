<?php 
/**
 *

 *
 * @ref zCURD
 * @author  GRPL
 * @license 121.page
 * @version <GRPL 1.1.0>
 * @link    https://121.page/
 */

namespace App\Http\Controllers\CrudGenrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CrudGenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $files = \File::files(base_path().'/app/Models/');
       $tmpFiles = [];
       foreach ($files as $file){
           $file =  pathinfo($file);
           $tmpFiles[] = $file;
        //    echo $file['filename'] . '<br>';
       }
    //    dd($tmpFiles);
    //    return;
    //    return dd($files);
        return view('crudgenrator.index',compact('tmpFiles'));
    }
    public function bulkImport()
    {
       $files = \File::files(base_path().'/app/Models/');
       $tmpFiles = [];
       foreach ($files as $file){
           $file =  pathinfo($file);
           $tmpFiles[] = $file;
        //    echo $file['filename'] . '<br>';
       }
    //    dd($tmpFiles);
    //    return;
    //    return dd($files);
        return view('crudgenrator.bulk_import',compact('tmpFiles'));
    }

    protected function getDatePrefix()
    {
        return date('Y_m_d_His');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        // return dd($request->all());
        // return back()->with('error',"Test")->withInput($request->all());
        try{
            $data = $request->all();
            if($data['controller_namespace'] != null){
                $data['controller_namespace'] = $data['controller_namespace'];
            }else{
                $data['controller_namespace'] = 'Panel';
            }
            if($data['view_path_'] != null){
                $data['dotviewpath'] = str_replace('/','.',$data['view_path_']).'.';
                $data['slashviewpath'] = $data['view_path_'].'/';
            }else{
                $data['dotviewpath'] = 'panel.';
                $data['slashviewpath'] = 'panel/';
            }
           
            if(fileExists(fileExists(base_path().'/app/Http/Controllers/'.$data['controller_namespace'].'/'.$data['model'].'Controller.php'))){  
                return back()->with('error',"Controller Already Exists!")->withInput($request->all());
            }
            if(fileExists(base_path().'/app/Models'.'/'.$data['model'].'.php')){  
                return back()->with('error',"Model Already Exists!")->withInput($request->all());
            }
            if(fileExists(base_path()."/resources/views/".$data['slashviewpath'].$data['name'].'/index.blade.php')||fileExists(base_path()."/resources/views/".$data['slashviewpath'].$data['name'].'/create.blade.php')||fileExists(base_path()."/resources/views/".$data['slashviewpath'].$data['name'].'/edit.blade.php')){  
                return back()->with('error',"Views Already Exists!")->withInput($request->all());
            }
            

            $data['wildcard'] = "?";
            $data['atsign'] = "@";
            $data['script'] = "script";
            $data['curlstart'] = "{{";
            $variable = '$'.\Str::singular($data['name']);
            $indexvariable = '$'.$data['name'];
            $heading = \Str::singular(ucwords(str_replace('_',' ',$data['name'])));
            $indexheading = ucwords(str_replace('_',' ',$data['name']));
            $data['dotroutepath'] = 'panel.';
            $data['slashroutepath'] = 'panel/';
            
            // Controller
            $controller_data = view('crudgenrator.files.template.controller', compact('data','indexvariable','variable','heading'))->render();
            $file = $data['model'].'Controller.php';
            // $destinationPath = storage_path()."/app/crud_output/controller/";
            if($data['controller_namespace'] != null){
                $destinationPath = base_path().'/app/Http/Controllers/'.$data['controller_namespace'].'/';
            }else{
                $destinationPath = base_path().'/app/Http/Controllers/';
            }
            if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
            \File::put($destinationPath.$file,$controller_data);
            // return response()->download($destinationPath.$file);
        
            // View Create
            $create_data = view('crudgenrator.files.template.view.create', compact('data','heading'));
            $file = 'create.blade.php';
            // $destinationPath = storage_path()."/app/crud_output/view/".$data['name'].'/';
            if($data['view_path_'] != null){
                $destinationPath = base_path()."/resources/views/".$data['slashviewpath'].$data['name'].'/';
            }else{
                $destinationPath = base_path()."/resources/views/panel/".$data['name'].'/';
            }
            if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
            \File::put($destinationPath.$file,$create_data);
            // return response()->download($destinationPath.$file);
        
            // View - Edit
            $edit_data = view('crudgenrator.files.template.view.edit', compact('data','heading','variable'));
            $file = 'edit.blade.php';
            // $destinationPath = storage_path()."/app/crud_output/view/".$data['name'].'/';
            if($data['view_path_'] != null){
                $destinationPath = base_path()."/resources/views/".$data['slashviewpath'].$data['name'].'/';
            }else{
                $destinationPath = base_path()."/resources/views/panel/".$data['name'].'/';
            }
            if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
            \File::put($destinationPath.$file,$edit_data);
            // return response()->download($destinationPath.$file);

            // View - Index
            $index_data = view('crudgenrator.files.template.view.index', compact('data','indexheading','heading','variable','indexvariable'));
            $file = 'index.blade.php';
            // $destinationPath = storage_path()."/app/crud_output/view/".$data['name'].'/';
            if($data['view_path_'] != null){
                $destinationPath = base_path()."/resources/views/".$data['slashviewpath'].$data['name'].'/';
            }else{
                $destinationPath = base_path()."/resources/views/panel/".$data['name'].'/';
            }
            if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
            \File::put($destinationPath.$file,$index_data);
            // return response()->download($destinationPath.$file);

            // View - Print
            $print_data = view('crudgenrator.files.template.view.print', compact('data','indexheading','heading','variable','indexvariable'));
            $file = 'print.blade.php';
            // $destinationPath = storage_path()."/app/crud_output/view/".$data['name'].'/';
            if($data['view_path_'] != null){
                $destinationPath = base_path()."/resources/views/".$data['slashviewpath'].$data['name'].'/';
            }else{
                $destinationPath = base_path()."/resources/views/panel/".$data['name'].'/';
            }
            if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
            \File::put($destinationPath.$file,$print_data);
            // return response()->download($destinationPath.$file);
            
            // View - Load
            $load_data = view('crudgenrator.files.template.view.load', compact('data','indexheading','heading','variable','indexvariable'));
            $file = 'load.blade.php';
            // $destinationPath = storage_path()."/app/crud_output/view/".$data['name'].'/';
            if($data['view_path_'] != null){
                $destinationPath = base_path()."/resources/views/".$data['slashviewpath'].$data['name'].'/';
            }else{
                $destinationPath = base_path()."/resources/views/panel/".$data['name'].'/';
            }
            if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
            \File::put($destinationPath.$file,$load_data);
            // return response()->download($destinationPath.$file);

            // return dd($data);
            //Migration
            
            $chk = str_replace('_',' ',$data['name']);
            $t = ucWords($chk);
            $migration_name = str_replace(' ','',$t);
            $migration_data = view('crudgenrator.files.template.migration', compact('data','migration_name'));
            $file = $this->getDatePrefix().'_create_'.$data['name'].'_table.php';
            // $destinationPath = storage_path()."/app/crud_output/migration/";
            $destinationPath = base_path()."/database/migrations/";

            if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
            \File::put($destinationPath.$file,$migration_data);
            // return response()->download($destinationPath.$file);

            //Model
            $model_data = view('crudgenrator.files.template.model', compact('data'));
            $file = $data['model'].'.php';
            // $destinationPath = storage_path()."/app/crud_output/model/";
            $destinationPath = base_path()."/app/Models/";
            if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
            \File::put($destinationPath.$file,$model_data);
            // return response()->download($destinationPath.$file);

            //Routes
            $prefix = $data['slashroutepath'].str_replace("_","-",$data['name']);
            $as = $data['dotroutepath'].$data['name'];
            $model_data = view('crudgenrator.files.template.routes', compact('data','prefix','as','variable'));
            $file = 'crudgen.php';
            // $destinationPath = storage_path()."/app/crud_output/routes/";
            $destinationPath = base_path()."/routes/";
            if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
            \File::append($destinationPath.$file,$model_data);
            // return response()->download($destinationPath.$file);
            
            //Sidebar Code
            $segment = str_replace("_","-",$data['name']);
            $as = $data['dotroutepath'].$data['name'];
            $sidenav_data = view('crudgenrator.files.template.view.crud_sidebar', compact('data','segment','as','heading'));
            $file = 'crud_sidebar.blade.php';
            // $destinationPath = storage_path()."/app/crud_output/view/".$data['name'].'/';
            $destinationPath = base_path()."/resources/views/backend/include/partial/";
            if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
            \File::append($destinationPath.$file,$sidenav_data);
            // return response()->download($destinationPath.$file);

            \Artisan::call('migrate');

            if($request->api == 1){
                // Api Controller
                $controller_data = view('crudgenrator.files.template.apicontroller', compact('data','indexvariable','variable','heading'))->render();
                $file = $data['model'].'Controller.php';
                // $destinationPath = storage_path()."/app/crud_output/controller/";
                if($data['controller_namespace'] != null){
                    $destinationPath = base_path().'/app/Http/Controllers/Api/';
                }else{
                    $destinationPath = base_path().'/app/Http/Controllers/Api/';
                }
                if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
                \File::put($destinationPath.$file,$controller_data);
                // return response()->download($destinationPath.$file);
                 //Api Routes
                $prefix = str_replace("_","-",$data['name']);
                $as = $data['name'];
                $model_data = view('crudgenrator.files.template.apiroutes', compact('data','prefix','as','variable'));
                $file = 'api.php';
                // $destinationPath = storage_path()."/app/crud_output/routes/";
                $destinationPath = base_path()."/routes/";
                if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
                \File::append($destinationPath.$file,$model_data);
                // return response()->download($destinationPath.$file);
            }
        }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
        }
        return  back()->with('success',"CRUD Generated Successfully!")->withInput($request->all());
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getColumns(Request $request)
    {
        // return $request->all();
        $hide = ['id','created_at','updated_at','deleted_at'];
        $cols = [];
        $html = '<label for="" class="mr-5">Parent Id</label> <label for="">Sequence</label>
        <label for="" class="ml-5">Columns</label><br>';
        if($request->model == "User"){
            $cols = collect(\App\User::first())->keys()->toArray();
        }else{
            $model = "\App\Models\\".$request->model;
            $cols = collect($model::first())->keys()->toArray();
        }

        $cols = array_diff($cols, $hide);
        if(count($cols) > 0){
            $i =1;
            foreach($cols as $index => $col){
                $html .= '<label for="f'.$index.'" class="mr-5">
                            <input type="radio" name="foregin_col" value="'.$col.'" id="f'.$index.'"> 
                            </label> 
                            <input type="number mr-5" class="input" name="sequence['.$col.']" value="'.$i.'" style="width: 120px;">
                            <label for="'.$index.'" class="ml-5 mr-5">
                            <input type="checkbox" name="'.$col.'" checked value="'.$col.'" id="'.$index.'">
                            '.$col.' 
                            </label>
                            <br>';
                            ++$i;
            }
        }
        return response(['html'=>$html],200);  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulkImportGenerate(Request $request)
    {
        return dd($request->all());
        // return "s";
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = [];
    foreach ($worksheet->getRowIterator() AS $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
        $cells = [];
        foreach ($cellIterator as $cell) {
            $cells[] = $cell->getValue();
        }
        $rows[] = $cells;
    }
        $head = array_shift($rows);
        $master = $rows;
    return dd($master);
        // Index
        $UniversityIndex = 0;
        $CourseIndex = 1;
        $ProgramIndex = 2;
        $BranchIndex = 3;
        $SubjectIndex = 4;
        $ChapterIndex = 5;
        $TopicIndex = 6;
        
        // Data Tree
        $UniversityObj = null;
        $CourseObj = null;
        $ProgramObj = null;
        $BranchObj = null;
        $SubjectObj = null;
        $ChapterObj = null;
        $TopicObj = null;
        
        $CourseArr = [];
        $ChapterArr = [];
        $TopicArr = [];
        $ChapterSequence = 1;
        $CourseArr = [];
        $master_obj = collect($master);
        
        foreach($master as $index => $item){
            $index = ++$index;
            // return $item[$UniversityIndex];
            // University
            if($item[$UniversityIndex] != null){
                $UniversityObj = University::create([
                    'name' => $item[$UniversityIndex],
                    'semester_type' => $request->semester_type,
                    'courses' => null,
                ]);
            }
        }

        // return "DONE";



        $count = $index*6;
        return back()->with('success', 'Good News! '.$count.' records created successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
