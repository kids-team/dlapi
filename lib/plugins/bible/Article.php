<?php

namespace dokuwiki\plugin\bible;

use dokuwiki\plugins\rest\Models\Page;
use SQLite3;
use PDO;

/**
 * Bible Article
 * 
 * Get Doku Pages linked with a Bible reference or get the Bible References linked to an article
 * 
 * @package bible
 * @author Thomas Gollenia
 * @access 
 * @version 2.0
 */
class Article
{

	/**
	 * Return a list of Articles linked to a given bible ref
	 *
	 * @param Book $book
	 * @param integer $chapter
	 * @param integer $verse
	 * @return array<Page>
	 */
	static function where(Book $book, int $chapter = 0, $verse = 0)
	{
		global $conf;
		$db = Bible::get_db();

		$statement = $db->prepare("SELECT id, doku_id, book_id, chapter FROM pages WHERE (book_id = :book AND chapter IN (0, :chapter))");

		$statement->bindValue(':book', $book->id, SQLITE3_INTEGER);
		$statement->bindParam(':chapter', $chapter, SQLITE3_INTEGER);

		$query = $statement->execute();
		$result = [];

		while ($row = $query->fetchArray(SQLITE3_ASSOC)) {
			array_push(
				$result,
				$row
			);
		}
		return $result;
	}

	/**
	 * Add a bible reference to an article if the reference does not already exist
	 *
	 * @param Book $book
	 * @param [type] $id
	 * @param integer $chapter
	 * @return int ID of inserted Row
	 */
	static function add(Book $book, $id, $chapter = 0, $verse = 0)
	{
		$db = Bible::get_db();
		$statement = $db->prepare("SELECT * FROM pages WHERE (doku_id = :doku_id AND book_id = :book_id AND chapter = :chapter)");
		$statement->bindValue(':doku_id', $id, SQLITE3_TEXT);
		$statement->bindValue(':book_id', $book->id, SQLITE3_INTEGER);
		$statement->bindValue(':chapter', $chapter, SQLITE3_INTEGER);
		$query = $statement->execute();


		$query->finalize();
		$statement = $db->prepare("INSERT INTO pages (doku_id, book_id, chapter) VALUES (:doku_id, :book_id, :chapter)");

		$statement->bindValue(':doku_id', $id, SQLITE3_TEXT);
		$statement->bindValue(':book_id', $book->id, SQLITE3_INTEGER);
		$statement->bindValue(':chapter', $chapter, SQLITE3_INTEGER);
		$query = $statement->execute();
		return $db->lastInsertRowID();
	}

	static function hasBiblerefs($id)
	{
		$db = Bible::get_db();
		$statement = $db->prepare("SELECT id, book_id, chapter FROM pages WHERE doku_id = :doku_id");
		$statement->bindValue(':doku_id', $id, SQLITE3_TEXT);
		$query = $statement->execute();
		$result = [];
		while ($row = $query->fetchArray(SQLITE3_ASSOC)) {
			array_push($result, $row);
		}
		return $result;
	}

	static function remove($id)
	{
		global $conf;

		$db = Bible::get_db();
		$statement = $db->prepare("DELETE FROM pages WHERE id = :id");
		$statement->bindValue(':id', $id, SQLITE3_INTEGER);
		$query = $statement->execute();
		return $query;
	}
}
