<?php
/**
 * 更新所有使用者資訊類別
 */
require_once("../../../lib/include.php");
require_once(DOCUMENT_ROOT."lib/class/Database.php");
//========================================================================

/**
 * 
 */
class LearnUserControl {

	/**
	 * 使用者物件
	 *
	 * @access private
	 * @var MyUser Object
	 *
	 */
	private $user;

	// ---------------------------------------------------------------------

  /**
   * 此一主題開始進行學習
   */
  public function startLearning() {

  }

  /**
   * 完成此主題的學習
   */
  public function finishLearning() {

  }

	// ---------------------------------------------------------------------

  /**
   * 進入一個學習點開始學習
   *
   * @param int $tid 學習點的編號
   */
  public function inToLearningNode($tid) {

    // 此學習點標記加人數

    // 登記到study表格

  }

  /**
   * 離開此學習點
   */
  public function outToLearningNode() {

    // 此學習點標記減人數

    // 登記到study表格

  }

  /**
   * 是否目前正在一個學習點學習中
   *
   * @return bool 是否還在此學習點內
   */
  public function isInLearningNode() {

  }

  /**
   * 取得目前正在哪一個學習點學習中
   *
   * @return int 目前正在哪一個學習點
   */
  public function getInLearningNode() {

  }
	
}
