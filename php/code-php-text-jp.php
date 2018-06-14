<?php
/*----------------------------------------------------------------------------------------------------------*/
$str_1byte  = 'あへlお';
$str_2byte  = 'あへ';

$str_syntax = 'あへおadfads';
$str_full   = '1234-_:ー：Ｇ    ａｍｅ1234-_:ー：あへおadfad～s０１２３４５６７８９ メーカーコード｟ ｠ ｡ ｢ ｣ ､ ･ ｦ ｧ ｨ ｩ ｪ ｫ ｬ ｭ ｮ ｯ ｰ ｱ ｲ ｳ ｴ ｵ ｶ ｷ ｸ ｹ ｺ ｻ ｼ ｽ ｾ ｿ ﾀ ﾁ ﾂ ﾃ ﾄ ﾅ ﾆ ﾇ ﾈ ﾉ ﾊ ﾋ ﾌ ﾍ ﾎ ﾏ ﾐ ﾑ ﾒ ﾓ ﾔ ﾕ ﾖ ﾗ ﾘ ﾙ ﾚ ﾛ ﾜ ﾝ ﾞ';
$str_katana1byte = '｟ ｠ ｡ ｢ ｣ ､ ･ ｦ ｧ ｨ ｩ ｪ ｫ ｬ ｭ ｮ ｯ ｰ ｱ ｲ ｳ ｴ ｵ ｶ ｷ ｸ ｹ ｺ ｻ ｼ ｽ ｾ ｿ ﾀ ﾁ ﾂ ﾃ ﾄ ﾅ ﾆ ﾇ ﾈ ﾉ ﾊ ﾋ ﾌ ﾍ ﾎ ﾏ ﾐ ﾑ ﾒ ﾓ ﾔ ﾕ ﾖ ﾗ ﾘ ﾙ ﾚ ﾛ ﾜ ﾝ ﾞ';
$str_katana2byte = '｟　｠　。　「　」　、　・　ヲ　ァ　ィ　ゥ　ェ　ォ　ャ　ュ　ョ　ッ　ー　ア　イ　ウ　エ　オ　カ　キ　ク　ケ　コ　サ　シ　ス　セ　ソ　タ　チ　ツ　テ　ト　ナ　ニ　ヌ　ネ　ノ　ハ　ヒ　フ　ヘ　ホ　マ　ミ　ム　メ　モ　ヤ　ユ　ヨ　ラ　リ　ル　レ　ロ　ワ　ン　゛';
// $str_full   = 'a日～c 本1.yあへlお英字';
/*----------------------------------------------------------------------------------------------------------*/
echo '<pre>';
echo $str_full.'<br>';
$str_full = _validate_input($str_full);
echo $str_full;
/*----------------------------------------------------------------------------------------------------------*/
function _validate_input($str){
	//remove các ký tự quy định
	$string = preg_replace('/\-+|\_+|\.+|\:+|\_+|\ー+|\・+|\：+|\s+/', '', $str);

	$string = preg_split('//u', $string, null, PREG_SPLIT_NO_EMPTY);
	foreach ($string as $key => $value) {
		if( preg_match("/[\x{ff01}-\x{ff5e}]/u", $value) ){
			$string[$key] = convert_to_1byte($value);
		}else if( preg_match("/[\x{ff5f}-\x{ff9f}]/u", $value) ){
			$string[$key] = kana_convert_to_2byte($value);
		}
	}
	$string = implode($string,'');
	return $string;
}

function is_2byte($str){

	return preg_match('/^[^ -~｡-ﾟ\x00-\x1f\t]+$/u',$str);
}

function isKanji($str) {

    return preg_match('/[\x{4E00}-\x{9FBF}]/u', $str) > 0;
}

function isHiragana($str) {

    return preg_match('/[\x{3040}-\x{309F}]/u', $str) > 0;
}

function isKatakana($str) {

    return preg_match('/[\x{30A0}-\x{30FF}]/u', $str) > 0;
}

function isJapanese($str) {

    return isKanji($str) || isHiragana($str) || isKatakana($str);
}

function isJapanese_text($str) {
    if(strlen($str) != mb_strlen($str)) {//không phải chữ tiếng nhật
		return true;
	}else{
		return false;
	}
}

function alphabe_convert_to_2byte($str){

	return mb_convert_kana($str, "R", 'UTF-8');;
}

function convert_to_1byte($str){
	$str = preg_replace_callback(
    "/[\x{ff01}-\x{ff5e}]/u",
    function($c) {
        // convert UTF-8 sequence to ordinal value
        $code = ((ord($c[0][0])&0xf)<<12)|((ord($c[0][1])&0x3f)<<6)|(ord($c[0][2])&0x3f);
        return chr($code-0xffe0);
    },
    $str);
    return $str;
}

function kana_convert_to_2byte($str){

	return mb_convert_kana($str, "KVC");
}

echo uniqid('', true);

echo '1234-_:ー：Ｇ    ａｍｅ1234-_:ー：あへおadfad～s０１２３４５６７８９ メーカーコード｟ ｠ ｡ ｢ ｣ ､ ･ ｦ ｧ ｨ ｩ ｪ ｫ ｬ ｭ ｮ ｯ ｰ ｱ ｲ ｳ ｴ ｵ ｶ ｷ ｸ ｹ ｺ ｻ ｼ ｽ ｾ ｿ ﾀ ﾁ ﾂ ﾃ ﾄ ﾅ ﾆ ﾇ ﾈ ﾉ ﾊ ﾋ ﾌ ﾍ ﾎ ﾏ ﾐ ﾑ ﾒ ﾓ ﾔ ﾕ ﾖ ﾗ ﾘ ﾙ ﾚ ﾛ ﾜ ﾝ ﾞ';