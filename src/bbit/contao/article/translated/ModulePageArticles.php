<?php

namespace bbit\contao\article\translated;

use Hofff\Contao\LanguageRelations\LanguageRelations;

/**
 * @author Oliver Hoff <oliver@hofff.com>
 * @deprecated
 */
class ModulePageArticles extends \ModuleIncludePageArticles {

	public function __construct($module, $column = 'main') {
		parent::__construct($module, $column);
	}

	public function getPage() {
		$page = $this->bbit_mod_art_page;
		if(!$GLOBALS['objPage']) {
			return $page;
		}
		$root = $GLOBALS['objPage']->rootId;
		$relations = LanguageRelations::getRelations($page);
		return $relations[$root] ?: $page;
	}

}
