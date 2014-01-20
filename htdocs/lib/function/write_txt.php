<?php
/**
 * 寫入檔案函式庫
*/

// ========================================================================
/**
 * 寫入txt檔案
 *
 * @param string $create_txt_content 檔案內文
 * @param string $writeURL 路徑
 * @return string
 *          寫入結果
 *          <ul>
 *            <li>"Finish": 成功寫入</li>
 *            <li>其他: 無法寫入，回傳內文</li>
 *          </ul>
 * @since Version 1
 * @author 元兒～ <yuan817@moztw.org>
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