<?php

namespace App\Repository\PAM;

use App\Entity\PAM\PamDraft;
use App\Entity\PAM\PamIndicateur;
use App\Entity\PAM\PamRapport;
use App\Entity\Service;
use App\Exception\RapportNotFound;
use App\Exception\ServiceNotFound;
use App\Repository\PAM\Utils\RapportRepositoryUtils;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @method PamRapport|null find($id, $lockMode = null, $lockVersion = null)
 * @method PamRapport|null findOneBy(array $criteria, array $orderBy = null)
 * @method PamRapport[]    findAll()
 * @method PamRapport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PamRapportRepository extends ServiceEntityRepository
{

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var RapportRepositoryUtils
     */
    protected $utils;

    public function __construct(ManagerRegistry $registry, TokenStorageInterface $tokenStorage, RapportRepositoryUtils $utils)
    {
        parent::__construct($registry, PamRapport::class);
        $this->tokenStorage = $tokenStorage;
        $this->utils = $utils;
    }

    /**
     * @return PamRapport|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLastRapportID(): ?PamRapport
    {
        return $this->createQueryBuilder('r')
            ->select('r.id')
            ->orderBy('r.created_at', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param \DateTime $firstDate
     * @param \DateTime $lastDate
     * @param bool      $wholeTeams
     *
     * @return PamRapport[]
     */
    public function findByDateRange(\DateTime $firstDate, \DateTime $lastDate, bool $wholeTeams = true): array
    {
        $qb = $this->createQueryBuilder('r')
            ->where('r.start_datetime BETWEEN :firstDate AND :lastDate')
            ->setParameter('firstDate', $firstDate)
            ->setParameter('lastDate', $lastDate);

        if(!$wholeTeams) {
            $qb->andWhere('r.created_by = :service')
                ->setParameter('service', $this->tokenStorage->getToken()->getUser()->getService());
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @param string|null $periode
     * @param string|null $serviceName
     *
     * @return PamDraft[]
     * @throws \Exception
     */
    public function filter(?string $periode, ?string $serviceName): array
    {
        $qb = $this->createQueryBuilder('pam_d');
        return $this->utils->handleRequestFiltre($qb, $periode, $serviceName)->getQuery()->getResult();
    }
}
