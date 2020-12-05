<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comic")
 */
class ComicController extends AbstractController{

	private const POSTS = [
		[
			'id' => 1,
			'slug' => 'hello-world',
			'title' => 'Hello World!'
		],
		[
			'id' => 2,
			'slug' => 'comic-issue-2',
			'title' => 'Comic issue 2'
		],
		[
			'id' => 3,
			'slug' => 'comic-issue-3',
			'title' => 'Comic issue 3'
		]
	];

	/**
	 * @Route("/", name="comic_list")
	 */
	public function list()
	{
		return new JsonResponse(self::POSTS);
	}

	/**
	 * @Route("/{id}", name="comic_by_id", requirements={"id"="\d+"})
	 */
	public function post($id)
	{
		return new JsonResponse(
			self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
		);
	}

	/**
	 * @Route("/{slug}", name="comic_by_slug")
	 */
	public function postBySlug($slug)
	{
		return new JsonResponse(
			self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]
		);
	}

}