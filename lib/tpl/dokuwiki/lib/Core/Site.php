<?php

/**
 * 
 * Class Site
 * 
 * Collects all Site-Data and returns array for Twig
 * 
 * @since 1.0.0
 * 
 */

namespace Contexis\Core;


class Site
{
	private array $twig_array;

	public function __construct()
	{
		global $conf;
		global $ID;
		global $ACT;
		global $INFO;
		global $lang;
		global $USERINFO;
		$auth = auth_quickaclcheck($ID);
		$this->twig_array['conf'] = $conf;
		$this->twig_array['id'] = $ID;
		$this->twig_array['act'] = $ACT;
		$this->twig_array['info'] = $INFO;
		$this->twig_array['lang'] = $lang;
		$this->twig_array['userinfo'] = $USERINFO;
		$this->twig_array['acl'] = [
			"none" => $auth === AUTH_NONE,
			"edit" => $auth >= AUTH_EDIT,
			"read" => $auth >= AUTH_READ,
			"create" => $auth >= AUTH_CREATE,
			"upload" => $auth >= AUTH_UPLOAD,
			"admin" => $auth >= AUTH_ADMIN,
			"delete" => $auth >= AUTH_DELETE
		];
		$this->twig_array['tpl_classes'] = tpl_classes();
		$this->twig_array['tpl_favicon'] = tpl_favicon();
		$this->twig_array['tpl_basedir'] = tpl_basedir();
		$this->twig_array['tpl_inc'] = DOKU_TPLINC;
		$this->twig_array['breadcrumbs'] = \Contexis\Core\Breadcrumbs::get();
		$this->twig_array['metadata'] = p_get_metadata($ID);
		//$this->twig_array['tld'] = \Contexis\Core\Utilities\Domain::get_tld();
		$this->twig_array['page_exists'] = page_exists($ID);
		//$this->twig_array['pageimage'] = $this->getPageImage($metadata);
	}

	public function add_data($key, $value)
	{
		$this->twig_array[$key] = $value;
	}

	public function get($key = false)
	{
		if (!$key) {
			return $this->twig_array;
		}


		return $this->twig_array[$key];
	}
}
