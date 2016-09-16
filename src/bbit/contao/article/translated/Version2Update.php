<?php

namespace bbit\contao\article\translated;

use BackboneIT\Contao\Article\Database\Version3Update;
use Contao\Database;
use Contao\Database\Result;

/**
 * @author Oliver Hoff <oliver@hofff.com>
 * @deprecated
 */
class Version2Update extends Version3Update {

	/**
	 * @var Database
	 */
	protected static $db;

	/**
	 * @return void
	 */
	public static function update() {
		self::$db = Database::getInstance();

		foreach([ 'tl_content', 'tl_module' ] as $table) {
			self::convertTranslatedPageArticle($table);
		}
	}

	/**
	 * @param string $table
	 * @return void
	 */
	protected static function convertTranslatedPageArticle($table) {
		self::convert($table, 'bbit_mod_pageArtTranslated', function($result) use($table) {
			$id = $result->bbit_mod_art_page;
			if(!$id) {
				return;
			}

			$key = 'page.' . $id;
			$css = deserialize($result->cssID, true);
			$targetSectionFilter = $table != 'tl_content' && !$result->bbit_mod_art_setColumns;
			$targetSectionFilter = $targetSectionFilter ? '1' : '';

			$references = [];
			$references[$key]['_key'] = $key;
			$references[$key]['source_sections'] = $targetSectionFilter ? [] : deserialize($result->bbit_mod_art_columns);
			$references[$key]['target_section_filter'] = $targetSectionFilter;
			$references[$key]['exclude_from_search'] = $result->bbit_mod_art_nosearch;
			$references[$key]['render_container'] = $result->bbit_mod_art_container;
			$references[$key]['css_classes'] = isset($css[1]) ? $css[1] : '';
			$references[$key]['translate'] = '1';

			self::setColumn($table, 'cssID', $id, [ '', '' ]);
			self::setColumn($table, 'bbit_mod_art_multiTemplate', $id, '');

			return $references;
		});
	}

}
