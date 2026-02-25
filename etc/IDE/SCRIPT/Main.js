const TEXT = `IDEを作る実験
VSCodeみたいなのを作りたいところ





テストテストテスト
テストテストテスト
テストテストテスト
テストテストテスト
テストテストテスト
テストテストテスト
テストテストテスト
テストテストテスト
テストテストテスト
テストテストテスト`;

const EL = {
TEXTEDIT: document.getElementById("TEXTEDIT"),
INDENT_SELECT: document.getElementById("INDENT_SELECT"),
LANG_SELECT: document.getElementById("LANG_SELECT")
};

let EDITOR_1 = new EDITOR(TEXT, "test.txt", TEXTEDIT);