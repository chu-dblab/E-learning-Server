<?php
	require_once("../../../lib/include.php");
	require_once(DOCUMENT_ROOT."lib/class/Database.php");
	
	class TimeControl
	{
		private $connection;
		public __construct()
		{
			$this->connection = new Database();
		}
		
		/**
		* 取得學習的總時間
		* @return		學習的總時間
		*/
		public getLearnTotalTime()
		{
			$result = $this->connection->prepare("SELECT Theme_LearnTotal FROM ".$this->connection->table("theme"));
			$result->execute();
			$row = $result->fetch();
			return $row["Theme_LearnTotal"];
		}
	}