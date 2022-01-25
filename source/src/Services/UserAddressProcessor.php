<?php


namespace App\Services;


use App\Entity\Home;
use App\Entity\User;
use App\Entity\UserAddress;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserAddressProcessor
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(EntityManagerInterface $entityManager, ContainerInterface $container)
    {
        $this->entityManager = $entityManager;
        $this->container = $container;
    }

    private function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    private function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @param User $user
     * @param int $userAddressId
     * @return UserAddress
     */
    private function getAddressByUser(User $user, int $userAddressId): UserAddress
    {
        /** @var UserAddress|bool $userAddress */
        $userAddress = $user->getAddresses()->filter(function (UserAddress $userAddress) use ($userAddressId) {
            return $userAddress->getId() === $userAddressId;
        })->current();
        if (!$userAddress) {
            throw new BadRequestHttpException('Адрес не прикреплен к пользователю.');
        }

        return $userAddress;
    }

    /**
     * @param int $homeId
     * @return Home
     */
    private function getHomeById(int $homeId): Home
    {
        /** @var ObjectRepository $homeRepository */
        $homeRepository = $this->getEntityManager()->getRepository(Home::class);
        /** @var Home|null $home */
        $home = $homeRepository->find($homeId);
        if (!$home) {
            throw new BadRequestHttpException('Дома с данным id не найден.');
        }

        return $home;
    }

    /**
     * @param User $user
     * @param int $userAddressId
     */
    public function deleteUserAddress(User $user, int $userAddressId): void
    {
        $user->removeAddress($this->getAddressByUser($user, $userAddressId));
        $this->getEntityManager()->flush();
    }

    /**
     * @param User $user
     * @param array $userAddressParams
     */
    public function addUserAddress(User $user, array $userAddressParams): void
    {
        if (!isset($userAddressParams['homeId'])) {
            throw new BadRequestHttpException('Не передан id дома.');
        }
        $this->getEntityManager()->persist(
            (new UserAddress())
                ->setUser($user)
                ->setHome($this->getHomeById($userAddressParams['homeId']))
                ->setPorch($userAddressParams['porch'] ?? null)
                ->setFloor($userAddressParams['floor'] ?? null)
                ->setIntercom($userAddressParams['intercom'] ?? null)
                ->setApartment($userAddressParams['apartment'] ?? null)
        );
        $this->getEntityManager()->flush();
    }

    /**
     * @param Request $request
     * @param User $user
     * @param int $userAddressId
     */
    public function updateUserAddress(Request $request, User $user, int $userAddressId): void
    {
        /** @var UserAddress $userAddress */
        $userAddress = $this->getAddressByUser($user, $userAddressId);

        if ($request->get('homeId')) {
            $userAddress->setHome($this->getHomeById($request->get('homeId')));
        }
        if ($request->get('porch')) {
            $userAddress->setPorch($request->get('porch'));
        }
        if ($request->get('floor')) {
            $userAddress->setFloor($request->get('floor'));
        }
        if ($request->get('intercom')) {
            $userAddress->setIntercom($request->get('intercom'));
        }
        if ($request->get('apartment')) {
            $userAddress->setApartment($request->get('apartment'));
        }

        $this->getEntityManager()->flush();
    }


}