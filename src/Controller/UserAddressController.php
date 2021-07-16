<?php


namespace App\Controller;

use App\Services\UserAddressProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
/**
 * Class UserAddressController
 * @package App\Controller
 * @Route("/user")
 */

class UserAddressController extends AbstractController
{
    /**
     * @var UserAddressProcessor
     */
    private $clientProcessor;

    public function __construct(UserAddressProcessor $clientProcessor)
    {
        $this->clientProcessor = $clientProcessor;
    }

    public function getUserAddressProcessor(): UserAddressProcessor
    {
        return $this->clientProcessor;
    }

    /**
     * Получение всех адресов пользователя
     * @Route(path="/address/", methods={"GET"})
     *
     * @return JsonResponse
     * @throws BadRequestHttpException
     * @throws ExceptionInterface
     */
    public function getUserAddress(): JsonResponse
    {
        return $this->json(
            $this->get('serializer')->normalize($this->getUser())
        );
    }

    /**
     * Удаление адреса пользователя
     * @Route("/address/{id}", methods={"DELETE"})
     * @param int $id
     * @return JsonResponse
     */
    public function deleteUserAddress(int $id): JsonResponse
    {
        $this->getUserAddressProcessor()->deleteUserAddress($this->getUser(), $id);

        return $this->json(
            [
                'success' => true
            ]
        );
    }

    /**
     * Добавление пользователю адреса.
     * @Route("/address/", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addUserAddress(Request $request): JsonResponse
    {
        $this->getUserAddressProcessor()->addUserAddress($this->getUser(), $request->request->all());

        return $this->json(
            [
                'success' => true
            ]
        );
    }

    /**
     * Обновления адреса пользователя.
     * @Route("/address/{id}", methods={"PUT"})
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateUserAddress(Request $request, int $id): JsonResponse
    {
        $this->getUserAddressProcessor()->updateUserAddress($request, $this->getUser(), $id);

        return $this->json(
            [
                'success' => true
            ]
        );
    }
}