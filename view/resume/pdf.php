<?php 
include(__DIR__.'/../../controller/validate_token.php');
require(__DIR__.'/../../assets/fpdf/fpdf.php');
include(__DIR__.'/../../model/resumeModel.php');
$data = items($user->id);

/*echo '<pre>';
print_r($data);
echo '<pre>';*/
?>

<?php 
class PDF extends FPDF
{
    protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';

    function WriteHTML($html)
    {
        // HTML parser
        $html = str_replace("\n",' ',$html);
        $html = str_replace('&nbsp;', ' ', $html);
        //$html = str_replace('&nbsp;', ' ', $html);
        $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                // Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                else
                    $this->Write(5,$e);
            }
            else
            {
                // Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    // Extract attributes
                    $a2 = explode(' ',$e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag,$attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr)
    {
        // Opening tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF = $attr['HREF'];
        if($tag=='BR')
            $this->Ln(5);
    }

    function CloseTag($tag)
    {
        // Closing tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF = '';
    }

    function SetStyle($tag, $enable)
    {
        // Modify style and select corresponding font
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach(array('B', 'I', 'U') as $s)
        {
            if($this->$s>0)
                $style .= $s;
        }
        $this->SetFont('',$style);
    }

    function PutLink($URL, $txt)
    {
        // Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }
}

$html = 'You can now easily print text mixing different styles: <b>bold</b>, <i>italic</i>,
<u>underlined</u>, or <b><i><u>all at once</u></i></b>!<br><br>You can also insert links on
text, such as <a href="http://www.fpdf.org">www.fpdf.org</a>, or on an image: click on the logo.';

$pdf = new PDF();
// First page
$pdf->AddPage();
$pdf->SetFont('Arial','',20);
$link = $pdf->AddLink();
$pdf->WriteHTML($html);
$pdf->SetFont('');
// Second page
$pdf->AddPage();
$pdf->SetLink($link);
$pdf->Image('images/example_1.png',10,12,30,0,'');
$pdf->SetLeftMargin(45);
$pdf->SetFontSize(14);
$pdf->WriteHTML($data->summary);
$pdf->Output();

/*class PDF extends FPDF {
    // Page header
    function Header() {
        // Set font
        $this->SetFont('Arial', 'B', 14);
        // Title
        $this->Cell(0, 10, 'Resume', 0, 1, 'C');
        $this->Ln(10);
    }

    // Page footer
    function Footer() {
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    // Basic details
    function BasicDetails($name, $address, $email, $contact) {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, $name, 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, "Address: $address", 0, 1, 'L');
        $this->Cell(0, 10, "Email: $email", 0, 1, 'L');
        $this->Cell(0, 10, "Contact: $contact", 0, 1, 'L');
        $this->Ln(5);
    }

    // Summary section
    function Summary($text) {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'SUMMARY', 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, $text, 0, 'L');
        $this->Ln(5);
    }

    // Education section
    function Education($title, $details) {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, $title, 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        foreach ($details as $detail) {
            $this->MultiCell(0, 10, $detail, 0, 'L');
            $this->Ln(3);
        }
        $this->Ln(5);
    }

    // Work Experience section
    function WorkExperience($experiences) {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'WORK EXPERIENCE', 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        foreach ($experiences as $experience) {
            $this->MultiCell(0, 10, $experience, 0, 'L');
            $this->Ln(3);
        }
        $this->Ln(5);
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Basic Details
$pdf->BasicDetails('Muhamad Khairul Amin Bin Abd Hamid', 'Teluk Intan, Perak', 'khairulamin.abdhmid@gmail.com', '017-319 1936');

// Summary
$summaryText = "Proficient in HTML, CSS, JavaScript, PHP, Bootstrap 5, Joomla, Laravel, and Java...";
$pdf->Summary($summaryText);

// Education
$educationDetails = [
    "Bachelor of Computer Science (HONS)\nApril 2021 – Nov 2023\nGrade: 3.66 (CGPA), Dean’s list for 6 semesters...",
    "Diploma in Computer Science\nJuly 2017 – Dec 2019\nGrade: 3.06 (CGPA)..."
];
$pdf->Education('EDUCATION', $educationDetails);

// Work Experience
$workExperienceDetails = [
    "Web Developer - Frontdesk Sdn Bhd\nJan 2024 – July 2024\nStripe Payment Integration, Data Visualization...",
    "Internship Web Developer\nAug 2023 – Nov 2023..."
];
$pdf->WorkExperience($workExperienceDetails);

$pdf->Output();*/


?>