<?php
declare(strict_types=1);
$page__page_list = [];

/**
 * ページを定義する型です
 */
final readonly class Page {
	/**
	* @param string $url				URLです、/から始まります
	 * @param string|null $path			includeするPHP/HTMLファイルに有りかです、フルパスにしてもろて
	 * @param string $title				ページタイトル
	 * @param string $description		ページ説明
	 * @param bool $show_menu			メニューに表示するか
	 * @param string|null $menu_icon	メニューでのアイコン
	 */
	public function __construct(
		public string $url,
		public string|null $path,

		public string $title,
		public string $description,

		public bool $show_menu,
		public string|null $menu_icon,
	) {}
}

/**
 * ページを追加します
 * @param Page $page ページ
 */
function page_add(Page $page): void {
	global $page__page_list;
	$page__page_list[] = $page;
}

/**
 * ページの一覧を取得します
 * @return array Page型の一覧
 */
function page_get_list(): array {
	global $page__page_list;
	return $page__page_list;
}

/**
 * ページをURLから逆引きします
 * @param mixed $url URL
 */
function page_get_from_url($url): Page|null {
	foreach (page_get_list() as $page) {
		if ($page->url == $url) {
			return $page;
		}
	}

	return null;
}