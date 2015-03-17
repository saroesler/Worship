<?php
class Worship_Controller_Ajax extends Zikula_AbstractController
{
	/**
	 * @brief Set imaging status of one computer
	 * @param GET $cid The number of computer
	 * @param GET $imagingstatus status of imaging
	 *
	 * This function provides a simple soloutin to image much computers fast
	 *
	 * @author Sascha Rösler
	 * @version 1.0
	 */
	/**
	 * @brief Get imaging status of much computers
	 * @param GET $cid The numbers of computer
	 * @return $imagingstatus status of imaging
	 *
	 * This function provides a simple soloution to get the imaging status of much computers
	 *
	 * @author Sascha Rösler
	 * @version 1.0
	 */
	public function Churches_save()
	{
		if (!SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());

		$ok = 0;
		$name = FormUtil::getPassedValue('name', null, 'POST');
		if(!$name)
			$text = ($this->__("There is no valid name!"));
		if($name)
		{
			$church = new Worship_Entity_Church();
			$church->setName($name);
			$this->entityManager->persist($church);
			$this->entityManager->flush();
			LogUtil::RegisterStatus($this->__("News has been added successfully."));
			$ok = 1;
			$text = "";
		}
		
		$result['ok'] = $ok;
		$result['text'] = $text;
		
		$churches = $this->entityManager->getRepository('Worship_Entity_Church')->findBy(array());
    	$result['list'] = $this->view
    		->assign('churches', $churches)
    		->fetch('Ajax/churches.tpl');
    		
		return new Zikula_Response_Ajax($result);
	}
	
	public function Churches_Del()
	{
		if (!SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());

		$result['ok'] = 0;
		$id = FormUtil::getPassedValue('id', null, 'POST');
		if(!isset($id)) {
			return new Zikula_Response_Ajax_BadData($this->__('missing $id'));
		}
		if($id)
		{
			$church = $this->entityManager->find('Worship_Entity_Church', $id);
			//Worships for this church deleate:
			//db of all special Worships for this church
			$spe_Worships = $this->entityManager->getRepository('Worship_Entity_Worships')->findBy(array('cid' => $id));
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
		}
		
		$result['id'] = $id;
		return new Zikula_Response_Ajax($result);
	}
	
	public function GeneralWorships_save()
	{
		if (!SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());

		$ok = 0;
		$text = "";
		$day = FormUtil::getPassedValue('day', null, 'POST');
		$time = FormUtil::getPassedValue('time', null, 'POST');
		$title = FormUtil::getPassedValue('title', null, 'POST');
		$church = FormUtil::getPassedValue('church', null, 'POST');
		if($day>7)
			$text = ($this->__("There is no valid date!"));
		if(!$time)
			$text = ($this->__("There is no valid time!"));
		if(!$title)
			$text = ($this->__("There is no valid title!"));
		if(!$church)
			$text = ($this->__("There is no valid church!"));
		if($time&&$title&&$church)
		{
			$Generalworship = new Worship_Entity_GeneralWorships();
			$Generalworship->setGwtitle($title);
			$Generalworship->setGwtime($time);
			$Generalworship->setcid($church);
			$Generalworship->setWeekday($day);
			$Generalworship->setActive(1);
			$this->entityManager->persist($Generalworship);
			$this->entityManager->flush();
			LogUtil::RegisterStatus($this->__("Worship has been added successfully."));
			$ok = 1;
			$text = "";
		}
		
		$result['ok'] = $ok;
		$result['text'] = $text;
		
		$GeneralWorships = $this->entityManager->getRepository('Worship_Entity_GeneralWorships')->findBy(array(),array('weekday'=>'ASC'));
    	$result['list'] = $this->view
    		->assign('GeneralWorships', $GeneralWorships)
    		->fetch('Ajax/generalworships.tpl');
    	
		return new Zikula_Response_Ajax($result);
	}
	
	public function GeneralWorships_Del()
	{
		if (!SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());

		$result['ok'] = 0;
		$id = FormUtil::getPassedValue('id', null, 'POST');
		if(!isset($id)) {
			return new Zikula_Response_Ajax_BadData($this->__('missing $id'));
		}
		if($id)
		{
			$generalworship = $this->entityManager->find('Worship_Entity_GeneralWorships', $id);
			//del worship
			$this->entityManager->remove($generalworship);
			$this->entityManager->flush();
			LogUtil::RegisterStatus($this->__("General worship has been removed successfully."));
		}
		
		$result['id'] = $id;
		return new Zikula_Response_Ajax($result);
	}
	
	public function GeneralWorships_State()
	{
		if (!SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());

		$result['ok'] = 0;
		$id = FormUtil::getPassedValue('id', null, 'POST');
		$state = FormUtil::getPassedValue('state', null, 'POST');
		if(!isset($id)) {
			return new Zikula_Response_Ajax_BadData($this->__('missing $id'));
		}
		if(!isset($state)) {
			return new Zikula_Response_Ajax_BadData($this->__('missing $state'));
		}
		if($id)
		{
			$generalworship = $this->entityManager->find('Worship_Entity_GeneralWorships', $id);
			$generalworship->setActive($state);
			$this->entityManager->persist($generalworship);
			$this->entityManager->flush();
			LogUtil::RegisterStatus($this->__("State has been changed successfully."));
		}
		
		$result['id'] = $id;
		$result['state'] = $state;
		return new Zikula_Response_Ajax($result);
	}
	
	public function Days_save()
	{
		if (!SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());

		$ok = 0;
		$title = FormUtil::getPassedValue('title', null, 'POST');
		$date = FormUtil::getPassedValue('date', null, 'POST');
		if(!$title)
			$text = ($this->__("There is no valid title!"));
		if(!$date)
			$text = ($this->__("There is no valid date!"));
		if($title&&$date)
		{
			$date = $date . "2000";
			$Newday = new Worship_Entity_Day();
			$Newday->setDtitle($title);
			$Newday->setDdate($date);
			$this->entityManager->persist($Newday);
			$this->entityManager->flush();
			LogUtil::RegisterStatus($this->__("The day has been added successfully."));
			$ok = 1;
			$text = "";
		}
		
		$result['ok'] = $ok;
		$result['text'] = $text;
		
		$Days = $this->entityManager->getRepository('Worship_Entity_Day')->findBy(array(),array('ddate'=>'ASC', ));
    	$result['list'] = $this->view
    		->assign('Days', $Days)
    		->fetch('Ajax/special_days.tpl');
    		
		return new Zikula_Response_Ajax($result);
	}
	
	public function Days_Del()
	{
		if (!SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());

		$result['ok'] = 0;
		$id = FormUtil::getPassedValue('id', null, 'POST');
		if(!isset($id)) {
			return new Zikula_Response_Ajax_BadData($this->__('missing $id'));
		}
		if($id)
		{
			$delday = $this->entityManager->find('Worship_Entity_Day', $id);
			//del worship
			$this->entityManager->remove($delday);
			$this->entityManager->flush();
			LogUtil::RegisterStatus($this->__("Day has been removed successfully."));
		}
		
		$result['id'] = $id;
		return new Zikula_Response_Ajax($result);
	}
	
	public function Worships_save()
	{
		if (!SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());

		$ok = 0;
		$text = "";
		$date = FormUtil::getPassedValue('date', null, 'POST');
		$time = FormUtil::getPassedValue('time', null, 'POST');
		$title = FormUtil::getPassedValue('title', null, 'POST');
		$church = FormUtil::getPassedValue('church', null, 'POST');
		if(!$date)
			$text = ($this->__("There is no valid date!"));
		if(!$time)
			$text = ($this->__("There is no valid time!"));
		if(!$title)
			$text = ($this->__("There is no valid title!"));
		if(!$church)
			$text = ($this->__("There is no valid church!"));
		if($time&&$title&&$church&&$date)
		{
			$newWorship = new Worship_Entity_Worships();
			$newWorship->setWtitle($title);
			$newWorship->setWtime($time);
			$newWorship->setcid($church);
			$newWorship->setWdate($date);
			$this->entityManager->persist($newWorship);
			$this->entityManager->flush();
			LogUtil::RegisterStatus($this->__("Worship has been added successfully."));
			$ok = 1;
			$text = "";
		}
		
		$result['ok'] = $ok;
		$result['text'] = $text;
		$result['date'] = $date;
		
		$Worships = $this->entityManager->getRepository('Worship_Entity_Worships')->findBy(array(),array('wdate'=>'ASC', 'wtime'=>'ASC'));
    	$result['list'] = $this->view
    		->assign('Worships', $Worships)
    		->fetch('Ajax/Main.tpl');
    	
		return new Zikula_Response_Ajax($result);
	}
	
	public function Worships_Del()
	{
		if (!SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());

		$result['ok'] = 0;
		$id = FormUtil::getPassedValue('id', null, 'POST');
		if(!isset($id)) {
			return new Zikula_Response_Ajax_BadData($this->__('missing $id'));
		}
		if($id)
		{
			$delWorship = $this->entityManager->find('Worship_Entity_Worships', $id);
			//del worship
			$this->entityManager->remove($delWorship);
			$this->entityManager->flush();
			LogUtil::RegisterStatus($this->__("Worship has been removed successfully."));
		}
		
		$result['id'] = $id;
		return new Zikula_Response_Ajax($result);
	}
	
}
