<?php 
include 'config.php';
include(__DIR__.'/../../controller/validate_token.php');
require(__DIR__.'/../../assets/tcpdf/tcpdf.php');
include(__DIR__.'/../../model/resumeModel.php');
$data = items($_GET['id'] ?? $user->id);
if(isset($_SESSION['success'])){unset($_SESSION['success']);}
//die($_GET['id']);
//$data = items(6);

/*echo '<pre>';
print_r($data);
echo '<pre>';
die();*/
if(!empty($data)){
    
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetMargins(17, 10, 17);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    $pdf->AddPage();

    if(!empty($data->contact_details)){$pdf->writeHTMLCell(0, 0, '', '', $data->contact_details, 0, 1, 0, true, '', true);}
    if(!empty($data->linkedIn_qr)&&!empty($data->image_size)){
        $imagePath = $data->linkedIn_qr;
        list($width, $height) = getimagesize($imagePath);
        $dpi = $data->image_size;
        $imageX = 170;
        $imageY = 10;
        $imageWidth = 0;

        $imageHeight = ($height / $dpi) * 12;

        $pdf->Image($imagePath, $imageX, $imageY, $imageWidth, $imageHeight, '', '', '', false, $dpi, '', false, false, 0, false, false, false);

        $textY = $imageY + $imageHeight + 2;
        $pdf->SetXY(17, $textY);
        $title = '<div style="text-align: right; font-size: 8px; padding:0; margin:0; color: #6c757d">LinkedIn QR Code</div>';
        $pdf->writeHTML($title, true, false, true, false, 'R');
        $pdf->Ln(2);
    }

    if(!empty($data->summary)){$pdf->writeHTMLCell(0, 0, '', '', $data->summary, 0, 1, 0, true, '', true);$pdf->Ln(4);}
    //if(!empty($data->education)){$pdf->writeHTMLCell(0, 0, '', '', $data->education->info, 0, 1, 0, true, '', true);$pdf->Ln(-20);}
    if(!empty($data->education)){
        if(!empty($data->education)){
            foreach($data->education as $education){
                $pdf->writeHTMLCell(0, 0, '', '', $education, 0, 1, 0, true, '', true);
                $pdf->Ln(4);   
            }
        }
    }
    if(!empty($data->work_experience)){
        if(!empty($data->work_experience)){
            foreach($data->work_experience as $work_experience){
                $pdf->writeHTMLCell(0, 0, '', '', $work_experience, 0, 1, 0, true, '', true);
                $pdf->Ln(4);   
            }
        }
    }
    if(!empty($data->curriculum)){
        if(!empty($data->curriculum)){
            foreach($data->curriculum as $curriculum){
                $pdf->writeHTMLCell(0, 0, '', '', $curriculum, 0, 1, 0, true, '', true);
                $pdf->Ln(4);   
            }
        }
    }
    if(!empty($data->skillset)){$pdf->writeHTMLCell(0, 0, '', '', $data->skillset, 0, 1, 0, true, '', true);$pdf->Ln(4);}
    if(!empty($data->reference)){$pdf->writeHTMLCell(0, 0, '', '', $data->reference, 0, 1, 0, true, '', true);$pdf->Ln(4);}

    $pdf->Output('Resume.pdf', 'I');
}else{
    $_SESSION['error'] = "Cannot retrieve resume. Please setup your resume.";
    header("Location: ".BASE_URL."resume-setup");
    exit();
}
?>