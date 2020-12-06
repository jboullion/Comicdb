<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

use App\Entity\Issue;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

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
	public function post(Issue $issue)
	{
		return $this->json($issue);
	}

	/**
	 * @Route("/issue/{slug}", name="comic_by_slug", methods={"GET"})
	 * @ParamConverter("issue", options={"mapping": {"slug": "slug"}})
	 */
	public function postBySlug(Issue $issue)
	{
		return $this->json($issue);
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

	/**
	 * @Route("/issue/{slug}", name="comic_delete", methods={"DELETE"})
	 */
	public function delete(Issue $issue)
	{
		$em = $this->getDoctrine()->getManager();

		$em->remove($issue);
		$em->flush();

		return new JsonResponse(null, Response::HTTP_NO_CONTENT);
	}

}