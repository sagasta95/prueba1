<?php

namespace Aitor\MisCursosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Aitor\MisCursosBundle\Entity\Alumno;
use Aitor\MisCursosBundle\Form\AlumnoType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $alumnos = $em->getRepository('AitorMisCursosBundle:Alumno')->findAll();

        return $this->render('AitorMisCursosBundle:Default:index.html.twig', array('alumnos' => $alumnos));
    }

    public function mostrarAction($id) {
        $em = $this->getDoctrine()->getManager();
        $alumno = $em->getRepository('AitorMisCursosBundle:Alumno')->find($id);
        return $this->render('AitorMisCursosBundle:Default:mostrar.html.twig', array('alumno' => $alumno));
    }

    public function crearAction(Request $request) {
        $alumno = new Alumno();
        $form = $this->createForm(AlumnoType::class, $alumno, array('action' => $this->generateUrl('aitor_mis_cursos_crear'), 'method' => "post"));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($alumno);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notif', '¡Alumno creado correctamente!');
            return $this->redirect($this->generateUrl('aitor_mis_cursos_mostrar', array('id' => $alumno->getId())));
        }
        $this->get('session')->getFlashBag()->add('notif', '¡Alumno no creado!');
        return $this->render('AitorMisCursosBundle:Default:nuevo.html.twig', array("form" => $form->createView()));
    }

    public function nuevoAction(Request $request) {
        $alumno = new Alumno();
        $form = $this->createForm(AlumnoType::class, $alumno, array('action' => $this->generateUrl('aitor_mis_cursos_crear'), 'method' => "post"));
        return $this->render('AitorMisCursosBundle:Default:nuevo.html.twig', array("form" => $form->createView()));
    }

    public function editarAction($id) {
        $em = $this->getDoctrine()->getManager();
        $alumno = $em->getRepository('AitorMisCursosBundle:Alumno')->find($id);
        $form = $this->createForm(AlumnoType::class, $alumno, array('action' => $this->generateUrl('aitor_mis_cursos_actualizar', array('id' => $alumno->getId())), 'method' => "put"));
        $form->add('crear', SubmitType::class, array('label' => "Actualizar Alumno"));

        return $this->render('AitorMisCursosBundle:Default:editar.html.twig', array('form' => $form->createView()));
    }

    public function actualizarAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $alumno = $em->getRepository('AitorMisCursosBundle:Alumno')->find($id);
        $form = $this->createForm(AlumnoType::class, $alumno, array('action' => $this->generateUrl('aitor_mis_cursos_actualizar', array('id' => $alumno->getId())), 'method' => "put"));
        $form->add('crear', SubmitType::class, array('label' => "Actualizar Alumno"));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('notif', '¡Alumno actualizado correctamente!');
            return $this->redirect($this->generateUrl('aitor_mis_cursos_mostrar', array('id' => $alumno->getId())));
        }
        $this->get('session')->getFlashBag()->add('notif', '¡Alumno no actualizado!');
        return $this->render('AitorMisCursosBundle:Default:editar.html.twig', array('form' => $form->createView()));
    }

    public function eliminarAction($id) {
        $em = $this->getDoctrine()->getManager();
        $alumno = $em->getRepository('AitorMisCursosBundle:Alumno')->find($id);
        $em->remove($alumno);
        $em->flush();
        $this->get('session')->getFlashBag()->add('notif', '¡Alumno eliminado correctamente!');
         return $this->redirect($this->generateUrl('aitor_mis_cursos_homepage'));
        
    }

}
