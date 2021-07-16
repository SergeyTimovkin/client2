<?php


namespace App\Serializer;

use App\Entity\User;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserSerializer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    public function supportsNormalization($object, string $format = null)
    {
        return $object instanceof User;
    }

    /**
     * @param User $user
     * @param string|null $format
     * @param array $context
     * @return array
     * @throws ExceptionInterface
     */
    public function normalize($user, string $format = null, array $context = []): array
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'addresses' => $this->normalizer->normalize($user->getAddresses())
        ];
    }
}