<?php

namespace Contexis\Models;

use Contexis\Core\Utilities\Strings;

class Tag
{
	static function findAll($assoc = false)
	{
		if (!page_exists("system:tags")) return [];
		$tags = Strings::json_to_array(rawWiki("system:tags"));
		if (!$assoc) return $tags;
		$result = [];
		foreach ($tags as $tag) {
			if (!array_key_exists('id', $tag)) continue;
			$result[$tag['id']] = $tag;
		}
		return $result;
	}
}
