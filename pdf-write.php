<?php
if (!function_exists('add_action')) {
    if(is_file(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/wp-load.php')){
        require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/wp-load.php');
    }else{
        require_once(dirname(dirname(dirname(__FILE__))).'/wp-load.php');
    }
}

global $wpdb;
$wp_to_pdf = get_option('wp_to_pdf');
$authority =  isset($wp_to_pdf['authority']) ? $wp_to_pdf['authority'] : 'all';
if($authority != 'all' && (!is_user_logged_in() || !is_super_admin(get_current_user_id()))){
    wp_die('Access Denied');
}
function utf8_to_unicode( $str ) {

    $unicode = array();
    $values = array();
    $lookingFor = 1;

    for ($i = 0; $i < strlen( $str ); $i++ ) {
        $thisValue = ord( $str[ $i ] );

        if ( $thisValue < 128 ) $unicode[] = $thisValue;
        else {
            if ( count( $values ) == 0 ) $lookingFor = ( $thisValue < 224 ) ? 2 : 3;

            $values[] = $thisValue;

            if ( count( $values ) == $lookingFor ) {

                $number = ( $lookingFor == 3 ) ?
                ( ( $values[0] % 16 ) * 4096 ) + ( ( $values[1] % 64 ) * 64 ) + ( $values[2] % 64 ):
                ( ( $values[0] % 32 ) * 64 ) + ( $values[1] % 64 );

                $unicode[] = $number;
                $values = array();
                $lookingFor = 1;
            }// if
        } // if
    } // for
    return $unicode;
}
global $title;
$post_id = $_GET['post_id'];
$post = get_post($post_id);
$title 	 = $post->post_title;
$html = "<pre>
<style>
p { font-family: UHC;text-align: justify; }
td { font-family: UHC;text-align: justify; }
</style>
<h1 style=\"font-family: UHC\">{$title}</h1>
<p style=\"font-family: UHC\">
{$post->post_content}
</p>
</pre>";
$html = str_replace("<p>", '<p style=\"font-family: UHC\">',$html);

include("../mpdf.php");
require_once(dirname(__FILE__).'/includes/MPDF56/mpdf.php');

$mpdf=new mPDF('+aCJK','A4','','',32,25,27,25,16,13); 
$mpdf->SetDisplayMode('fullpage');

$mpdf->SetTitle($utxt['zh-CN']);
$mpdf->SetAuthor($utxt['zh-CN']);

// LOAD a stylesheet
$stylesheet = file_get_contents(dirname(__FILE__).'/includes/MPDF56/examples/mpdfstyleA4.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html);

$mpdf->Output(iconv('UTF-8','CP949',$title).'.pdf', 'D');


die();
require_once(dirname(__FILE__).'/includes/html2pdf2/html2pdf.class.php');
//require_once(dirname(__FILE__).'/includes/korean.php');
$html2pdf = new HTML2PDF('P','A4','en');
//$html2pdf->pdf->SetDisplayMode('real');
///$html2pdf->pdf->setLanguageArray($l);
///$html2pdf->pdf->SetFont('cid0kr', '', 20);
//$html2pdf->AddUHCFont(); 
//$html2pdf->AddUHCFont("돋움","Dotum");
//$html2pdf->WriteHTML(iconv('UTF-8','CP949',$content));


$html2pdf->pdf->SetCreator(PDF_CREATOR);


//set some language-dependent strings
$html2pdf->pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$html2pdf->pdf->SetFont('cid0kr', '', 20);

// add a page

$txt = '비콘을 직접 개발하려고 한참 연구중이었는데';
//$content = iconv('UTF-8','CP949',$content);

$html2pdf->WriteHTML($content);
$html2pdf->Output(iconv('UTF-8','CP949',$title).'.pdf');
die();
define('FPDF_FONTPATH','font/');
require_once(dirname(__FILE__).'/includes/fpdf/fpdf.php');
require_once(dirname(__FILE__).'/includes/html.php');
require_once(dirname(__FILE__).'/includes/korean.php');

$pdf = new PDF_Korean();
$pdf->AliasNbPages(); //하단 페이징

$pdf->AddUHCFont(); 
$pdf->SetAutoPageBreak(true,15);//컨텐츠가 늘어나면 자동으로 다음 페이지로 넘김

$pdf->Open();
$pdf->AddPage();///페이지 추가

$pdf->AddUHCFont("돋움","Dotum"); //폰트 설정. 다음 폰트 나올때까지 이것 적용됩니다.

$pdf->SetFont('돋움','',14);
//$pdf->Write(5,iconv('UTF-8','EUC-KR',$title));
$pdf->WriteHTML(iconv('UTF-8','CP949',$title));
$pdf->Ln(10);//줄바꿈.
//$pdf->Write(5,iconv('UTF-8','EUC-KR','여기서 줄바꿈. 링크가 없어요~'));

$pdf->Ln(10);//줄바꿈.
$pdf->AddUHCFont("굴림","Gulim"); 
$pdf->SetFontSize(10);
//$content = strip_tags($content);
$pdf->WriteHTML(iconv('UTF-8','CP949',$content));
//$pdf->Text(142,20,iconv('UTF-8','EUC-KR','여기에 이미지를 놓아요, 이미지링크가 있어요.'));
//$pdf->Text(142,25,iconv('UTF-8','EUC-KR','여긴 굴림이고 폰트크기가 9입니다.'));


//$pdf->Ln(10);//줄바꿈.
//$pdf->SetDrawColor(255,201,15);
//$pdf->SetFillColor(255,201,15);
//$pdf->Cell(100,20,iconv('UTF-8','EUC-KR','Fill된 박스안에 글쓰기입니다.링크있음'),1,0,'C',true,'http://naver.com');


$pdf->Output(iconv('UTF-8','CP949',$title).'.pdf', 'D'); // I는 바로 웹페이지 보이고 D는 다운로드.
$pdf->Close();

die();
/*
define('includes/fpdf/font','font/');
require('includes/fpdf/fpdf.php');
$pdf = new FPDF();
//$pdf->AddUHCFont('명조');
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
//$pdf->SetFont('맑은고딕','',16);
$pdf->MultiCell(0,5,$title,0);
$pdf->Ln();
$pdf->MultiCell(0,5,$content,0);
$pdf->Output();
*/



// 폰트의 디렉토리를 설정
// fpdf.php파일에 보면 상수 정의 체크가 있음
// Font path
//  if(defined('FPDF_FONTPATH'))
define('FPDF_FONTPATH', 'includes/fpdf/font/');
// 추가 라이브러리 파일을 호출
require_once('./includes/fpdf/fpdi.php');
require_once('./includes/fpdf/korean.php');
 
// 인스턴스 생성
$pdf = new PDF_Korean();
// 폰트설정
$pdf->AddUHCFont();
// PDF 파일을 오픈합니다.
$pdf->Open();
// 한페이지를 추가
$pdf->AddPage();
// 디폴트 설정한 폰트를 설정 하고 18은 폰트 크기
$pdf->SetFont('UHC','',18);
// 좌표 설정 - 단위는 mm
$pdf->SetXY(50, 50);
// 0은 줄간격,
$pdf->Write(0, 'PDF완성');
// 출력
$pdf->Output();


/*
require('./includes/fpdf/korean.php');

$pdf=new PDF_Korean();
$pdf->AddUHCFont('명조');
$pdf->AddUHCFont('고딕', 'HYGoThic-Medium-Acro');
$pdf->AddUHCFont('돋움', 'Dotum');
$pdf->AddUHCFont('바탕', 'Batang');
$pdf->AddUHCFont('궁서', 'Gungsuh');
$pdf->AddUHCFont('굴림', 'Gulim');
$pdf->AddUHCFont('한겨레결체', '한겨레결체');
$pdf->AddUHCFont('없는글꼴', '없는글꼴');
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('명조','',16);
$pdf->Write(8,'PHP 3.0은 1998년 6월에 공식적으로 릴리즈되었다. 공개적인 테스트 이후약 9개월만이었다.');
$pdf->Ln();
$pdf->SetFont('고딕','',16);
$pdf->Write(8,"(고딕)고딕글꼴도 나타날 수 있었다.");
$pdf->Ln();
$pdf->SetFont('바탕','',16);
$pdf->Write(8,"(바탕)일단 완전히 새로운 폰트가 추가되지는 않아도...");
$pdf->Ln();
$pdf->SetFont('궁서','',16);
$pdf->Write(8,'(궁서)윈도우즈에 있는 기본적인 글꼴은 가능하다.');
$pdf->Ln();
$pdf->SetFont('굴림','',16);
$pdf->Write(8,'(굴림)글꼴들이 조금 달라보이시나요?');
$pdf->Ln();
$pdf->SetFont('돋움','',16);
$pdf->Write(8,'(돋움)이건 돋움체랍니다.');
$pdf->Ln();
$pdf->SetFont('한겨레결체','',16);
$pdf->Write(8,'(한겨레결체)이건 한겨레결체랍니다.');
$pdf->Ln();
$pdf->SetFont('없는글꼴','',16);
$pdf->Write(8,'(없는글꼴)글꼴이 없으면 기본값인 명조체로 나타납니다.');
$pdf->Output();
$pdf->Ln(); $pdf->Ln();
*/

?>