<?php

namespace BM\ApiBundle\Controller;

use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\Serializer\SerializationContext;

class ArticleController extends Controller
{
    /**
     * @ApiDoc(
     *     resource=true,
     *     description="Voir la liste des articles.",
     *     section="Articles",
     *     output="BM\ApiBundle\Entity\Article",
     *     statusCodes={
     *         200="Retourné lorsque réussi.",
     *         401="L'authentification a échoué."
     *     },
     *     tags={"Require access_token"}
     * )
     * @Rest\View(StatusCode=Response::HTTP_OK)
     */
    public function getArticlesAction()
    {
        $articles = $this->getDoctrine()->getRepository('BMApiBundle:Article')->findAll();
        $data = $this->get('jms_serializer')->serialize($articles, 'json', SerializationContext::create()->setGroups(array('list')));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     description="Voir un article.",
     *     section="Articles",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="Identifiant unique d'un article"
     *          }
     *     },
     *     output="BM\ApiBundle\Entity\Article",
     *     statusCodes={
     *         200="Retourné lorsque réussi.",
     *         401="L'authentification a échoué.",
     *         404="Retourné lorsque non trouvé."
     *     },
     *     tags={"Require access_token"}
     * )
     * @Rest\View(StatusCode=Response::HTTP_OK)
     */
    public function getArticleAction($id)
    {
        $article = $this->getDoctrine()->getRepository('BMApiBundle:Article')->find($id);

        if(empty($article)){
            return View::create(array('message' => 'Article non trouvé'), Response::HTTP_NOT_FOUND);
        }

        $data = $this->get('jms_serializer')->serialize($article, 'json', SerializationContext::create()->setGroups(array('detail')));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
