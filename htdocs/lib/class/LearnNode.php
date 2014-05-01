<?php
/**
 * 推薦學習點類別
 */
 
  //前置作業
  require_once("../../../lib/include.php");
  require_once(DOCUMENT_ROOT."lib/class/Database.php");

// =======================================================================
/**
 * 學習點類別
 * 
 * 這個物件代表一個學習點
 *
 * TODO 準備取代RecommandLearnNode類別用
 *  
 */
class LearnNode {

	/**
	 * 標的編號
	 *
	 * 對應target資料表的TID欄位
	 *
	 * @access private
	 * @var int
	 */
	private $tID;

	// ---------------------------------------------------------------------
	/**
	 * 建構子
	 *
	 * @param int $tID 標的編號
	 */
	public function __construct($tID){

		$this->tID = $tID;
  }

	// ---------------------------------------------------------------------
	/**
	 * 取得目前在此學習點有多少人
	 *
	 * @access public
	 * @return int 目前此點有多少人
	 * 
	 */
	public function getCurrentPeopleNum() {

	}

	/**
	 * 取得在此學習點能容納人數
	 *
	 * @access public
	 * @return int 此點可容納多少人
	 * 
	 */
	public function getMaxPeopleNum() {

	}		

	// ---------------------------------------------------------------------
	/**
	 * 目前是否沒人
	 *
	 * @access public
	 * @return boolean 目前有沒有人
	 * 
	 */
	public function isNoPeople() {

	}	

	/**
	 * 目前是否已經額滿
	 *
	 * @access public
	 * @return boolean 目前人數是否已滿
	 * 
	 */
	public function isFullPeople() {

	}

	 // --------------------------------------------------------------------
	/**
	 * 加人數
	 *
	 * 當使用者的手機偵測到NFC Tag或掃描到QR code, 則人數加一
	 *
	 * @access private
	 */
	public function addCurrentPeople() {

	}

	/**
	 * 減人數
	 *
	 * 當使用者按下"離開"按鈕時, 則人數減一
	 *
	 * @access public
	 */
	public function subCurrentPeople() {

	}
}
