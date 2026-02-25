//STはスペース/タブ
function SYNTAX_ST(TEXT) {
	//フォーマットもする
	TEXT = TEXT.replaceAll("&", "&amp;");
	TEXT = TEXT.replaceAll("<", "&lt;");
	TEXT = TEXT.replaceAll(">", "&gt;");
	TEXT = TEXT.replaceAll("\"", "&quot;");
	TEXT = TEXT.replaceAll("'", "&#39;");

	//スペース/インデントを可視化
	TEXT = TEXT.replaceAll(" ", "<SPAN CLASS=\"EDITOR_CONTENTS EDITOR_CONTENTS_SPACE\"> </SPAN>");
	TEXT = TEXT.replaceAll("　", "<SPAN CLASS=\"EDITOR_CONTENTS EDITOR_CONTENTS_ZSPACE\">　</SPAN>");
	TEXT = TEXT.replaceAll("\t", "<SPAN CLASS=\"EDITOR_CONTENTS EDITOR_CONTENTS_TAB\">\t</SPAN>");

	return TEXT;
}