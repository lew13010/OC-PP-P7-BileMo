<?php

namespace BM\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="BM\UserBundle\Repository\UserRepository")
 * /**

 * @UniqueEntity(fields={"email"}, message="Cet email est déjà enregistré")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href = "expr('/api/users/' ~ object.getId())",
 *     exclusion =
 *     @Hateoas\Exclusion(groups={"list"})
 * )
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({"list", "detail"})
     */
    protected $id;

    /**
     * @Serializer\Groups({"list", "detail"})
     */
    protected $username;

    /**
     * @Serializer\Groups({"detail"})
     */
    protected $email;

    /**
     * @Serializer\Groups({"detail"})
     */
    protected $roles;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
