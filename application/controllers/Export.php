<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PersonneModel', 'pers');
    }


    // export excel be tay amin'ny amany
    public function export_excel(){
        $datas=$this->pers->get_personne();
		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet

        $sheet = $spreadsheet->getActiveSheet();

        // // manually set table data value
        $sheet->setCellValue('A1', 'rang'); 
        $sheet->setCellValue('B1', 'points'); 
  
        $ligne = 2;
        foreach ($datas as $data){
            $sheet->setCellValue('A'.$ligne, $data->rang); 
            $sheet->setCellValue('B'.$ligne, $data->points); 
  
          
            $ligne++;
        }


        //setColor
        // $sheet->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB("add8e6");
        
        // setGras
        // $sheet->getStyle('A1')->getFont()->setBold(true);


        $writer = new Xls($spreadsheet); // instantiate Xlsx
 
        $filename = 'export-3'; // set filename for excel file to be exported
		
		// var_dump($sheet);
        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="'. $filename .'.xls"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');	// download file 
    }

    // ito indray iwy raha pdf 
    public function export_pdf(){
        $personne_pdf = $this->pers->export_pdf();
        $personne_pdf->output('liste_personne.pdf' , 'D');
    }
}