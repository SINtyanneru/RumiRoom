<?php
class LANG_SYSTEM{
	private $LANG_DIR_PATH = "../LANG/";
	private $LANG_DATA = null;

	public function __construct($SITE){
		$this->LANG_DIR_PATH = $this->LANG_DIR_PATH.$SITE."/";
		if(isset($_COOKIE["LANG"])){
			$this->LANG_FILE_LOAD($_COOKIE["LANG"]);
		}else{
			$DETECTED_LANG = $this->DETECT_LANG();
			setcookie("LANG", $DETECTED_LANG, time()+999999, "/");//くっきーにJPをセット

			$this->LANG_FILE_LOAD($DETECTED_LANG);
		}
	}

	private function DETECT_LANG(){
		//設定言語が有るか
		if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
			$USER_LANG = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
			//言語タグのリストを配列に分割する
			$LANGS = explode(',', $USER_LANG);

			//最も優先されている言語を取得する（最初の要素）
			$PRE_LANG = trim($LANGS[0]);

			if($PRE_LANG === "ja"){
				return "JP_JAP";
			}if($PRE_LANG === "ru"){
				return "RU_RUS";
			}else{
				return "US_ENG";
			}
		}else{
			//ブラウザの言語設定が見つからない場合の処理
			return "JP_JAP";
		}
	}

	private function LANG_FILE_LOAD($LANG_ID){
		if(file_exists($this->LANG_DIR_PATH.$LANG_ID.".json")){
			$this->LANG_DATA = json_decode(file_get_contents($this->LANG_DIR_PATH.$LANG_ID.".json"), true);
			if($this->LANG_DATA === null){
				throw new Exception("言語ファイルが破損しています");
			}
		}else{
			throw new Exception("言語ファイルが存在しません:".$this->LANG_DIR_PATH.$LANG_ID.".json");
		}
	}

	public function GET($KEY){
		if(!empty($this->LANG_DATA[$KEY]) && !empty($this->LANG_DATA)){
			return $this->LANG_DATA[$KEY];
		}else{
			return "言語ファイルにキー".$KEY."は存在しません";
		}
	}
}
?>