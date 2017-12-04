<?php

namespace BackBundle\Controller;

use BackBundle\Entity\ClassePromo;
use BackBundle\Entity\HistoryClasse;
use BackBundle\Form\EleveType;
use ConnexionBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class SuiviController extends Controller
{
    /**
     * @Route("/eleve.html", name="eleve_show")
     *
     */
    public function indexAction(Request $request, $listEleve = null)
    {
        if ($listEleve == null) {
            $em = $this->getDoctrine()->getManager();
            $listEleve = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_ELEVE');
        }
        return $this->render('BackBundle:Suivi:index.html.twig', array(
            'eleves' => $listEleve
        ));
    }

    /**
     * @Route("/eleve/show/{id}", name="eleve_focus")
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $eleve = $em->getRepository('ConnexionBundle:User')->find($id);
        $historique = $em->getRepository('BackBundle:HistoryClasse')->findBy(['eleve' => $eleve]);
        return $this->render('BackBundle:Suivi:show.html.twig', array(
            'eleve' => $eleve,
            'historique' => $historique
        ));
    }

    /**
     * @Route("/eleve.html/edit/{id}", name="eleve_edit")
     */
    public function editAction(Request $request, $id)
    {
        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();

        /* @var User $eleve */
        $eleve = $em->getRepository('ConnexionBundle:User')->find($id);
        $form = $this->createForm(EleveType::class, $eleve);
        $entityName = 'Suivi';
        $listEleve = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_ELEVE');
        $currentClasse = $em->getRepository('ConnexionBundle:User')->oldClassePromo($id); // on récupère l'id de l'ancienne classePromo

        /* @var HistoryClasse $oldHistory */
        $oldHistoryId = $eleve->getHistory()->getId();// on récupère l'ancienne classe rangé dans l'historique

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $eleve, $entityName,$listEleve);
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {
            $classePromo = $eleve->getClassePromo();
            $idClassePromo = $classePromo->getId(); // on récupère la classe promo id saisi par l'utilisateur
            if ($currentClasse != $idClassePromo && $currentClasse != null) //si la classe promo id est différente de l'ancienne
            {
                $oldHistory = $em->getRepository('BackBundle:HistoryClasse')->find($oldHistoryId);
                $oldHistory->setActiveStatus(1); // on desactive l'ancienne classe
                $em->persist($oldHistory);
                $em->flush();
                $history = new HistoryClasse();
                $history->setClasse($eleve->getClassePromo()->getClasse());
                $history->setEleve($eleve);
                $history->setActiveStatus(0); // on active la nouvelle
                $em->persist($history);
                $eleve->setHistory($history); // et on pense à remplacé l'history de l'élève par l'history actuelle
                $em->persist($eleve);
                $em->flush();
            }
            $session = new Session();
            $session->getFlashBag()->add('eleveModif', '');// le message à l'utilisateur
            return $this->redirectToRoute('eleve_show', ['eleves' => $listEleve]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }

    /**
     * @Route("/eleve/add", name="eleve_add")
     */
    public function addAction(Request $request)
    {

        /* Config nécessaire au fonctionnement du service */

        $em = $this->getDoctrine()->getManager();
        $eleve = new User;
        $form = $this->createForm(EleveType::class, $eleve);
        $entityName = 'Suivi';
        $listEleve = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_ELEVE');
        $action = 'edit';

        /* l'appel du service */

        $data = $this->container->get('back.method.actions')->formAction($request, $form, $eleve, $entityName,$listEleve,$action,null,'ROLE_ELEVE');// true parce que j'utilise la table User pour add
        if ($data[0] == 'validate') // si on est dans la validation du formulaire
        {

            /* gestion des historique de classe */

            $history = new HistoryClasse();
            $history->setClasse($eleve->getClassePromo()->getClasse());
            $history->setEleve($eleve);
            $history->setActiveStatus(0);
            $eleve->setHistory($history);
            $em->persist($history);
            $em->persist($eleve);
            $em->flush();
            $session = new Session();
            $session->getFlashBag()->add('eleveOk', ''); // le message à l'utilisateur
            return $this->redirectToRoute('eleve_show', ['eleves' => $listEleve]); // pas le choix d'utiliser ce redirectToRoute pour evité le chargment d'un cache de merde !!!!
        } else {// sinon on affiche le formulaire
            return new Response($data);
        }
    }

    /**
     * @Route("/eleve/remove/{id}", name="eleve_remove")
     */
    public function removeAction($id)
    {
        /* config service */


        $em = $this->getDoctrine()->getManager();
        /* @var User $eleve */
        $eleve = $em->getRepository('ConnexionBundle:User')->find($id);
        $listEleve = $em->getRepository('ConnexionBundle:User')->findByRole('ROLE_ELEVE');

        $history = $em->getRepository('BackBundle:HistoryClasse')->findBy(['eleve' => $eleve]);
        $eleve->setHistory(null);
        $em->persist($eleve);
        $em->flush();
        foreach ($history as $h)
        {
            $em->remove($h);
        }
        $em->flush();

        /* appel service */

        $this->container->get('back.method.actions')->removeAction($eleve);
        $session = new Session();
        $session->getFlashBag()->add('eleveDelete', '');
        return $this->redirectToRoute('eleve_show', ['eleve' => $listEleve]);
    }

}
