<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Cocur\Slugify\SlugifyInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        // $property =new Property();
        // $property->setTitle('Villa à la campagne')
        //     ->setPrice(250000)
        //     ->setRooms(6)
        //     ->setDescription('c est loin mais on y est bien')
        //     ->setSurface(260)
        //     ->setFloor(0)
        //     ->setHeat(1)
        //     ->setCity('santry sur seine')
        //     ->setBedrooms(2)
        //     ->setAddress('15 rue du paradis')
        //     ->setPostalCode('91250')
        //     ->setIdSeller(3);
        //   $em=  $this->getDoctrine()->getManager(); cree l objet entity manager
        //   $em->persist($property); on le fait persister la propriete
        //   $em->flush(); on envoie en base dedonees

        // $property = $this->repository->findOneby(['floor'=>0]);
        // $property = $this->repository->findAllVisible();
        // $property[0]->setSold(false);
        // dump($property);
        // $this->em->flush(); met a jour la bdd a chacque changement avec l entity manager



        $properties=$paginator->paginate($this->repository->findAllVisibleQuery(),
        $request->query->getInt('page', 1),12);
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties'=>$properties
        ]);
    }


    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @return Response
     */
    // public function show($slug, $id): Response
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        } {
             $property=$this->repository->findAllVisible();
            return $this->render('property/show.html.twig', [
                'property' => $property,
                'current_menu' => 'properties'
            ]);
        }
    }
}
