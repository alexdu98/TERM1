<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Historique;
use UserBundle\Form\MembreConnexionType;
use UserBundle\Form\MembreInscriptionType;
use UserBundle\Form\MembreOubliPassResetType;
use UserBundle\Form\MembreOubliPassType;

class SecurityController extends Controller
{

    public function connexionAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_accueil');
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        //créer l'objet membre
        $membre = new \UserBundle\Entity\Membre();

        //ajout des attributs qu'on veut afficher dans le formulaire
        $form = $this->get('form.factory')->create(MembreConnexionType::class, $membre);

        return $this->render('UserBundle:Security:connexion.html.twig', array(
            'form' => $form->createView(),
            'last_username' => $authenticationUtils->getLastUsername(),
            'erreur' => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

    public function inscriptionAction(Request $request, $provider = NULL)
    {
        //créer l'objet membre
        $membre = new \UserBundle\Entity\Membre();

        //ajout des attributs qu'on veut afficher dans le formulaire
	    $form = $this->get('form.factory')->create(MembreInscriptionType::class, $membre);

        // Si la requête est en POST
        if ($request->isMethod('POST')) {

            // FACEBOOK & TWITTER
            if (!empty($provider)) {
                $res = new \stdClass();
                $res->succes = false;

                // Récupère les données du formulaire
                $data = json_decode($request->get('data'));

                // Vérifie qu'il n'est pas déjà inscrit
                $repoUser = $this->getDoctrine()->getManager()->getRepository('UserBundle:Membre');
                //$membre = null;

                if ($provider == "facebook") {
                    $membreFound = $repoUser->findOneByIdFacebook($data->id);
                   if ($membreFound != null){
                       $membre=$membreFound;
                   }
                    $email = $data->id."@facebook.com";
                } else if ($provider == "twitter") {

                } else {
                    $res->messages[] = 'Provider inconnu';
                }
                $membre->setIdFacebook($data->id);
                $membre->setPseudo($data->id); // pseudo c'est id facebook dans un 1er temp
                $membre->setEmail($email); // email : id@facebook.com
                $sexe = $data->gender == "male" ? "Homme" : "Femme";
                $membre->setSexe($sexe);
                $membre->setActif(true);

                // Affecte le nouveau membre à un groupe
                $repository = $this->getDoctrine()->getManager()->getRepository('UserBundle:Groupe');
                $grp = $repository->findOneByNom('Membre');
                $membre->setGroupe($grp);

                // Affecte un niveau au nouveau membre
                $repository = $this->getDoctrine()->getManager()->getRepository('UserBundle:Niveau');
                $grp = $repository->findOneByTitre('Facile');
                $membre->setNiveau($grp);

                $validator = $this->get('validator');
                $erreurs = $validator->validate($membre);

                if (count($erreurs) > 0) {
                    $messages = array();
                    foreach ($erreurs as $erreur) {
                        $messages[] = $erreur->getPropertyPath() . " : " . $erreur->getMessage();
                    }
                    return $this->json(array(
                        'nb' => count($erreurs),
                        'erreur' => $messages
                    ));
                }

                $em = $this->getDoctrine()->getManager();
                try {
                    $em->persist($membre);
                    $em->flush();
                } catch (\Exception $e) {
                    return $this->json(array(
                        'erreur' => $e
                    ));
                }

                return $this->json(array(
                    'data' => $request->get('data')
                ));
            } // AMBIGUSS
            else {
                $recaptcha = $this->get('app.recaptcha');
                $recap = $recaptcha->check($request->request->get('g-recaptcha-response'));
                if ($recap->succes) {
                    $form->handleRequest($request);
                    if ($form->isValid()) {
                        $membre = $form->getData();
                        // Hash le Mdp
                        $encoder = $this->get('security.password_encoder');
                        $hash = $encoder->encodePassword($membre, $membre->getMdp());

                        $membre->setMdp($hash);

                        // Affecte le nouveau membre à un groupe
                        $repository = $this->getDoctrine()->getManager()->getRepository('UserBundle:Groupe');
                        $grp = $repository->findOneByNom('Membre');
                        $membre->setGroupe($grp);

                        // Affecte un niveau au nouveau membre
                        $repository = $this->getDoctrine()->getManager()->getRepository('UserBundle:Niveau');
                        $grp = $repository->findOneByTitre('Facile');
                        $membre->setNiveau($grp);

                        // Génère la clé pour la confirmation d'email et l'enregistre dans le champ cleOubliMdp
                        $cleConfirmation = $membre->generateCle();

                        // On enregistre dans l'historique du joueur
                        $histJoueur = new Historique();
                        $histJoueur->setValeur("Inscription via Ambiguss.");
                        $histJoueur->setMembre($membre);

                        // On enregistre le membre dans la base de données
                        $em = $this->getDoctrine()->getManager();

                        $em->persist($membre);
                        $em->persist($histJoueur);

                        try {
                            $em->flush();
                        } catch (\Exception $e) {
                            $this->get('session')->getFlashBag()->add('erreur', "Erreur lors de l'insertion du membre");
                        }

                        // Envoi de l'email confimation/validation
                        $message = \Swift_Message::newInstance()->setSubject("[Ambiguss] Confirmation d'inscription")->setFrom(array(
                            "no-reply@ambiguss.calyxe.fr" => "Ambiguss"
                        ))->setTo(array(
                            $membre->getEmail() => $membre->getPseudo()
                        ))->setBody($this->renderView('emails/inscription.html.twig', array(
                            'titre' => "Confirmation d'inscription",
                            'pseudo' => $membre->getPseudo(),
                            'cleConfirmation' => $cleConfirmation
                        )), 'text/html');

                        if ($this->get('mailer')->send($message)) {
                            $this->get('session')->getFlashBag()->add('succes', 'Inscription réussie, veuillez cliquer sur le lien de confirmation envoyé par email.');
                        } else {
                            $this->get('session')->getFlashBag()->add('erreur', "Inscription réussie, mais l'envoi de
		                l'email de confirmation a échoué. Contactez un administrateur.");
                        }

                        // rediriger vers la page de connexion
                        return $this->redirectToRoute('user_connexion');
                    }
                } else {
                    $erreurStr = "";
                    foreach ($recap->erreurs as $erreur) {
                        $erreurStr .= $erreur;
                    }
                    $this->get('session')->getFlashBag()->add('erreur', $erreurStr);
                }
            }
        }
        // Pas de formulaire envoyé ou erreur
        return $this->render('UserBundle:Security:inscription.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function inscriptionConfirmationAction(Request $request, \UserBundle\Entity\Membre $membre)
    {
        $membre->setCleOubliMdp(NULL);
        $membre->setActif(true);

        // On enregistre dans l'historique du joueur
        $histJoueur = new Historique();
        $histJoueur->setValeur("Confirmation d'inscription.");
        $histJoueur->setMembre($membre);

        $em = $this->getDoctrine()->getManager();
        $em->persist($membre);
        $em->persist($histJoueur);
        $em->flush();

        $this->get('session')->getFlashBag()->add('succes', "Inscription confirmée. Vous pouvez maintenant vous connecter.");

        // rediriger vers la page de connexion
        return $this->redirectToRoute('user_connexion');
    }

    public function oubliMdpAction(Request $request)
    {
        $form = $this->get('form.factory')->create(MembreOubliPassType::class);

        // Si la requête est en POST
        if ($request->isMethod('POST')) {
            $recaptcha = $this->get('app.recaptcha');
            $recap = $recaptcha->check($request->request->get('g-recaptcha-response'));
            if ($recap->succes) {
                $form->handleRequest($request);
                if ($form->isValid()) {

                    $repository = $this->getDoctrine()->getManager()->getRepository('UserBundle:Membre');
                    $membre = $repository->getOneByPseudoOrEmail($request->request->get('userbundle_membre')['PseudoOuEmail']);

                    // Génère la clé pour la réinitialisation de mot de passe et l'enregistre dans le champ cleOubliMdp
                    $cleConfirmation = $membre->generateCle();

                    // On enregistre dans l'historique du joueur
                    $histJoueur = new Historique();
                    $histJoueur->setValeur("Demande de réinitialisation du mot de passe (IP : " . $_SERVER['REMOTE_ADDR'] . ").");
                    $histJoueur->setMembre($membre);

                    // On enregistre le membre dans la base de données
                    $em = $this->getDoctrine()->getManager();

                    $em->persist($membre);
                    $em->persist($histJoueur);

                    try {
                        $em->flush();
                    } catch (\Exception $e) {
                        $this->get('session')->getFlashBag()->add('erreur', "Erreur lors de la mise à jour du membre");
                    }

                    // Envoi de l'email confimation/validation
                    $message = \Swift_Message::newInstance()->setSubject("[Ambiguss] Réinitialisation de mot de passe")->setFrom(array(
                        "no-reply@ambiguss.calyxe.fr" => "Ambiguss"
                    ))->setTo(array(
                        $membre->getEmail() => $membre->getPseudo()
                    ))->setBody($this->renderView('emails/oubli_mdp.html.twig', array(
                        'titre' => "Réinitialisation de mot de passe",
                        'pseudo' => $membre->getPseudo(),
                        'cleConfirmation' => $cleConfirmation
                    )), 'text/html');

                    if ($this->get('mailer')->send($message)) {
                        $this->get('session')->getFlashBag()->add('succes', 'Veuillez cliquer sur le lien de réinitialisation de mot de passe envoyer par email.');
                    } else {
                        $this->get('session')->getFlashBag()->add('erreur', "L'envoi de
		                l'email de réinitialisation de mot de passe a échoué. Contactez un administrateur.");
                    }

                    // rediriger vers la page de connexion
                    return $this->render('UserBundle:Security:oubli_mdp.html.twig', array(
                        'form' => $form->createView()
                    ));
                }
            } else {
                $erreurStr = "";
                foreach ($recap->erreurs as $erreur) {
                    $erreurStr .= $erreur;
                }
                $this->get('session')->getFlashBag()->add('erreur', $erreurStr);
            }
        }

        return $this->render('UserBundle:Security:oubli_mdp.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function oubliMdpReinitialisationAction(Request $request, \UserBundle\Entity\Membre $membre)
    {
        $form = $this->get('form.factory')->create(MembreOubliPassResetType::class);

        // Si la requête est en POST
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $data = $form->getData();
            if ($form->isValid()) {
                // Hash le Mdp
                $encoder = $this->get('security.password_encoder');
                $hash = $encoder->encodePassword($membre, $data->getMdp());

                $membre->setMdp($hash);
                $membre->setCleOubliMdp(NULL);

                // On enregistre dans l'historique du joueur
                $histJoueur = new Historique();
                $histJoueur->setValeur("Réinitialisation du mot de passe (IP : " . $_SERVER['REMOTE_ADDR'] . ").");
                $histJoueur->setMembre($membre);

                // On enregistre le membre dans la base de données
                $em = $this->getDoctrine()->getManager();

                $em->persist($membre);
                $em->persist($histJoueur);

                try {
                    $em->flush();
                } catch (\Exception $e) {
                    $this->get('session')->getFlashBag()->add('erreur', "Erreur lors de la mise à jour du membre");
                }

                $this->get('session')->getFlashBag()->add('succes', 'Votre mot de passe a bien été modifié.');

                // rediriger vers la page de connexion
                return $this->redirectToRoute('user_connexion');
            }
        }

        return $this->render('UserBundle:Security:oubli_mdp_reinitialisation.html.twig', array(
            'form' => $form->createView()
        ));
    }
}