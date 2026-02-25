//ニュース欄を初期化
const NEWS = document.getElementById("NEWS");
NEWS_GET();
function NEWS_GET(){
	let viewXML = (xmlDocument) => {
		//取得した文字列をコンソール出力
		//console.log(xmlDocument);
	
		//XML形式に変換
		const parser = new DOMParser();
		const doc = parser.parseFromString(xmlDocument, "text/xml");
		let rss = doc.documentElement.getElementsByTagName("item");
	
		//HTMLタグの作成
		for(let i = 0;i < rss.length;i++){
			//RSSから取得したタイトルとリンク情報を格納
			let rssTitle = rss[i].getElementsByTagName("title")[0].textContent;
			let rssLink   = rss[i].getElementsByTagName("link")[0].textContent;
	
			//テンプレート文字列を使ってアンカータグを作成
			const tagString = "<R style=\"margin-right: 100px;\"><a href=\"" + rssLink + "\" target=\"_blank\">" + rssTitle + "</a></R>";

			//body以下にアンカータグを挿入
			console.log(tagString);
			NEWS.innerHTML += tagString;
		}
	};
	const URL = 'https://www.nhk.or.jp/rss/news/cat0.xml';
	fetch(URL)
	.then( response => response.text())
	.then( xmlData => viewXML(xmlData));
}