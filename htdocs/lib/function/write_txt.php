<?php
/**
 * 前置設定
 * 
 * @since	Version 1
*/

// ========================================================================
/**
 * write_txt
 *
 * 寫入txt檔案
 *
 * @param	string	檔案內文
 * @param	string	路徑
 * @return	string	寫入結果
 * 		"Finish": 成功寫入
 * 		其他: 無法寫入，回傳內文
 * 
 * @since	Version 1
 * @author	元兒～ <yuan817@moztw.org>
*/
function write_txt($create_txt_content, $writeURL) {
	if($fp=fopen($writeURL,"w+")){
		fputs($fp,$create_txt_content);
		return "Finish";
	}
	else{
		return $create_txt_content;
	}
	fclose($fp);
}