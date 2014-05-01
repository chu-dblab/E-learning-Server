<?php
/**
 * 推薦學習點類別
 */
 
  //前置作業
  require_once("../../../lib/include.php");
  require_once(DOCUMENT_ROOT."lib/class/Database.php");

// =======================================================================
/**
 * 規劃學習路徑類別
 *
 * 為這一位使用者規劃出最佳的學習路徑
 * 
 * TODO 準備取代RecommandLearnNode類別用
 *  
 */
class LearnRecommand {

	/**
	 * 使用者物件
	 *
	 * @access private
	 * @var MyUser Object
	 *
	 */
	private $user;

	/**
	 * 調和參數
	 *
	 * 此欄位是常數值
	 * 
	 * @access private
	 * @var int
	 */
	const ALPHA = 0.5; //調和參數

	/**
	 * 正規化參數
	 *
	 * @access private
	 * @var double
	 */
	private $gamma;  //正規化參數

	// ---------------------------------------------------------------------

	/**
	* getLearningNode
	*
  * 取得學習點的參數值，將數值帶入公式計算出推薦分數最高的前三名
  *
	* TODO 我沒看懂，待修
	*
	* @param int $remainingTime 目前剩餘學習時間
	* @return array 系統推薦的學習點 
	*/
	public function getLearningNode($remainingTime) {

	}

	/**
	 * 所有學習點是否已學完
	 *
   * 確認學習點是否已經學完了
   *
	 * TODO 為什麼要帶那麼多參數？
   *
	 * @param array $matrix 下一個學習點(含虛擬點)
	 * @param int $point_number 標的編號
	 * @param int $remainingTime 目前剩餘學習時間
	 * @return 系統推薦的學習點(已過濾)
	 */
	private function checkIsAllPointAreLearned($matrix ,$point_number
	                                           ,$remainingTime) {

	}

	/**
	 * computeNormalizationParam
	 *
	 * 計算正規化參數
	 *
	 * @return 正規化參數
	 */
	public function computeNormalizationParam() {

	}

	/**
	* getNodeOfLearnOfParameter
	*
  * 取得學習點的所有參數
  *
	* TODO 這是什麼？
	*
	* @param int $next_point_number 學習點的編號
	* @return 學習點之所有參數(array)
	*/	
	private function getNodeOfLearnOfParameter($next_point_number) {

	}

	// ---------------------------------------------------------------------
	/**
	 * getLearningStatus
	 * 
	 * 取得使用者學習的狀態
	 *
	 * @param int $point_number 學習點的編號
	 * @return 學習狀態資訊(array)
	 */	
	public function getLearningStatus($point_number) {
		
	}
	
	/**
	 * checkFinish
	 *
	 * 確認使用者是不是學過系統推薦的學習點
	 *
	 * @param int $point 學習點編號
	 * @return boolean true->已經學過系統推薦的學習點
	 *                 ,false->還沒學過系統推薦的學習點
	 */
	private function checkFinish($point) {

	}

}
