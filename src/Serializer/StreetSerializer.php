<?php


namespace App\Serializer;

use App\Entity\Street;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class StreetSerializer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    public function supportsNormalization($object, string $format = null)
    {
        return $object instanceof Street;
    }

    /**
     * @param Street $street
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($street, string $format = null, array $context = []): array
    {
        return [
            'id' => $street->getId(),
            'name' => $street->getName()
        ];
    }
}