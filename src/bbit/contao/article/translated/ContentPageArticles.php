<?php

namespace bbit\contao\article\translated;

use Hofff\Contao\LanguageRelations\LanguageRelations;

/**
 * @author Oliver Hoff <oliver@hofff.com>
 * @deprecated
 */
class ContentPageArticles extends \ContentIncludePageArticles {

	public function __construct($element) {
		parent::__construct($element);
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
