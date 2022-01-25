<?php


namespace App\Serializer;

use App\Entity\City;
use App\Entity\UserAddress;
use App\Entity\Region;
use App\Entity\Street;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class AddressSerializer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    public function supportsNormalization($object, string $format = null)
    {
        return $object instanceof UserAddress;
    }

    /**
     * @param UserAddress $userAddress
     * @param string|null $format
     * @param array $context
     * @return array
     * @throws ExceptionInterface
     */
    public function normalize($userAddress, string $format = null, array $context = []): array
    {
        /** @var Street|null $street */
        $street = null;
        if ($userAddress->getHome()) {
            $street = $userAddress->getHome()->getStreet();
        }
        /** @var City|null $city */
        $city = null;
        if ($street) {
            $city = $street->getCity();
        }
        /** @var Region|null $region */
        $region = null;
        if ($city) {
            $region = $city->getRegion();
        }

        return [
            'id' => $userAddress->getId(),
            'region' => $this->normalizer->normalize($region),
            'city' => $this->normalizer->normalize($city),
            'street' => $this->normalizer->normalize($street),
            'home' => $this->normalizer->normalize($userAddress->getHome()),
            'porch' => $userAddress->getPorch(),
            'floor' => $userAddress->getFloor(),
            'intercom' => $userAddress->getIntercom(),
            'apartment' => $userAddress->getApartment(),
        ];
    }
}