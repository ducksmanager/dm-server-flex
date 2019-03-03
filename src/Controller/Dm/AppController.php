<?php
namespace App\Controller\Dm;

use App\Controller\AbstractController;
use App\Entity\Dm\Users;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController// implements RequiresDmUserController
{
    /**
     * @Route(methods={"POST"}, path="/ducksmanager/user/new")
     */
    public function createUser(Request $request): Response {
        $check = $this->checkNewUser(
            $request->request->get('username'),
            $request->request->get('password'),
            $request->request->get('password2')
        );

        if ($check !== true) {
            return new Response($check, Response::HTTP_PRECONDITION_FAILED);
        }

        if ($this->createUserNoCheck(
            $request->request->get('username'),
            $request->request->get('password'),
            $request->request->get('email')
        )) {
            return new Response('OK', Response::HTTP_CREATED);
        }

        return new Response('KO', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    private function checkNewUser(?string $username, string $password, string $password2)
    {
        if (isset($username)) {
            if (strlen($username) <3) {
                return 'UTILISATEUR_3_CHAR_ERREUR';
            }
            if (strlen($password) <6) {
                return 'MOT_DE_PASSE_6_CHAR_ERREUR';
            }
            if ($password !== $password2) {
                return 'MOTS_DE_PASSE_DIFFERENTS';
            }
            if ($this->usernameExists($username)) {
                return 'UTILISATEUR_EXISTANT';
            }
        }
        return true;
    }

    private function usernameExists(string $username): bool
    {
        /** @var EntityManager $dmEm */
        $dmEm = $this->container->get('doctrine')->getManager('dm');
        $existingUser = $dmEm->getRepository(Users::class)->findBy([
            'username' => $username
        ]);
        return count($existingUser) > 0;
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createUserNoCheck(string $username, string $password, string $email): bool
    {
        /** @var EntityManager $dmEm */
        $dmEm = $this->container->get('doctrine')->getManager('dm');

        $user = new Users();
        $user->setUsername($username);
        $user->setPassword(sha1($password));
        $user->setEmail($email);
        $user->setDateinscription(new \DateTime());
        $user->setDernieracces(new \DateTime());

        $dmEm->persist($user);
        $dmEm->flush();

        return true;
    }

}
