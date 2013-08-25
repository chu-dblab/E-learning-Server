<?php
require_once(DOCUMENT_ROOT."config.php");
// ------------------------------------------------------------------------

/**
 The MIT License

 Copyright (c) 2007 <Tsung-Hao>

 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:

 The above copyright notice and this permission notice shall be included in
 all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 THE SOFTWARE.
 *
 * @author: tsung http://plog.longwin.com.tw
 * @desc: http://blog.longwin.com.tw/2007/11/php_snap_image_block_2007/
 *
 */
function generatorText($password_len)
{
    $password = '';

    // remove o,0,1,l
    $word = 'abcdefghijkmnpqrstuvwxyz!@#%^&*()-=ABCDEFGHIJKLMNPQRSTUVWXYZ;{}[]23456789';
    $len = strlen($word);

    for ($i = 0; $i < $password_len; $i++) {
        $password .= $word[rand() % $len];
    }

    return $password;
}

// USAGE:
// echo generatorText() . "\n";
// ------------------------------------------------------------------------

/**
 * encryptText
 *
 * 將文字加密
 *
 * @param	string	原文內容
 * @param	string	加密方式（目前只提供MD5）
 * @return	string	加密後內容
 * 
 * @since	Version 1
 * @author	元兒～ <yuan817@moztw.org>
 */
 /**
 * encryptText
 *
 * 將文字加密（不帶第二個參數）
 * 不帶第二個參數，就自動從預設的帶起
 *
 * @param	string	原文內容
 * @return	string	加密後內容
 * 
 * @since	Version 1
 * @author	元兒～ <yuan817@moztw.org>
 */
function encryptText(){
	if(func_num_args() == 2){
		$args = func_get_args();
		$text = $args[0];
		$mode = $args[1];
		
		switch($mode){
			case "MD5":
				return md5($text);
				break;
			case "SHA1":
				return sha1($text);
				break;
			case "CRYPT":
				return crypt($text);
				break;
			default:
				return $text;
				break;
		}
	}
	else if(func_num_args() == 1){
		global $ENCRYPT_MODE;
		$args = func_get_args();
		$text = $args[0];
		
		return encryptText($text, $ENCRYPT_MODE);
	}
}
// ------------------------------------------------------------------------
