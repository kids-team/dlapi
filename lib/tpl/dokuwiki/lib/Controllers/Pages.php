<?php

namespace Contexis\Controllers;

use Contexis\Core\Controller;
use \dokuwiki\Input\Input;


class Pages extends Controller
{

	public $template = "";
	public function __construct($site)
	{
		parent::__construct($site);
	}

	/**
	 * Returns an array of pages
	 *
	 * @return void
	 */
	public function ajax_get(Input $request)
	{
		header('Content-Type: application/json');

		$query = $request->str("query", "id");
		$value = $request->str("value", "start");

		$filter = key_exists('filter', $_REQUEST) ? array_flip(explode(",", $_REQUEST['filter'])) : [];
		$pages = \Contexis\Models\Page::where($query, $value, $filter);
		if (empty($filter)) {
			return json_encode($pages);
		}

		$result = [];

		foreach ($pages as $page) {
			$result[] = $page->to_array($filter);
		}

		return json_encode($result);
	}

	public function ajax_get_tag(Input $request)
	{
		header('Content-Type: application/json');

		$tag = $request->str("tag", "start");

		$filter = key_exists('filter', $_REQUEST) ? array_flip(explode(",", $_REQUEST['filter'])) : [];
		$pages = \Contexis\Models\Page::where('tag', $tag, $filter);
		if (empty($filter)) {
			return json_encode(['articles' => $pages, 'root' => \Contexis\Models\Page::find('tag:' . $tag)]);
		}

		$result = [];

		foreach ($pages as $page) {
			$result[] = $page->to_array();
		}
		return json_encode(['articles' => $result, 'tag_page' => \Contexis\Models\Page::find('tag:' . $tag)]);
	}
}