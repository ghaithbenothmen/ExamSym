<?php

namespace App\Controller;
use App\Entity\Vote;
use App\Form\VoteType;
use App\Repository\JoueurRepository;
use App\Repository\VoteRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class JoueurController extends AbstractController
{
    #[Route('/joueur', name: 'app_joueur_list')]
    public function listJoueur(JoueurRepository $repository): Response
    {
        $listeJoueurs = $repository->findBy(array(),array('nom' => 'ASC'));


        return $this->render('joueur/index.html.twig', [
            'controller_name' => 'JoueurController',
            'joueur'=>$listeJoueurs,
        ]);
    }

    #[Route('/vote', name: 'app_joueur_vote')]
    public function voterJoueur(JoueurRepository $repo,Request $request,ManagerRegistry $manager,JoueurRepository $repository): Response
    {

        $vote=new Vote();
        $form=$this->createForm(VoteType::class,$vote);
        $form->handleRequest($request);


        if($form->isSubmitted()){
            $vote->setDate(new DateTime());
            $noteVote=$vote->getNoteVote();
            $joueurVote=$vote->getJoueur();
            $manager->getManager()->persist($vote);
            $manager->getManager()->flush();
            
            $joueurVote->setMoyenneVote(($repo->getSommeVoteByJoueur($vote->getJoueur()->getId()))/( $joueurVote->getvotes()->count()));
            
            $manager->getManager()->flush();

        return $this->redirectToRoute('app_joueur_list');
        }
        
        
        return $this->render('vote/vote.html.twig', [
            'controller_name' => 'JoueurController',
            'f'=>$form->createView(),   
        ]);
    }

    #[Route('/joueur/{id}', name: 'app_joueur_details')]
    public function detailJoueur($id ,JoueurRepository $repo,VoteRepository $repoVote): Response
    {  
        $votes = $repoVote->getVotesByJoueur($id);


        $joueur=$repo->find($id);
        return $this->render('joueur/show.html.twig', [
        'controller_name' => 'JoueurController','joueur'=>$joueur,'votes'=>$votes
    ]);
    }

    #[Route('/joueur/delete/{id}', name:'app_joueur_delete')]
    public function deleteAuthor($id,ManagerRegistry $manager ,JoueurRepository $repo){
       $joueur=$repo->find($id);
       $manager->getManager()->remove($joueur);
       $manager->getManager()->flush();
       return $this->redirectToRoute('app_joueur_list');
    }


}
