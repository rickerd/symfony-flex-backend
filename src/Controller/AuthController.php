<?php
declare(strict_types=1);
/**
 * /src/Controller/AuthController.php
 *
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
namespace App\Controller;

use App\Entity\User;
use App\Security\RolesInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class AuthController
 *
 * @Route(
 *      path="/auth",
 *  )
 *
 * @package App\Controller
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
class AuthController
{
    /**
     * Action to get user's Json Web Token (JWT) for authentication.
     *
     * Note that the security layer will intercept this request.
     *
     * @Route("/getToken");
     * @Method("POST")
     *
     * @return Response
     *
     * @throws \InvalidArgumentException
     */
    public function getTokenAction(): Response
    {
        return new Response('', 405);
    }

    /**
     * Action to get current user profile data.
     *
     * @Method("GET")
     *
     * @Route("/profile");
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @param UserInterface|User  $user
     * @param RolesInterface      $roles
     * @param SerializerInterface $serializer
     *
     * @return JsonResponse
     *
     * @throws \InvalidArgumentException
     */
    public function profileAction(
        UserInterface $user,
        RolesInterface $roles,
        SerializerInterface $serializer
    ): JsonResponse
    {
        // Specify used serialization groups
        static $groups = [
            'User',
            'User.userGroups',
            'User.roles',
            'UserGroup',
            'UserGroup.role',
        ];

        // Set roles service to user entity, so we can get inherited roles
        $user->setRolesService($roles);

        // Create response
        return new JsonResponse(
            $serializer->serialize($user, 'json', ['groups' => $groups]),
            200,
            [],
            true
        );
    }
}
