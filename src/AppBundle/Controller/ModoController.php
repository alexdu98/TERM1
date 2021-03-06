<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Glose;
use AppBundle\Entity\Historique;
use AppBundle\Entity\Signalement;
use AppBundle\Entity\Membre;
use AppBundle\Entity\Phrase;
use AppBundle\Event\AmbigussEvents;
use AppBundle\Form\Glose\GloseAddType;
use AppBundle\Form\Glose\GloseEditType;
use AppBundle\Form\Membre\MembreEditType;
use AppBundle\Form\Phrase\PhraseEditType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

class ModoController extends Controller
{

    public function showGlosesAction()
    {
        $repoG = $this->getDoctrine()->getManager()->getRepository('AppBundle:Glose');
        $gloses = $repoG->findAll();

        $glose = new Glose();
        $editGloseForm = $this->get('form.factory')->create(GloseEditType::class, $glose, array(
            'action' => $this->generateUrl('modo_glose_edit', array('id' => 0)),
        ));

        return $this->render('AppBundle:Moderation:Glose/list.html.twig', array(
            'gloses' => $gloses,
            'editGloseForm' => $editGloseForm->createView(),
        ));
    }

    public function editGloseAction(Request $request, Glose $glose)
    {
        $gloseO = clone $glose;
        $form = $this->createForm(GloseEditType::class, $glose);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $historiqueService = $this->container->get('AppBundle\Service\HistoriqueService');

            $repoG = $em->getRepository('AppBundle:Glose');
            $repoR = $em->getRepository('AppBundle:Reponse');

            // Récupère la glose avec la valeur que l'on veut insert
            $gloseM = $repoG->findOneBy(array(
                'valeur' => $glose->getValeur(),
            ));

            // Si la nouvelle valeur de la glose existe déjà et que ce n'est pas la même glose
            if ($gloseM && $gloseM->getId() != $glose->getId()) {
                // Récupère les réponses de la glose en cours de modification
                $reponses = $repoR->findBy(array(
                    'glose' => $glose->getId(),
                ));

                // Modifie les réponses de la glose en cours de modification par celle qui existe déjà
                foreach ($reponses as $reponse) {
                    $reponse->setGlose($gloseM);
                    $em->persist($reponse);
                }

                // Ajoute les liaisons motAmbigu-Glose de la glose que l'on modifie à celle qui existe déjà
                foreach ($glose->getMotsAmbigus() as $motAmbigu) {
                    // Si la glose qui existe déjà n'est pas déjà liée au mot ambigu
                    if (!$gloseM->getMotsAmbigus()->contains($motAmbigu)) {
                        $motAmbigu->addGlose($gloseM);
                        $em->persist($motAmbigu);
                    }
                }

                // On enregistre dans l'historique du modérateur
                $histo = "Fusion de la glose #{$glose->getId()} ({$glose->getValeur()}) => #{$gloseM->getId()} ({$gloseM->getValeur()}).";
                $historiqueService->save($this->getUser(), $histo, false, true);

                // Supprime la glose
                $em->remove($glose);
            }
            // Si la nouvelle valeur de la glose n'existe pas, on enregistre les modifications
            else {
                $infos = array();
                if($gloseO->getValeur() != $glose->getValeur()){
                    $infos[] = "valeur : {$gloseO->getValeur()} => {$glose->getValeur()}";
                }
                if($gloseO->getSignale() != $glose->getSignale()){
                    $oldSignale = $gloseO->getSignale() == false ? 'non' : 'oui';
                    $newSignale = $glose->getSignale() == false ? 'non' : 'oui';
                    $infos[] = "signalé : {$oldSignale} => {$newSignale}";
                }
                if($gloseO->getVisible() != $glose->getVisible()){
                    $oldVisible = $gloseO->getVisible() == false ? 'non' : 'oui';
                    $newVisible = $glose->getVisible() == false ? 'non' : 'oui';
                    $infos[] = "visible : {$oldVisible} => {$newVisible}";
                }


                // On enregistre dans l'historique du modérateur
                $histo ="Modification de la glose #" . $glose->getId() . ' (' . implode(', ', $infos) . ").";
                $historiqueService->save($this->getUser(), $histo, false, true);

                $em->persist($glose);
            }

            if (!empty($gloseM)) {
                $glose = $gloseM;
            }

            // Mise à jour de la glose fusionnée
            $glose->setModificateur($this->getUser());
            $glose->setDateModification(new \DateTime());
            $em->persist($glose);

            $em->flush();

            $res = array(
                'id' => $glose->getId(),
                'valeur' => $glose->getValeur(),
                'modificateurID' => $glose->getModificateur() != null ? $glose->getModificateur()->getId() : '',
                'modificateur' => $glose->getModificateur() != null ? $glose->getModificateur()->getUsername() : '',
                'dateModification' => $glose->getDateModification() != null ? $glose->getDateModification()->format('d/m/Y H:i') : '',
                'dateModificationTS' => $glose->getDateModification() != null ? $glose->getDateModification()->format('U') + $glose->getDateModification()->format('Z') : '',
                'visible' => $glose->getVisible(),
                'signale' => $glose->getSignale()
            );

            return $this->json(array(
                'succes' => true,
                'glose' => $res,
            ));

        }

        throw $this->createNotFoundException();
    }

    public function showPhrasesAction()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Phrase');
        $phrases = $repo->findAll();

        return $this->render('AppBundle:Moderation:Phrase/list.html.twig', array(
            'phrases' => $phrases,
        ));
    }

    public function showMembresAction()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Membre');
        $membres = $repo->findAll();

        $membre = new Membre();
        $editMembreForm = $this->createForm(MembreEditType::class, $membre, array(
            'action' => $this->generateUrl('modo_membre_edit', array('id' => 0)),
        ));

        return $this->render('AppBundle:Moderation:Membre/list.html.twig', array(
            'membres' => $membres,
            'editMembreForm' => $editMembreForm->createView(),
        ));
    }

    public function editMembreAction(Request $request, Membre $membre)
    {
        $membreO = clone $membre;
        $form = $this->createForm(MembreEditType::class, $membre);

        $form->handleRequest($request);

        $succes = false;
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $historiqueService = $this->container->get('AppBundle\Service\HistoriqueService');

            $infos = array();
            if($membreO->getSignale() != $membre->getSignale()){
                $oldSignale = $membreO->getSignale() == false ? 'non' : 'oui';
                $newSignale = $membre->getSignale() == false ? 'non' : 'oui';
                $infos[] = "signalé : {$oldSignale} => {$newSignale}";
            }
            if($membreO->getRenamable() != $membre->getRenamable()){
                $oldRenomable = $membreO->getRenamable() == false ? 'non' : 'oui';
                $newRenomable = $membre->getRenamable() == false ? 'non' : 'oui';
                $infos[] = "renomable : {$oldRenomable} => {$newRenomable}";
            }
            if($membreO->getBanni() != $membre->getBanni()){
                $oldBanni = $membreO->getBanni() == false ? 'non' : 'oui';
                $newBanni = $membre->getBanni() == false ? 'non' : 'oui';
                $infos[] = "banni : {$oldBanni} => {$newBanni}";
            }
            if($membreO->getDateDeban() != $membre->getDateDeban()){
                $oldDateDeban = $membreO->getDateDeban() ? $membreO->getDateDeban()->format('d/m/Y H:i') : '';
                $newDateDeban = $membre->getDateDeban() ? $membre->getDateDeban()->format('d/m/Y H:i') : '';
                $infos[] = "date deban : {$oldDateDeban} => {$newDateDeban}";
            }
            if($membreO->getCommentaireBan() != $membre->getCommentaireBan()){
                $infos[] = "commentaire ban : {$membreO->getCommentaireBan()} => {$membre->getCommentaireBan()}";
            }

            // On enregistre dans l'historique du modérateur
            $histo ="Modification du membre #" . $membre->getId() . ' (' . implode(', ', $infos) . ").";
            $historiqueService->save($this->getUser(), $histo, false, true);

            $em->persist($membre);
            $em->flush();

            $succes = true;
        }

        $res = array(
            'id' => $membre->getId(),
            'banni' => $membre->getBanni(),
            'comBan' => $membre->getCommentaireBan(),
            'dateDeban' => $membre->getDateDeban() != null ? $membre->getDateDeban()->format('d/m/Y H:i') : '',
            'dateDebanTS' => $membre->getDateDeban() != null ? $membre->getDateDeban()->format('U') + $membre->getDateDeban()->format('Z') : '',
            'renomable' => $membre->getRenamable(),
            'signale' => $membre->getSignale()
        );

        return $this->json(array(
            'succes' => $succes,
            'membre' => $res
        ));
    }

    public function showMembreSignalementsAction($id)
    {
        $repoJ = $this->getDoctrine()->getManager()->getRepository('AppBundle:Signalement');
        $repoTO = $this->getDoctrine()->getManager()->getRepository('AppBundle:TypeObjet');

        $typeObj = $repoTO->findOneBy(array('nom' => 'Membre'));
        $signalements = $repoJ->findBy(array(
            'typeObjet' => $typeObj,
            'verdict' => null,
            'objetId' => $id,
        ));

        return $this->json(array(
            'succes' => true,
            'signalements' => $signalements,
        ));
    }

    public function showMotsAmbigusGlosesAction()
    {
        return $this->render('AppBundle:Moderation:MAG/searchAndRemove.html.twig');
    }

    public function deleteMotsAmbigusGlosesAction(Request $request)
    {
        $data = $request->request->all();

        if ($this->isCsrfTokenValid('delete_mag', $data['token'])) {
            $succes = false;
            $message = null;

            if (!empty($data['motAmbigu']) && !empty($data['glose'])) {
                $em = $this->getDoctrine()->getManager();
                $historiqueService = $this->container->get('AppBundle\Service\HistoriqueService');

                $repMA = $em->getRepository('AppBundle:MotAmbigu');
                $repG = $em->getRepository('AppBundle:Glose');

                $ma = $repMA->find($data['motAmbigu']);
                $g = $repG->find($data['glose']);

                $ma->removeGlose($g);

                // On enregistre dans l'historique du modérateur
                $histo ="Suppression de la liaison entre le mot ambigu #{$ma->getId()} ({$ma->getValeur()}) et la glose #{$g->getId()} ({$g->getValeur()}).";
                $historiqueService->save($this->getUser(), $histo, false, true);

                $em->persist($ma);
                $em->flush();

                $succes = true;
            } else {
                $message = "Tous les champs ne sont pas remplis";
            }

            return $this->json(array(
                'succes' => $succes,
                'message' => $message,
            ));
        }

        throw new InvalidCsrfTokenException();
    }

    public function showGloseSignalementsAction($id)
    {
        $repoS = $this->getDoctrine()->getManager()->getRepository('AppBundle:Signalement');
        $repoTO = $this->getDoctrine()->getManager()->getRepository('AppBundle:TypeObjet');

        $typeObj = $repoTO->findOneBy(array('nom' => 'Glose'));
        $signalements = $repoS->findBy(array(
            'typeObjet' => $typeObj,
            'verdict' => null,
            'objetId' => $id,
        ));

        return $this->json(array(
            'succes' => true,
            'signalements' => $signalements,
        ));
    }

    public function editSignalementAction(Request $request, Signalement $signalement)
    {
        $data = $request->request->all();

        if($this->isCsrfTokenValid('signalement_vote', $data['token']))
        {
            $succes = false;

            if (!$signalement->getVerdict()) {
                $em = $this->getDoctrine()->getManager();
                $historiqueService = $this->container->get('AppBundle\Service\HistoriqueService');

                $repoTV = $em->getRepository('AppBundle:TypeVote');
                $verdict = $repoTV->findOneBy(array('nom' => $data['verdict']));

                // On met à jour le signalement
                $signalement->setDateDeliberation(new \DateTime());
                $signalement->setJuge($this->getUser());
                $signalement->setVerdict($verdict);

                // On enregistre dans l'historique du modérateur
                $histo = "Signalement #{$signalement->getId()}, verdict : {$signalement->getVerdict()->getNom()}.";
                $historiqueService->save($this->getUser(), $histo, false, true);

                // Si le signalement obtient un verdict valide on donne des points
                $msgHisto = '';
                if ($verdict->getNom() == 'Valide') {
                    $gainSignalementValide = $this->getParameter('gainSignalementValide');

                    // Mise à jour du nombre de crédits et de points de l'auteur
                    $signalement->getAuteur()->updateCredits($gainSignalementValide);
                    $signalement->getAuteur()->updatePoints($gainSignalementValide);

                    $msgHisto = ' (+' . $gainSignalementValide . ' crédits/points)';
                }

                // On enregistre dans l'historique du joueur ayant fait le signalement
                $historiqueService->save($signalement->getAuteur(), "Signalement #{$signalement->getId()}, verdict : {$signalement->getVerdict()->getNom()}{$msgHisto}.");

                $em->persist($signalement);
                $em->flush();

                if ($verdict->getNom() == 'Valide') {
                    $ed = $this->get('event_dispatcher');

                    $event = new GenericEvent(AmbigussEvents::SIGNALEMENT_VALIDE, array(
                        'membre' => $signalement->getAuteur(),
                        'signalement' => $signalement
                    ));
                    $ed->dispatch(AmbigussEvents::SIGNALEMENT_VALIDE, $event);

                    $event = new GenericEvent(AmbigussEvents::POINTS_GAGNES, array(
                        'membre' => $signalement->getAuteur(),
                    ));
                    $ed->dispatch(AmbigussEvents::POINTS_GAGNES, $event);
                }

                $succes = true;

                $res = array(
                    'id' => $signalement->getId(),
                    'dateDeliberation' => $signalement->getDateDeliberation() != null ? $signalement->getDateDeliberation()->format('d/m/Y H:i') : '',
                    'dateDeliberationTS' => $signalement->getDateDeliberation() != null ? $signalement->getDateDeliberation()->format('U') + $signalement->getDateDeliberation()->format('Z') : '',
                    'juge' => $signalement->getJuge()->getUsername(),
                    'jugeID' => $signalement->getJuge()->getId(),
                    'verdict' => $signalement->getVerdict()->getNom()
                );
            }

            return $this->json(array(
                'succes' => $succes,
                'signalement' => $res
            ));
        }

        throw new InvalidCsrfTokenException();
    }

    public function showSignalementsAction()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Signalement');
        $signalements = $repo->getAllWithObject();

        return $this->render('AppBundle:Moderation/Signalement:list.html.twig', array(
            'signalements' => $signalements
        ));
    }

    public function editPhraseAction(Request $request, LoggerInterface $logger, Phrase $phrase)
    {
        $em = $this->getDoctrine()->getManager();
        $repoS = $em->getRepository('AppBundle:Signalement');
        $repoTO = $em->getRepository('AppBundle:TypeObjet');
        $repoRep = $em->getRepository('AppBundle:Reponse');

        $form = $this->createForm(PhraseEditType::class, new Phrase(), array(
            'signale' => $phrase->getSignale(),
            'visible' => $phrase->getVisible(),
        ));

        $addGloseForm = $this->get('form.factory')->create(GloseAddType::class, new Glose(), array(
            'action' => $this->generateUrl('api_glose_new'),
        ));

        $newPhrase = null;
        $phraseOri = clone $phrase;
        $typeObj = $repoTO->findOneBy(array('nom' => 'Phrase'));
        $signalements = $repoS->findBy(array(
            'typeObjet' => $typeObj,
            'verdict' => null,
            'objetId' => $phrase->getId(),
        ));

        // Récupération des réponses du créateur
        $reponses = $repoRep->findBy(array(
            'auteur' => $phrase->getModificateur() ?? $phrase->getAuteur(),
            'phrase' => $phrase
        ));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $phraseService = $this->get('AppBundle\Service\PhraseService');
            $mapRep = $request->request->get('phrase')['motsAmbigusPhrase'] ?? array();

            $res = $phraseService->updateModo($phrase, $this->getUser(), $form->getData(), $mapRep);
            $succes = $res['succes'];

            if($succes) {
                $newPhrase = $phrase;

                $phraseOri = clone $phrase;
            }
            else {
                $bag = $this->get('session')->getFlashBag();

                $msg = "Erreur lors de la modification de la phrase -> " . $res['message'];
                $bag->add('danger', $msg);

                $logInfos = array(
                    'msg' => $msg,
                    'user' => $this->getUser()->getUsername(),
                    'ip' => $request->server->get('REMOTE_ADDR'),
                    'phrase' => $phrase->getContenu()
                );
                $logger->error(json_encode($logInfos));
            }
        }

        // Extraction de la glose pour un mot ambigu dans une phrase
        $repOri = array();
        foreach ($reponses as $rep) {
            $arr['map_ordre'] = $rep->getMotAmbiguPhrase()->getOrdre();
            $arr['glose_id'] = $rep->getGlose()->getId();
            $repOri[] = $arr;
        }

        return $this->render('AppBundle:Moderation/Phrase:edit.html.twig', array(
            'form' => $form->createView(),
            'phrase' => $phrase,
            'phraseOri' => $phraseOri,
            'reponsesOri' => $repOri,
            'newPhrase' => $newPhrase,
            'signalements' => $signalements,
            'addGloseForm' => $addGloseForm->createView(),
        ));
    }

}
