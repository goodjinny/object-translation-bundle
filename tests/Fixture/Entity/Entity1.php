<?php

namespace Goodjinny\ObjectTranslationBundle\Tests\Fixture\Entity;

use Doctrine\ORM\Mapping as ORM;
use Goodjinny\ObjectTranslationBundle\Mapping\Translatable;
use Goodjinny\ObjectTranslationBundle\Mapping\TranslatableProperty;

#[Translatable('entity1')]
#[ORM\Entity]
class Entity1
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public int $id;

    #[ORM\Column]
    #[TranslatableProperty]
    public string $property1;
}
