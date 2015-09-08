<?php

/**
 * This is the admin controller class providing navigation and interaction functionality.
 */
class Worship_Controller_Admin extends Zikula_AbstractController
{
    /**
     * @brief Main function.
     * @throws Zikula_Forbidden If not ACCESS_ADMIN
     * @return template Admin/Main.tpl
     * 
     * @author Sascha Rösler
     */
    public function main()
    {
    	$this->throwForbiddenUnless(SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN));
    	
        $Worships = $this->entityManager->getRepository('Worship_Entity_Worships')->findBy(array(),array('wdate'=>'ASC', 'wtime'=>'ASC'));
    	return $this->view
    		->assign('Worships', $Worships)
    		->fetch('Admin/Main.tpl');
    }
    
    /**
     * @brief Worship add function.
     * @throws Zikula_Forbidden If not ACCESS_ADMIN
     * @return redirect self::special_Worship()
     */
    public function worshipadd()
    {
    	//TODO: Time schreiben
    	$this->throwForbiddenUnless(SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN));
    	$action = FormUtil::getPassedValue('action', null, 'POST');
    	switch($action)
    	{
    	case 'add':
      		$time = FormUtil::getPassedValue('intime', null, 'POST');
      		$title = FormUtil::getPassedValue('intitle', 0, 'POST');
      		$church = FormUtil::getPassedValue('inchurch', 0, 'POST');
    		$date = FormUtil::getPassedValue('indate',null,'POST');
			if( $date=="")
				return LogUtil::RegisterError($this->__("The worship has no date to happen."), null, ModUtil::url($this->name, 'admin','main'));
    		if($title == "")
				return LogUtil::RegisterError($this->__("The added worship has no title. Please enter a title for this day, like 'Heilige Messe'."), null, ModUtil::url($this->name, 'admin', 'main'));
			if($time == "")
				return LogUtil::RegisterError($this->__("The added worship has no time to happen."), null, ModUtil::url($this->name, 'admin', 'main'));
			if($church == "")
				return LogUtil::RegisterError($this->__("The added worship has no church to take place."), null, ModUtil::url($this->name, 'admin', 'main'));
			$newWorship = new Worship_Entity_Worships();
			$newWorship->setWtitle($title);
			$newWorship->setWtime($time);
			$newWorship->setcid($church);
			$newWorship->setWdate($date);
			echo($time);
			$this->entityManager->persist($newWorship);
			$this->entityManager->flush();
			LogUtil::RegisterStatus($this->__("Worshiphas been added successfully."));
			break;
		}
    	$this->redirect(ModUtil::url($this->name, 'admin', 'main'));
    }
    
    /**
     * @brief automaticaly Worship add function.
     * @throws Zikula_Forbidden If not ACCESS_ADMIN
     * @return redirect self::main()
     */
    public function generate()
    {
    	//TODO: Time schreiben
    	$this->throwForbiddenUnless(SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN));
    	$fromdate = FormUtil::getPassedValue('fromdate', null, 'POST'); 
		
      	$todate = FormUtil::getPassedValue('todate', 0, 'POST');
      	
      	$option = FormUtil::getPassedValue('option', 0, 'POST');
      	if( $fromdate=="")
			return LogUtil::RegisterError($this->__("Please enter a date for the beginning.."), null, ModUtil::url($this->name, 'admin','main'));
    	if($todate == "")
			return LogUtil::RegisterError($this->__("Please enter a date for the ending."), null, ModUtil::url($this->name, 'admin', 'main'));
		$dateTimestampfrom = strtotime($fromdate);
		$dateTimestampto = strtotime($todate);
		if($dateTimestampto<$dateTimestampfrom)
			return LogUtil::RegisterError($this->__("Please enter valid dates."), null, ModUtil::url($this->name, 'admin', 'main'));
		
		if($option == "")
			return LogUtil::RegisterError($this->__("Please enter a valid option."), null, ModUtil::url($this->name, 'admin', 'main'));
		
		switch($option)
		{
			case "add":
				$GeneralWorships = $this->entityManager->getRepository('Worship_Entity_GeneralWorships')->findBy(array('active'=>1),array('weekday'=>'ASC'));
				$temp = explode(".", $fromdate);
				$fromdate = $temp[2] . "-". $temp[1] . "-". $temp[0];
				$fromdate = new DateTime($fromdate);
			
				$temp = explode(".", $todate);
				$todate = $temp[2] . "-". $temp[1] . "-". $temp[0];
				$todate = new DateTime($todate);
				$date = $fromdate;
				//Ein Tag addieren
				$todate->add(new DateInterval('P1D')); 
		
				while(($todate)!=$date)
				{
					print_r($date);
					echo "<br/>";
					$weekday = $date->format("w");
					echo $weekday;
					$weekdaysWorships = $this->entityManager->getRepository('Worship_Entity_GeneralWorships')->findBy(array('active'=>1, 'weekday'=>$weekday));
					foreach($weekdaysWorships as $weekdaysWorship)
					{
						$newWorship = new Worship_Entity_Worships();
						$newWorship->setWtitle($weekdaysWorship->getGwtitle());
						$mydate = $date->format("d.m.Y");
						$newWorship->setWtime($weekdaysWorship->getGwtimeFormatted());
						$newWorship->setcid($weekdaysWorship->getcid());
						$newWorship->setWdate($mydate);
						$this->entityManager->persist($newWorship);
						$this->entityManager->flush();
						LogUtil::RegisterStatus($this->__("Worshiphas been added successfully."));
					}
					$date->add(new DateInterval('P1D'));
				}
				break;
			
			case "del":
				$Worships = $this->entityManager->getRepository('Worship_Entity_Worships')->findBy(array(),array('wdate'=>'ASC', 'wtime'=>'ASC'));
				foreach($Worships as $Worship)
				{
					if(($Worship->getWdateFormatted()>=($fromdate-1))&&($Worship->getWdateFormatted()<=$todate))
					{
						$actionid = $Worship->getWid();
						$delWorship = $this->entityManager->find('Worship_Entity_Worships', $actionid);
						//del worship
						$this->entityManager->remove($delWorship);
						$this->entityManager->flush();
						LogUtil::RegisterStatus($this->__("Worship has been removed successfully."));
					}
				}
		}
		$this->redirect(ModUtil::url($this->name, 'admin', 'main'));
    }
    
    public function worshipEdit()
    {
    	$actionid = FormUtil::getPassedValue('id',null,'GET');
		if( $actionid=="")
			return LogUtil::RegisterError($this->__("ID is missing."), null, ModUtil::url($this->name, 'admin','main'));
		$form = FormUtil::newForm('Worship', $this);
    	return $form->execute('Admin/WorshipEdit.tpl', new Worship_Handler_WorshipEdit());
		break;
    }
    
    public function worshipDel()
    {
    	$actionid = FormUtil::getPassedValue('id',null,'GET');
    	$all = FormUtil::getPassedValue('all',null,'GET');
		if(($actionid=="")&&($all==""))
			return LogUtil::RegisterError($this->__("ID is missing."), null, ModUtil::url($this->name, 'admin','main'));
		if($actionid)
		{
			$delWorship = $this->entityManager->find('Worship_Entity_Worships', $actionid);
			//del worship
			$this->entityManager->remove($delWorship);
			$this->entityManager->flush();
			LogUtil::RegisterStatus($this->__("Worship has been removed successfully."));
		}
		if($all)
		{
			 $Worships = $this->entityManager->getRepository('Worship_Entity_Worships')->findBy(array(),array('wdate'=>'ASC', 'wtime'=>'ASC'));
			foreach($Worships as $delWorship)
			{
				//del worship
				$this->entityManager->remove($delWorship);
				$this->entityManager->flush();
				LogUtil::RegisterStatus($this->__("Worship has been removed successfully."));
			}
		}
		$this->redirect(ModUtil::url($this->name, 'admin', 'main'));
    }
    
    /**
     * @brief Churches view function.
     * @throws Zikula_Forbidden If not ACCESS_ADMIN
     * @return template Admin/churches.tpl
     *
     * @author Sascha Rösler
     */
    public function churches()
    {
    	$this->throwForbiddenUnless(SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN));
    	
    	$churches = $this->entityManager->getRepository('Worship_Entity_Church')->findBy(array());
    	return $this->view
    		->assign('churches', $churches)
    		->fetch('Admin/churches.tpl');
    }
    
    /**
     * @brief Churche add function.
     * @throws Zikula_Forbidden If not ACCESS_ADMIN
     * @return redirect self::churches()
     */
    public function ChurchAdd()
    {
    	$this->throwForbiddenUnless(SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN));
    	$action = FormUtil::getPassedValue('action', null, 'POST');
    	switch($action)
    	{
    	case 'add':
    		$name = FormUtil::getPassedValue('inname', null, 'POST');
			if($name == "")
				return LogUtil::RegisterError($this->__("The added church has no name."), null, ModUtil::url($this->name, 'admin', 'churches'));
			
			$church = new Worship_Entity_Church();
			$church->setName($name);
			$this->entityManager->persist($church);
			$this->entityManager->flush();
			LogUtil::RegisterStatus($this->__("Church has been added successfully."));
			break;
		}
    	$this->redirect(ModUtil::url($this->name, 'admin', 'churches'));
    } 
    
    public function ChurchEdit()
    {
    	$actionid = FormUtil::getPassedValue('id',null,'GET');
		if( $actionid=="")
			return LogUtil::RegisterError($this->__("ID is missing."), null, ModUtil::url($this->name, 'admin','churches'));
		$form = FormUtil::newForm('Worship', $this);
    	return $form->execute('Admin/ChurchEdit.tpl', new Worship_Handler_Edit());
		break;
    }
    
    public function ChurchDel()
    {
    	$actionid = FormUtil::getPassedValue('id',null,'GET');
			if( $actionid=="")
				return LogUtil::RegisterError($this->__("ID is missing."), null, ModUtil::url($this->name, 'admin','churches'));
			$church = $this->entityManager->find('Worship_Entity_Church', $actionid);
			//Worships for this church deleate:
			//db of all special Worships for this church
			$spe_Worships = $this->entityManager->getRepository('Worship_Entity_Worships')->findBy(array('cid' => $actionid));
			foreach($spe_Worships as $spe_Worship)//for every specialWorship
			{
				//get Worship ID
				$Wid = $spe_Worship->getWid();
				//del Worship
				$Worship = $this->entityManager->find('Worship_Entity_Worships', $Wid);
				$this->entityManager->remove($Worship);
				$this->entityManager->flush();
			}
			//del alle general Worships for this church
			//db of all general Worships for this church
			$dai_Worships = $this->entityManager->getRepository('Worship_Entity_GeneralWorships')->findBy(array(),array('weekday'=>'ASC'));
			foreach($dai_Worships as $dai_Worship)//for every Worship
			{
				//get Worship ID
				$gwid = $dai_Worship->getGwid();
				//del Worship
				$Worship = $this->entityManager->find('Worship_Entity_GeneralWorships', $gwid);
				$this->entityManager->remove($Worship);
				$this->entityManager->flush();
			}
			//del church
			$this->entityManager->remove($church);
			$this->entityManager->flush();
			LogUtil::RegisterStatus($this->__("Church has been removed successfully."));
			$this->redirect(ModUtil::url($this->name, 'admin', 'churches'));
    }
    
    /**************************
    ***						***
    ***  General Worships 	***
    ***=================	***
    ***						***
    **************************/
    
     /**
     * @brief daily view function.
     * @throws Zikula_Forbidden If not ACCESS_ADMIN
     * @return 
     */
    public function generalworships()
    {
    	$this->throwForbiddenUnless(SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN));
    	
    	$GeneralWorships = $this->entityManager->getRepository('Worship_Entity_GeneralWorships')->findBy(array(),array('weekday'=>'ASC'));
    	return $this->view
    		->assign('GeneralWorships', $GeneralWorships)
    		->fetch('Admin/generalworships.tpl');
    }
    
     /**
     * @brief Worship add function.
     * @throws Zikula_Forbidden If not ACCESS_ADMIN
     * @return redirect self::special_Worship()
     */
    public function addgeneralworships()
    {
    	//TODO: Time schreiben
    	$this->throwForbiddenUnless(SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN));
    	$action = FormUtil::getPassedValue('action', null, 'POST');
    	switch($action)
    	{
    	case 'add':
      		$time = FormUtil::getPassedValue('intime', null, 'POST'); 
      		$title = FormUtil::getPassedValue('intitle', 0, 'POST'); 
      		$church = FormUtil::getPassedValue('inchurch', 0, 'POST');
    		$day = FormUtil::getPassedValue('inday',null,'POST');
			if( $day=="")
				return LogUtil::RegisterError($this->__("The worship has no day to happen."), null, ModUtil::url($this->name, 'admin','generalworships'));
    		if($title == "")
				return LogUtil::RegisterError($this->__("The added worship has no title. Please enter a title for this day, like 'Heilige Messe'."), null, ModUtil::url($this->name, 'admin', 'generalworships'));
			if($time == "")
				return LogUtil::RegisterError($this->__("The added worship has no time to happen."), null, ModUtil::url($this->name, 'admin', 'generalworships'));
			if($church == "")
				return LogUtil::RegisterError($this->__("The added worship has no church to take place."), null, ModUtil::url($this->name, 'admin', 'generalworships'));
			$Generalworship = new Worship_Entity_GeneralWorships();
			$Generalworship->setGwtitle($title);
			$Generalworship->setGwtime($time);
			$Generalworship->setcid($church);
			$Generalworship->setWeekday($day);
			$Generalworship->setActive(1);
			echo($time);
			$this->entityManager->persist($Generalworship);
			$this->entityManager->flush();
			LogUtil::RegisterStatus($this->__("Worship has been added successfully."));
			break;
		}
    	$this->redirect(ModUtil::url($this->name, 'admin', 'generalworships'));
    }
    
    public function GeneralworshipEdit()
    {
    	$actionid = FormUtil::getPassedValue('id',null,'GET');
		if( $actionid=="")
			return LogUtil::RegisterError($this->__("ID is missing."), null, ModUtil::url($this->name, 'admin','generalworships'));
		$form = FormUtil::newForm('Worship', $this);
    	return $form->execute('Admin/GernalWorshipEdit.tpl', new Worship_Handler_GeneralworshipEdit());
		break;
    }
    
    public function GeneralworshipDel()
    {
    	$actionid = FormUtil::getPassedValue('id',null,'GET');
		if( $actionid=="")
			return LogUtil::RegisterError($this->__("ID is missing."), null, ModUtil::url($this->name, 'admin','generalworships'));
		$generalworship = $this->entityManager->find('Worship_Entity_GeneralWorships', $actionid);
		//del worship
		$this->entityManager->remove($generalworship);
		$this->entityManager->flush();
		LogUtil::RegisterStatus($this->__("General worship has been removed successfully."));
		$this->redirect(ModUtil::url($this->name, 'admin', 'generalworships'));
    }
    
    
    public function Activechange()
    {
    	$actionid = FormUtil::getPassedValue('id',null,'GET');
    	$state = FormUtil::getPassedValue('state',null,'GET');
    	if( $actionid=="")
			return LogUtil::RegisterError($this->__("ID is missing."), null, ModUtil::url($this->name, 'admin','generalworships'));
		if( $state=="")
			return LogUtil::RegisterError($this->__("State is missing."), null, ModUtil::url($this->name, 'admin','generalworships'));
    	$generalworship = $this->entityManager->find('Worship_Entity_GeneralWorships', $actionid);
    	$generalworship->setActive($state);
    	$this->entityManager->persist($generalworship);
		$this->entityManager->flush();
		LogUtil::RegisterStatus($this->__("State has been changed successfully."));
		$this->redirect(ModUtil::url($this->name, 'admin', 'generalworships'));
    }
    
    /**************************
    ***						***
    ***  General Worships 	***
    ***=================	***
    ***						***
    **************************/
    
     /**
     * @brief daily view function.
     * @throws Zikula_Forbidden If not ACCESS_ADMIN
     * @return 
     */
    public function days()
    {
    	$this->throwForbiddenUnless(SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN));
    	
    	$Days = $this->entityManager->getRepository('Worship_Entity_Day')->findBy(array(),array('ddate'=>'ASC', ));
    	return $this->view
    		->assign('Days', $Days)
    		->fetch('Admin/special_days.tpl');
    }
    
           /**
     * @brief Worship add function.
     * @throws Zikula_Forbidden If not ACCESS_ADMIN
     * @return redirect self::special_Worship()
     */
    public function addday()
    {
    	//TODO: Time schreiben
    	$this->throwForbiddenUnless(SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN));
    	$action = FormUtil::getPassedValue('action', null, 'POST');
    	switch($action)
    	{
    	case 'add':
      		$title = FormUtil::getPassedValue('intitle', 0, 'POST'); 
      		$date = FormUtil::getPassedValue('indate', 0, 'POST');
			if( $date=="")
				return LogUtil::RegisterError($this->__("The worship has no date to happen."), null, ModUtil::url($this->name, 'admin','days'));
    		if($title == "")
				return LogUtil::RegisterError($this->__("The added Day has no title. Please enter a title for this day."), null, ModUtil::url($this->name, 'admin', 'days'));
			$date = $date . "2000";
			$Newday = new Worship_Entity_Day();
			$Newday->setDtitle($title);
			$Newday->setDdate($date);
			$this->entityManager->persist($Newday);
			$this->entityManager->flush();
			LogUtil::RegisterStatus($this->__("The day has been added successfully."));
			break;
		}
    	$this->redirect(ModUtil::url($this->name, 'admin', 'days'));
    }
    
    public function editday()
    {
    	$actionid = FormUtil::getPassedValue('id',null,'GET');
		if( $actionid=="")
			return LogUtil::RegisterError($this->__("ID is missing."), null, ModUtil::url($this->name, 'admin','days'));
		$form = FormUtil::newForm('Worship', $this);
    	return $form->execute('Admin/DayEdit.tpl', new Worship_Handler_DayEdit());
		break;
    }
    
    public function delday()
    {
    	$actionid = FormUtil::getPassedValue('id',null,'GET');
		if( $actionid=="")
			return LogUtil::RegisterError($this->__("ID is missing."), null, ModUtil::url($this->name, 'admin','days'));
		$delday = $this->entityManager->find('Worship_Entity_Day', $actionid);
		//del worship
		$this->entityManager->remove($delday);
		$this->entityManager->flush();
		LogUtil::RegisterStatus($this->__("Day has been removed successfully."));
		$this->redirect(ModUtil::url($this->name, 'admin', 'days'));
    }
    
    public function printpdf()
    {
    	$this->throwForbiddenUnless(SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN));
		
		//get Data
    	$Worships = $this->entityManager->getRepository('Worship_Entity_Worships')->findBy(array(),array('wdate'=>'ASC', 'wtime'=>'ASC'));
    	$churches = $this->entityManager->getRepository('Worship_Entity_Church')->findBy(array());
    	$days = $this->entityManager->getRepository('Worship_Entity_Day')->findBy(array());
    	
    	//work data
    	$dates = array();
    	foreach($Worships as $key =>$Worship)
    	{
    		if($key>0)
    		{
    			if($Worships[$key-1]->getWdateFormattedout()!=$Worship->getWdateFormattedout())
    				$dates[] = array("date"=>$Worship->getWdateFormattedout(),"date_unformat"=>$Worship->getwdate(),"dayname"=>"");
    		}
    		else
    			$dates[] = array("date"=>$Worship->getWdateFormattedout(),"date_unformat"=>$Worship->getwdate(),"dayname"=>"");
		}
		foreach($dates as $key =>$date)
		{
			$temp = $date['date_unformat']->format('d.m.');
			foreach($days as $day)
			{
				$temp2 = $day->getDdateFormatted();
				if($temp == $temp2)
					$dates[$key]["dayname"] = $day->getDtitle();
			}
		}
		
		//create document
    	$tcpdf = PluginUtil::loadPlugin('SystemPlugin_Tcpdf_Plugin');
		//$pdf = $tcpdf->createPdf(L, 'mm', A4, true, 'UTF-8', false);
		$pdf = new Worship_Controller_Pdf(L, 'mm', A4, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(TCPDF);
		$pdf->SetAuthor('Maria, Hilfe der Christen');
		$pdf->SetTitle('Gottesdienste');
		$pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 45, PDF_MARGIN_LEFT);
		$pdf->SetHeaderMargin(PDF_MARGIN_LEFT);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		
		// set default header data
		$heading = "";
		if($Worships)
		{
			$ende = end($Worships);
			if($Worships[0]->getWdate()->format("Y") == $ende->getWdate()->format("Y"))
				$heading= $Worships[0]->getWdateMonthFormattedout()." - ".$ende->getWdateMonthYearFormattedout();
			else
				$heading = $Worships[0]->getWdateMonthYearFormattedout()." - ".$ende->getWdateMonthYearFormattedout();
		}
		
		$pdf->setHeaderFont(array('times', '', 20));
		$pdf->SetHeaderData("GOTTESDIENSTORDNUNG", $heading, "modules/Worship/images/Bildleiste_Userview_links.png", "modules/Worship/images/Bildleiste_Userview_rechts.png");
		$pdf->SetFooterData("www.st-marien-spandau.de", 'themes/Mariengelb/images/Logo.png');
		
		// add a page
		$pdf->AddPage();
		
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0);
		$pdf->SetDrawColor(0, 0, 0);
		$pdf->SetFont('', 'B',14);
		$pdf->setCellPaddings(2,1,2,1);
		
		$cell_width = 0.4;
		
		// Tableheader
		$header = $this->pdfTableHeaderData($churches);
		$headerline = 0;
		foreach($header['names'] as $cell)
		{
			$headerline = max($pdf->getNumLines($cell, 54),$headerline);
		}
		$headerline *= 8;
		$num_headers = count($header['names']);
		for($i = 0; $i < $num_headers; ++$i) {
			if($i != ($num_headers-1))
				$border = array('B' => array('width' => $cell_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
			 else
				$border = array('B' => array('width' => $cell_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
			$pdf->MultiCell( $header['width'][$i], $headerline, $header['names'][$i], $border, "C", 1, 0, '', '', true );
		}
		$pdf->Ln();
        
         $data = $this->pdfTableBodyData($dates, $churches, $Worships);
        
        $linecounter = 0;	//Zählt alle Zeilen für einen Seitenumbruch
        
        foreach($data as $row) {
            //calculate cellheigt
            $linecount = 0;
            foreach($row as $cell)
            {
            	$linecount = max($pdf->getNumLines($cell, 70),$linecount);
            }
            $linecounter += $linecount;
            if($linecounter > 18)
            {
            	$pdf->setPrintFooter(false);
            }
            else
            	$pdf->setPrintFooter(true);
            
            if($linecounter > 20)
            {
            	$pdf->AddPage();
            	$linecounter = 0;
            }
            $linecount *= 6.5;
            $pdf->SetFont('', 'B',12);
            $pdf->MultiCell( $header['width'][0], $linecount, $row[0], array('B' => array('width' => $cell_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0))), "R", 1, 0, '', '', true );
            $pdf->SetFont('', '',12);
            $lastcell = count($header['names']);
            foreach($churches as $key => $church)
            {
            	//create an advanced multicell
            	if($key != ($lastcell-2))
            		$border = array('B' => array('width' => $cell_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
            	else
            		$border = array('B' => array('width' => $cell_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
				$pdf->MultiCell( $header['width'][$key+1], $linecount, $row[$key+1], $border, "L", 1, 0, '', '', true );
            }
            $pdf->Ln();
        }
        
		//Close and output PDF document
		ob_end_clean();
		$pdf->Output('Gottesdienstordnung'.$Worships[0]->getwDate()->format("_Y_m_d").'.pdf', 'I');
		System::shutdown();
		return;
    }
    
    /**
     * @brief Worship add function.
     * @throws Zikula_Forbidden If not ACCESS_ADMIN
     * @return redirect self::special_Worship()
     */
    public function Help()
    {
    	return $this->view
    		->assign('Worships', $Worships)
    		->fetch('Admin/Help.tpl');
    }
    
    private function pdfTableHeaderData($churches)
    {
    	$header = array();
    	$header[0] = '';
    	$w = array();
    	$w[0] = 40;
    	
    	foreach($churches as $church)
    	{
    		$header[] = $church->getName();
    		$w[] = 57;
    	}
    	
    	return array('names'=>$header, 'width' => $w);
    }
    
    private function pdfTableBodyData($dates, $churches, $worships)
    {
    	$data = array();
    	foreach($dates as $key => $date)
    	{
			$data[$key] = array();
			$data[$key][] = $date['date']. "\n".$date['dayname'];
			foreach($churches as $church)
			{
				$tmp = "";
				foreach($worships as $worship)
				{
					if (($worship->getWdateFormattedout()==$date['date'])&&($worship->getCid()==$church->getCid()))
					{
						if($tmp!= "")
							$tmp.="\n";
						$tmp.= $worship->getWtimeFormatted(). "  " .$worship->getWtitle();
					}
				}
				$data[$key][] = $tmp;
			}
		}
		return $data;
    }
}

