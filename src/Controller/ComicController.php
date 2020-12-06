<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Issue;

/**
 * @Route("/comics")
 */
class ComicController extends AbstractController{

	/**
	 * @Route("/{page}", name="comic_list", defaults={"page": 5}, requirements={"page"="\d+"})
	 */
	public function list($page = 1, Request $request)
	{
		$limit = $request->get('limit', 10);
		$repository = $this->getDoctrine()->getRepository(Issue::class);
		$items = $repository->findAll();
		
		return $this->json(
			[
				'page' => $page,
				'limit' => $limit,
				'data' => array_map(function(Issue $item){
					return $this->generateUrl("comic_by_slug", ['slug' => $item->getSlug()]);
				}, $items)
			]
		);
	}

	/**
	 * @Route("/issue/{id}", name="comic_by_id", requirements={"id"="\d+"}, methods={"GET"})
	 */
	public function post($id)
	{
		return $this->json(
			$this->getDoctrine()->getRepository(Issue::class)->find($id)
		);
	}

	/**
	 * @Route("/issue/{slug}", name="comic_by_slug", requirements={"slug"="\w+"}, methods={"GET"})
	 */
	public function postBySlug($slug)
	{
		return $this->json(
			$this->getDoctrine()->getRepository(Issue::class)->findBy(['slug'=>$slug])
		);
	}

	/**
	 * @Route("/add", name="comic_add", methods={"POST"})
	 */
	public function add(Request $request)
	{
		/** @var Serializer $serializer */
		$serializer = $this->get('serializer');

		$comicPost = $serializer->deserialize($request->getContent(), Issue::class, 'json');

		$em = $this->getDoctrine()->getManager();
		$em->persist($comicPost);
		$em->flush();

		return $this->json($comicPost);
	}

}