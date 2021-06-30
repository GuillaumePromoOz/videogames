<?php

namespace App\Controller;

use App\Entity\Videogame;
use App\Repository\VideogameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VideogameController extends AbstractController
{
    /**
     * Get all videogames
     * 
     * @Route("/videogames", name="videogames_browse", methods="GET")
     */
    public function browse(VideogameRepository $videogameRepository): Response
    {
        $videogames = $videogameRepository->findAll();

        return $this->json($videogames, 200, [], ['groups' => 'videogames_browse']);
    }

    /**
     * Get one videogame
     * 
     * @Route("/videogames/{id<\d+>}", name="videogames_read", methods="GET")
     */
    public function read(Videogame $videogame): Response
    {
        // checks if item exists
        // if not returns not found status + custom message
        if ($videogame === null) {

            $message = [
                'status' => Response::HTTP_NOT_FOUND,
                'error' => 'Videogame not found',
            ];

            return $this->json($message, Response::HTTP_NOT_FOUND);
        }

        return $this->json($videogame, 200, [], ['groups' => [
            'videogames_browse',
            'videogames_read_item',
        ]]);
    }

    /**
     * Get one videogame's reviews
     * 
     * @Route("/videogames/{id<\d+>}/reviews", name="videogames_read_reviews", methods="GET")
     */
    public function reviewRead(Videogame $videogame): Response
    {
        // checks if item exists
        // if not returns not found status + custom message
        if ($videogame === null) {

            $message = [
                'status' => Response::HTTP_NOT_FOUND,
                'error' => 'Videogame not found',
            ];

            return $this->json($message, Response::HTTP_NOT_FOUND);
        }

        $reviews = $videogame->getReviews();

        return $this->json($reviews, 200, [], ['groups' => [
            'videogames_read_item',
        ]]);
    }

    /**
     * Add videogame
     * 
     * @Route("/videogames", name="videogames_add", methods="POST")
     */
    public function add(Request $request, EntityManagerInterface $entityManager,  SerializerInterface $serializer, ValidatorInterface $validator)
    {
        // We fetch the data sent via method POST into our Symfony Component "Request"
        // the content is in the body of the request
        // the content is stored into variable $jsonContent
        $jsonContent = $request->getContent();

        // We deserialize the JSON content into the User Entity
        // Basically it transforms the json into an object
        $videogame = $serializer->deserialize($jsonContent, Videogame::class, 'json');

        //Generates errors
        $errors = $validator->validate($videogame);
        //returns errors
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // save !
        $entityManager->persist($videogame);
        $entityManager->flush();

        return $this->json('Videogame added', Response::HTTP_CREATED);
    }
}
