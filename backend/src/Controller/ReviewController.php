<?php

namespace App\Controller;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewController extends AbstractController
{
    /**
     * @Route("/reviews", name="review", methods="GET")
     */
    public function browse(ReviewRepository $reviewRepository): Response
    {
        $reviews = $reviewRepository->findAll();

        return $this->json($reviews, 200, [], ['groups' => 'reviews_browse']);
    }

    /**
     * Add review
     * 
     * @Route("/reviews", name="reviews_add", methods="POST")
     */
    public function add(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        //!\ When creating a new review we have to assign it an already existing videogame via its ID
        //!\ however the serializer has no idea that this ID is linked to the Videogame Entity 
        //!\ we resolved this issue inside the Normalizer by indicating that the ID is linked to an existing Entity (@see EntityNormalizer.php)

        // We fetch the data sent via method POST into our Symfony Component "Request"
        // the content is in the body of the request
        // the content is stored into variable $jsonContent
        $jsonContent = $request->getContent();

        // We deserialize the JSON content into the User Entity
        // Basically it transforms the json into an object
        $review = $serializer->deserialize($jsonContent, Review::class, 'json');

        //Generates errors
        $errors = $validator->validate($review);
        //returns errors
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // save !
        $entityManager->persist($review);
        $entityManager->flush();

        return $this->json('Review added', Response::HTTP_CREATED);
    }
}
