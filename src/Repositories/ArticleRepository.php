<?php

namespace src\Repositories;

use src\Models\Article as Article;
use src\Models\User;

class ArticleRepository extends Repository {

	/**
	 * @return Article[]
	 */
	public function getAllArticles(): array {
		$sqlStatement = $this->pdo->prepare("SELECT * FROM articles;");
        $sqlStatement->execute();
        $resultSet = $sqlStatement->fetchAll();

        $articles = [];
        foreach ($resultSet as $record) {
            $articles[] =new Article($record);
        }
		return $articles;
	}

	/**
	 * @param string $title
	 * @param string $url
	 * @param string $authorId
	 * @return Article|false
	 */
	public function saveArticle(string $title, string $url, string $authorId): Article|false {
        $sqlStatement = $this->pdo->prepare("INSERT INTO articles (id, title, url, created_at, updated_at, author_id) VALUES(NULL, ?, ?, ?, NULL, ?);");
        $createdAt = date('Y-m-d H:i:s');
        try {
            $success = $sqlStatement->execute([$title, $url, $createdAt, $authorId]);
            if ($success) {
                // Get the last insert user.
                $articleId = $this->pdo->lastInsertId();
                return $this->getArticleById($articleId);
            }
            return false;
        } catch (PDOException) {
            return false;
        }
	}

	/**
	 * @param int $id
	 * @return Article|false Article object if it was found, false otherwise
	 */
	public function getArticleById(int $id): Article|false {
        $sqlStatement = $this->pdo->prepare('SELECT id, title, url, created_at, updated_at, author_id FROM articles WHERE id = ?');
        $sqlStatement->execute([$id]);
        $resultSet = $sqlStatement->fetch();
        if ($resultSet) {
            return (new Article($resultSet));
        }
        return false;
	}

	/**
	 * @param int $id
	 * @param string $title
	 * @param string $url
	 * @return bool true on success, false otherwise
	 */
	public function updateArticle(int $id, string $title, string $url): bool {
        $sqlStatement = $this->pdo->prepare("UPDATE articles SET title = ?, url = ?, updated_at = ? WHERE id = ?");
        $updatedAt = date('Y-m-d H:i:s');
        return $sqlStatement->execute([$title, $url, $updatedAt, $id]);
	}

	/**
	 * @param int $id
	 * @return bool true on success, false otherwise
	 */
	public function deleteArticleById(int $id): bool {
		$sqlStatement = $this->pdo->prepare("DELETE FROM articles WHERE id = ?");
        return $sqlStatement->execute([$id]);
	}

	/**
	 * @param string $articleId
	 * @return User|false
	 */
	public function getArticleAuthor(string $articleId): User|false {
		$sqlStatement = $this->pdo->prepare("SELECT * FROM articles WHERE id = ?;");
        $sqlStatement->execute([$articleId]);
        $resultSet =$sqlStatement->fetch();
        if ($resultSet) {
            return new Article($resultSet);
        }
        return false;
	}
}
