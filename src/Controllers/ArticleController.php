<?php

namespace src\Controllers;

use core\Request;
use src\Repositories\ArticleRepository;
use src\Repositories\UserRepository;
use src\Models\Article;
class ArticleController extends Controller
{

	/**
	 * Display the page showing the articles.
	 * @return void
	 */
	public function index(): void
	{
		$this->render('index', ['articles' => []]);
	}

	/**
	 * Process the storing of a new article.
	 * @return void
	 */
	public function create(): void
	{
		$this->render('new_article');
	}

	public function store(Request $request): void
    {
		$title = $request->input('title');
        $url = $request->input('url');

        // Check the condition of input field.
        if (empty($title) || $title === "Title") {
            $title_hint_message = "Title can not be empty!";
            $this->render('new_article', [$title_hint_message]);
        }
        elseif (!filter_var($url, FILTER_VALIDATE_URL)) {
            $url_hint_message = "URL is invalid.";
            $this->render('new_article', [$url_hint_message]);
        }
        else{
            // Save new article.
            $articleRepository = new ArticleRepository();
            $articleRepository->saveArticle($title, $url, $_SESSION['userId']);
            $this->redirect('/');
        }
	}

	/**
	 * Show the form for editing an article.
	 * @param Request $request
	 * @return void
	 */
	public function edit(Request $request): void
	{
        // Get request data.
        $id = $request->input('updateArticle');
        $title = $request->input('title');
        $url = $request->input('url');

        // Render page with data.
        $this->render('update_article', [$title, $url, $id]);
    }

	/**
	 * Process the editing of an article.
	 * @param Request $request
	 * @return void
	 */
	public function update(Request $request): void
	{
        // Get request data.
        $id = $request->input('id');
        $title = $request->input('title');
        $url = $request->input('url');

        // Check the condition of input field.
        if (empty($title) || $title === "Title") {
            $title_hint_message = "Title can not be empty!";
            $this->render('update_article', [$title, $url, $id, $title_hint_message]);
        }
        elseif (!filter_var($url, FILTER_VALIDATE_URL)) {
            $url_hint_message = "URL is invalid.";
            $this->render('update_article', [$title, $url, $id, $url_hint_message]);
        }
        else{
            // Update article.
            $articleRepository = new ArticleRepository();
            $articleRepository->updateArticle($id, $title, $url);
            $this->redirect('/');
        }
	}

	/**
	 * Process the deleting of an article.
	 * @param Request $request
	 * @return void
	 */
	public function delete(Request $request): void
	{
        // Get request data.
        $id = $request->input('id');

        // Delete this post by id.
        $articleRepository = new ArticleRepository();
        $articleRepository->deleteArticleById($id);

        // Back to the index page.
        $this->render('index');
	}
}
