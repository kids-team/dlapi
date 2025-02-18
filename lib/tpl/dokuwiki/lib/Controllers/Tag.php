<?php

namespace Contexis\Controllers;

use Contexis\Core\Controller;
use Contexis\Database\Index;
use dokuwiki\plugins\rest\Models\Page;
use Contexis\Twig\Renderer;

class Tag extends Controller
{


	public function __construct($site)
	{
		global $ID;

		parent::__construct($site);

		$path = explode(":", $ID);
		if (count($path) == 1) {
			$this->template = "tags";
			$this->site->add_data("tags", Index::getMetaValues("subject"));
			return;
		}

		$tag = end(explode(":", $ID));
		$pages = Page::where("tag", $tag);
		$this->site->add_data("pages", $pages);
		$this->site->add_data("tag", $tag);
	}
}
