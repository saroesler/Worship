<?php

/**
 * This is the admin controller class providing navigation and interaction functionality.
 */
// Include the main TCPDF library (search for installation path).
require_once('plugins/Tcpdf/lib/vendor/tcpdf/tcpdf.php');
 
class Worship_Controller_Pdf extends TCPDF
{
	private $mainheader;
	private $subheader;
	private $url;
	private $imagel;
	private $imager;
	private $logo;
	
	//Page header
    public function Header() {
        // Logo
        $this->Image($this->imagel, PDF_MARGIN_LEFT, PDF_MARGIN_LEFT, 75, 25, '', '', '', false, 300, '', false, false, 0);
        $this->Image($this->imager, 208, PDF_MARGIN_LEFT, 75, 25, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status25
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
        
        $this->SetFillColor(0, 0, 255);
		$this->SetTextColor(0);
		$this->SetDrawColor(0, 0, 0);
        /*$image_file = K_PATH_IMAGES.'logo_example.jpg';
        $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);*/
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        
        // Title
        $this->Cell(0, 15,'', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 15, $this->mainheader, 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 15, $this->subheader, 0, 1, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->write2DBarcode($this->url, 'QRCODE,M', 262, 180, 20, 20, $style, 'N');
		$this->Image($this->logo, PDF_MARGIN_LEFT, 180, 20, 20, '', '', '', false, 300, '', false, false, 0);
    }
    
    public function SetHeaderData($mymainheader, $mysubheader, $imagel, $imager){
    	$this->mainheader = $mymainheader;
    	$this->subheader = $mysubheader;
    	$this->imagel = $imagel;
    	$this->imager = $imager;
    }
    public function SetFooterData($myurl, $logo){
    	$this->url = $myurl;
    	$this->logo = $logo;
    }
}
