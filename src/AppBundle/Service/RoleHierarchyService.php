<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Component\Security\Core\Role\RoleInterface;

class RoleHierarchyService implements RoleHierarchyInterface
{
    private $em;
    protected $map;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->buildRoleMap();
    }

    /**
     * Trouve tous les rôles accessible via les rôles donnés
     * et les retourne
     *
     * @param array $roles
     * @return array|RoleInterface[]
     */
    public function getReachableRoles(array $roles)
    {
        $reachable = array();
        while($role = array_shift($roles)){
            if(isset($this->map[$role->getRole()])){
                foreach ($this->map[$role->getRole()] as $sub){
                    $new = new Role($sub);
                    $reachable[] = $new;
                    if(!in_array($sub, $reachable))
                        array_push($roles, $new);
                }
            }
        }
        return $reachable;
    }

    /**
     * Construit le tableau de hiérarchie des rôles et le retourne
     *
     * @return array
     */
    protected function buildRoleMap()
    {
        $this->map = array();
        $roles = $this->em->getRepository('AppBundle:Role')->findAll();
        foreach ($roles as $role) {
            if ($role->getParent()) {
                if (!isset($this->map[$role->getParent()->getName()])) {
                    $this->map[$role->getParent()->getName()] = array();
                }
                $this->map[$role->getParent()->getName()][] = $role->getName();
            } else {
                if (!isset($this->map[$role->getName()])) {
                    $this->map[$role->getName()] = array();
                }
            }
        }
        return $this->map;
    }

}
