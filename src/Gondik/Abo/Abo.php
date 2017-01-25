<?php

namespace Gondik\Abo;

use Gondik\Abo\Account;

/**
 *
 */
class Abo 
{
	const HEADER = 'UHL1';

	private $items = array();
	private $organization;
	private $date;
	private $comittent_number = 0;
	private $fixedKeyPart = null;
	private $securityCode = null;
	
	public function __construct($organization = "")
	{	
		$this->setOrganization($organization);
		$this->setDate();
	}
	
	/**
	 * 
	 * Set the organization name. Less then 20 chars.
	 * @param string $organization
	 */
	public function setOrganization($organization)
	{
		$this->organization = $organization;
		return $this;
	}
	
	/**
	 * 
	 * Optional part of the header. Set the Fixed key part and security code
	 * @param int $fixed -  6 numbers 
	 * @param int $securityCode 6 numbers
	 * @return abo
	 */
	public function setSecurityKey($fixed, $securityCode)
	{
		$this->fixedKeyPart = $fixed;
		$this->securityCode = $securityCode;
		return $this;
	}
	
	/**
	 * 
	 * Set date of file
	 * @param string $date format DDMMYY
	 */
	public function setDate($date = null)
	{
		if($date == null) {
			$date = date('dmy');	
		}
		$this->date = $date;
		return $this;		
		
	}
	
	public function setComittentNumer($number)
	{
		$this->comittent_number = $number;
		return $this;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param int $type - 1501 : platebni prikaz , 1502 inkaso  abo_account_file::UHRADA|abo_account_file::INKASO
	 * @return abo_account_file
	 */
	public function addAccountFile($type = 1501)
	{
		$item = new Account\File($type);
		$this->items[] = $item;
		$item->setNumber(count($this->items));
		return $item;
		
	}
	
	/**
	 * Get tha account files
	 * @return array of abo_account_file
	 */
	public function getFiles()
	{
		return $this->items;
	}
	
	public function generate()
	{
		$res = sprintf("%s%s% -20s%010d%03d%03d",self::HEADER, $this->date, $this->organization, $this->comittent_number,1,1+count($this->items));
		if($this->securityCode){
			$res .= sprintf("%06d%06d", $this->fixedKeyPart, $this->securityCode);
		}
		$res.= "\r\n";
		
		foreach ($this->items as $item) {
			$res .= $item->generate();
		}
				
		return $res;
		
	}
	
	public static function account($number, $pre = null)
	{
		$res = '';
		if($pre){
				$res.= sprintf("%d-",$pre);
			}
		$res .= sprintf("%d",  $number);
		return $res;
	}
	
}
