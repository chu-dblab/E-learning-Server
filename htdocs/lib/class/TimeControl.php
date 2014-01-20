<?php
/**
 * 時間控制類別
 */
	require_once("../../../lib/include.php");
	require_once(DOCUMENT_ROOT."lib/class/Database.php");
//========================================================================================================
	/**
	 * 時間控制類別
	 *
	 * 學習的時間控制
	 * @author ~kobayashi();
	 * @link https://github.com/CHU-TDAP/
	 * @version 2.0
	 */
	class TimeControl
	{
		/**
		 * 資料庫PDO連接物件
		 *
		 * @access private
		 */
		private $connection;
		
		
		public __construct()
		{
			$this->connection = new Database();
		}
		
		/**
		* 取得學習的總時間
		* @return 學習的總時間
		*/
		public getLearnTotalTime()
		{
			$result = $this->connection->prepare("SELECT Theme_LearnTotal FROM ".$this->connection->table("theme"));
			$result->execute();
			$row = $result->fetch();
			return $row["Theme_LearnTotal"];
		}
	}