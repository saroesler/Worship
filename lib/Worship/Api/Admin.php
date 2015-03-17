<?php
/**
 * This is the User controller class providing navigation and interaction functionality.
 */
class Worship_Api_Admin extends Zikula_AbstractApi
{
	/**
	 * @brief Get available admin panel links
	 *
	 * @return array array of admin links
	 */
	public function getlinks()
	{
		$links = array();
		if (SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN)) {
			$links[] = array(
				'url'=> ModUtil::url('Worship', 'admin', 'main'),
				'text'  => $this->__('Main'),
				'title' => $this->__('Main'),
				'class' => 'z-icon-es-config',
			);
		}
		
		if (SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN)) {
			$links[] = array(
				'url'=> ModUtil::url('Worship', 'admin', 'generalworships'),
				'text'  => $this->__('General Worships'),
				'title' => $this->__('manage and create weekly Worships'),
				'class' => 'z-icon-es-display',
			);
		}
		
		if (SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN)) {
			$links[] = array(
				'url'=> ModUtil::url('Worship', 'admin', 'churches'),
				'text'  => $this->__('Churches'),
				'title' => $this->__('manage and create churches'),
				'class' => 'z-icon-es-display',
			);
		}
		
		if (SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN)) {
			$links[] = array(
				'url'=> ModUtil::url('Worship', 'admin', 'days'),
				'text'  => $this->__('Special Days'),
				'title' => $this->__('manage and create special Days'),
				'class' => 'z-icon-es-display',
			);
		}
		
		if (SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN)) {
			$links[] = array(
				'url'=> ModUtil::url('Worship', 'user', 'view'),
				'text'  => $this->__('View'),
				'title' => $this->__('show the view'),
				'class' => 'z-icon-es-display',
			);
		}
		
		if (SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN)) {
			$links[] = array(
				'url'=> ModUtil::url('Worship', 'admin', 'printpdf'),
				'text'  => $this->__('Print'),
				'title' => $this->__('Here is the view for printing'),
				'class' => 'z-icon-es-print',
			);
		}
		
		if (SecurityUtil::checkPermission('Worship::', '::', ACCESS_ADMIN)) {
			$links[] = array(
				'url'=> ModUtil::url('Worship', 'admin', 'Help'),
				'text'  => $this->__('Help'),
				'title' => $this->__('Here you can get help.'),
				'class' => 'z-icon-es-help',
			);
		}
		
		return $links;
	}
	
	public function getChurchSelector($args)
	{
		$churches = $this->entityManager->getRepository('Worship_Entity_Church')->findBy(array());
		
		$list = "<select name=\"{$args['name']}\" id=\"{$args['name']}\">";
		
		foreach($churches as $church)
		{
			$list .="<option value=\"{$church->getCid()}\"> {$church->getName()} </option>";
		}
		$list .="</select>";
		return $list;
	}
	
	public function getChurchSelectorForm($args)
	{
		$churches = $this->entityManager->getRepository('Worship_Entity_Church')->findBy(array());
		
		$list = array();
		foreach($churches as $church)
		{
			$list[] = array(
			'text' => $church->getName(),
			'value' => $church->getCid(),
			);
		}
		return $list;
	}
	
	public function getChurchNameById($args)
	{
		$church = $this->entityManager->find('Worship_Entity_Church', $args['id']);
		return $church->getName();
	}
	
	public function getDateById($args)
	{
		$date = $this->entityManager->find('Worship_Entity_Day', $args['id']);
		return $date->getwDateFormatted();
	}
	
	public function getDayNameById($args)
	{
		if($args['short']==true)
			switch($args['id'])
			{
				case 0: $day = 'So.';break;
				case 1: $day = 'Mo.';break;
				case 2: $day = 'Di.';break;
				case 3: $day = 'Mi.';break;
				case 4: $day = 'Do.';break;
				case 5: $day = 'Fr.';break;
				case 6: $day = 'Sa.';break;
			}
		else
			switch($args['id'])
			{
				case 0: $day = 'Sonntag';break;
				case 1: $day = 'Montag';break;
				case 2: $day = 'Dienstag';break;
				case 3: $day = 'Mittwoch';break;
				case 4: $day = 'Donnerstag';break;
				case 5: $day = 'Freitag';break;
				case 6: $day = 'Samstag';break;
			}
		return $day;
	}
	
	public function getWeekdaySelector($args)
	{
		$weekdays = array('Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag');
		
		$list = "<select name=\"{$args['name']}\" id=\"{$args['name']}\">";
		$count = 0;
		foreach($weekdays as $weekday)
		{
			$list .="<option value=\"{$count}\"> {$weekday} </option>";
			$count ++;
		}
		$list .="</select>";
		return $list;
	}
	
	public function getWeekdaySelectorForm($args)
	{
		
		$list = array();
		$list[] = array(
		'text' => 'Sonntag',
		'value' => '0',
		);
		$list[] = array(
		'text' => 'Montag',
		'value' => '1',
		);
		$list[] = array(
		'text' => 'Dienstag',
		'value' => '2',
		);
		$list[] = array(
		'text' => 'Mittwoch',
		'value' => '3',
		);
		$list[] = array(
		'text' => 'Donnerstag',
		'value' => '4',
		);
		$list[] = array(
		'text' => 'Freitag',
		'value' => '5',
		);
		$list[] = array(
		'text' => 'Samstag',
		'value' => '6',
		);
		
		return $list;
	}
}
