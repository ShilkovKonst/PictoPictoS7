<?php

namespace App\Entity;

use App\Repository\PictogramOthersRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\AssociationOverride;
use Doctrine\ORM\Mapping\AssociationOverrides;
use Doctrine\ORM\Mapping\AttributeOverride;
use Doctrine\ORM\Mapping\AttributeOverrides;
use Doctrine\ORM\Mapping\Column as MappingColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;

#[ORM\Entity(repositoryClass: PictogramOthersRepository::class)]
#[AttributeOverrides([
    new AttributeOverride(
        name: 'id',
        column: new MappingColumn()
    ),
])]
#[AssociationOverrides([
    new AssociationOverride(
        name: 'sentences',
        joinTable: new JoinTable(
            name: 'pictogram_others_sentences',
        ),
        // joinColumns: [new JoinColumn(name: 'pictogramOthers')],
        // inverseJoinColumns: [new JoinColumn(name: 'pictogramOthers')]
    ),
])]
class PictogramOthers extends Pictogram
{
}
