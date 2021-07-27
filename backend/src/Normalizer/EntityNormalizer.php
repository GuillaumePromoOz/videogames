<?php

// src\Normalizer\EntityNormalizer.php

namespace App\Normalizer;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Entity normalizer
 */
class EntityNormalizer implements DenormalizerInterface
{
    /** @var EntityManagerInterface **/
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * $data = id of corresponding platform and/or videogame in the JSON
     * $type = FQCN (full qualified class name) of the class (server_name.[database_name].[schema_name].object_name)
     * 
     * @inheritDoc
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return strpos($type, 'App\\Entity\\') === 0 && (is_numeric($data));
    }

    /**
     * @inheritDoc
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        // Fetches the entity corresponding to the give ID
        // Doc : This is just a convenient shortcut for getRepository($className)->find($id)
        return $this->em->find($class, $data);
    }
}
