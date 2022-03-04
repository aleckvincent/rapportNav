<?php

namespace App\Repository\PAM\Utils;

use App\Entity\Service;
use App\Exception\ServiceNotFound;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class RapportRepositoryUtils {

    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @param QueryBuilder $qb
     * @param string|null  $periode
     * @param string|null  $serviceName
     *
     * @return QueryBuilder
     * @throws ServiceNotFound
     */
    public function handleRequestFiltre(QueryBuilder $qb, ?string $periode, ?string $serviceName): QueryBuilder
    {
        if($periode) {
            switch(true) {
                case $periode === "current":

                    $start = new \DateTime('first day of now');
                    $end = new \DateTime('last day of now');
                    $qb->andWhere('pam_d.start_datetime BETWEEN :start AND :end')
                        ->setParameter('start', $start)
                        ->setParameter('end', $end);
                    break;

                case $periode === '6months':
                    $start = new \DateTime('-6 months');
                    $end = new \DateTime('last day of now');

                    $qb->andWhere('pam_d.start_datetime BETWEEN :first AND :end')
                        ->setParameter('first', $start)
                        ->setParameter('end', $end);
                    break;

                case strpos($periode, 'annee') == 0:
                    $annee = explode('_', $periode)[1];
                    $start = new \DateTime($annee . '-01-01');
                    $end = new \DateTime($annee . '-12-31');
                    $qb->andWhere('pam_d.start_datetime BETWEEN :start AND :end')
                        ->setParameter('start', $start)
                        ->setParameter('end', $end);
                    break;
            }
        }

        if($serviceName && $serviceName !== 'all') {
            $service = $this->em->getRepository(Service::class)->findOneBy(['nom' => $serviceName]);
            if(!$service) {
                throw new ServiceNotFound($serviceName);
            }
            $qb->andWhere('pam_d.created_by = :service')
                ->setParameter('service', $service);
        }

        return $qb;
    }

}
