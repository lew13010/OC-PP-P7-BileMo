<?php

namespace BM\ApiBundle\Controller;

use BM\UserBundle\Form\RegistrationType;
use FOS\RestBundle\View\View;
use BM\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\Serializer\SerializationContext;

class UserController extends Controller
{
    /**
     * @ApiDoc(
     *     resource=true,
     *     description="Voir la liste des utilisateurs.",
     *     section="Utilisateurs",
     *     output="BM\UserBundle\Entity\User",
     *     statusCodes={
     *         200="Retourné lorsque réussi.",
     *         401="L'authentification a échoué."
     *     },
     *     tags={"Require access_token"}
     * )
     * @Rest\View(StatusCode=Response::HTTP_OK)
     */
    public function getUsersAction()
    {
        $users = $this->getDoctrine()->getRepository('BMUserBundle:User')->findAll();
        $data = $this->get('jms_serializer')->serialize($users, 'json', SerializationContext::create()->setGroups(array('list')));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     description="Voir un utilisateur.",
     *     section="Utilisateurs",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="Identifiant unique d'un utilisateur"
     *          }
     *     },
     *     output="BM\UserBundle\Entity\User",
     *     statusCodes={
     *         200="Retourné lorsque réussi.",
     *         404="Retourné lorsque non trouvé.",
     *         401="L'authentification a échoué."
     *     },
     *     tags={"Require access_token"}
     * )
     * @Rest\View(StatusCode=Response::HTTP_OK)
     */
    public function getUserAction($id)
    {
        $user = $this->getDoctrine()->getRepository('BMUserBundle:User')->find($id);

        if(empty($user)){
            return View::create(array('message' => 'Utilisateur non trouvé'), Response::HTTP_NOT_FOUND);
        }

        $data = $this->get('jms_serializer')->serialize($user, 'json', SerializationContext::create()->setGroups(array('detail')));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @ApiDoc(
     *     description="Création d'un utilisateur.",
     *     section="Utilisateurs",
     *     input={
     *         "class"="BM\UserBundle\Form\RegistrationFormType",
     *         "name"=""
     *     },
     *     requirements={
     *          {
     *              "name"="email",
     *              "dataType"="email",
     *              "description"="Adresse Email valide."
     *          },
     *          {
     *              "name"="username",
     *              "dataType"="string",
     *              "description"="Nom d'utilisateur."
     *          },
     *          {
     *              "name"="plainPassword",
     *              "dataType"="string",
     *              "description"="Mot de passe."
     *          }
     *     },
     *     statusCodes={
     *         201="Retourné losque l'utilisateur a été créé.",
     *         400="Retourné lors d'une erreur."
     *     },
     * )
     * @Rest\View()
     */
    public function postUsersAction(Request $request)
    {
        if(!$this->get('bm_user.services.registration')->registerUser($request)){
            return new JsonResponse(array('Utilisateur' => 'Cet utilisateur est déja enregistré'), JsonResponse::HTTP_CONFLICT);
        }

        $clientManager = $this->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris(array('bilemo.loc'));
        $client->setAllowedGrantTypes(array('password', 'refresh_token'));
        $clientManager->updateClient($client);

        return new JsonResponse(array('Utilisateur' => 'Créé', 'Vos_identifiants' => array('client_id' => $client->getPublicId(), 'client_secret' => $client->getSecret())), JsonResponse::HTTP_CREATED);
    }
}
