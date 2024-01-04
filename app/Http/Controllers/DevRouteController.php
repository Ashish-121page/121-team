<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app;
use App\Models\Product;
use App\Models\Proposal;
use App\Models\Proposalenquiry;
use App\Models\Team;
use Illuminate\Support\Facades\Http;
use App\Models\UserShop;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

// Using In Thumbnail Creation
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File as FacadesFile;

class DevRouteController extends Controller
{

    public function jaya() {
        return "Jaya's Function";
    }



    public function jayaform(){
        return view('devloper.jaya.form-check');
    }


    public function ashish(Request $request) {

        //` Uncomment Below Line to Check Available Sessions..
        // magicstring(session()->all());

        echo "Ashish's Function";

         // Create a new Spreadsheet object
         $spreadsheet = new Spreadsheet();

         // First Worksheet for Actual Work
         $actualWorkSheet = $spreadsheet->getActiveSheet();
         $actualWorkSheet->setTitle('Actual Work (Entry) ');

         // Add some sample data to the Actual Work sheet
         $actualWorkSheet->setCellValue('A1', 'Task');
         $actualWorkSheet->setCellValue('B1', 'Status');
         $actualWorkSheet->setCellValue('A2', 'Task 1');
         $actualWorkSheet->setCellValue('B2', ''); // Leave status blank for user input

         // Second Worksheet for Dropdown Values
         $dropdownSheet = $spreadsheet->createSheet();
         $dropdownSheet->setTitle('Dropdown Values (Data)');

         // Sample data for the drop-down list
         $options = [
             'Option 1',
             'Option 2',
             'Option 3',
             'Option 4',
         ];

         $optionsArray = array_map(function($option) {
            return [$option]; // Each option is now an array
        }, $options);




        $dropdownSheet->setCellValue('A1','Dropdown Values');
        // Add the options to the Dropdown Values sheet
        $dropdownSheet->fromArray($optionsArray, null, 'A2');

         // Set data validation for a cell (e.g., A1) in Actual Work sheet
         $validation = $actualWorkSheet->getCell('B2')->getDataValidation();
         $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
         $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
         $validation->setAllowBlank(false);
         $validation->setShowInputMessage(true);
         $validation->setShowErrorMessage(true);
         $validation->setShowDropDown(true);
         $validation->setErrorTitle('Input error');
         $validation->setError('Value is not in the list.');
         $validation->setPromptTitle('Pick from list');
         $validation->setPrompt('Please pick a value from the drop-down list.');
         $validation->setFormula1('\'Dropdown Values\'!$A$1:$A$' . (count($options) + 1));

         // Prepare the response for a downloadable file
         return new StreamedResponse(function () use ($spreadsheet) {
            // Clear the output buffer
            if (ob_get_contents()) ob_end_clean();

            // Write the file to php://output
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment;filename="workbook_with_separate_dropdown_sheet.xlsx"',
            'Cache-Control' => 'max-age=0',
            // Optional: Set the content length if possible
            //'Content-Length' => $fileSize,
        ]);




    }


    public function imagestudio(Request $request){
        return view('devloper.underDev.PhotoStudio');
    }








}
