<?php

namespace Contexis\Twig\Functions;

use Contexis\Twig\CustomFunctions;
use dokuwiki\Extension\Event;
use dokuwiki\plugins\rest\Models\Page;

/**
 * Get list of files in a given namespace
 */
class GetPage extends CustomFunctions
{

	public string $name = "get_page";

	public function render($id)
	{
		//var_dump(Page::where($key, $arg));
		return Page::find($id);
	}
}
