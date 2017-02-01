<?php

namespace Aitor\MisCursosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Aitor\MisCursosBundle\Entity\Alumno;
use Aitor\MisCursosBundle\Form\AlumnoType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AitorMisCursosBundle:Default:index.html.twig');
    }
    public function mostrarAction($id)
    {
        return $this->render('AitorMisCursosBundle:Default:mostrar.html.twig');
    }
    public function crearAction(Request $request)
    {

    }
    public function nuevoAction(Request $request)
    {
      $alumno = new Alumno();
      $form = $this->createForm(AlumnoType::class,$alumno);
        return $this->render('AitorMisCursosBundle:Default:nuevo.html.twig', array(
          "form" => $form->createView()
        ));

    }
    public function editarAction($id)
    {
        return $this->render('AitorMisCursosBundle:Default:editar.html.twig');
    }
    public function actualizarAction(Request $request, $id)
    {

    }
    public function eliminarAction(Request $request, $id)
    {

    }

    public function insertarAction($nombre, $apellido, $edad) {

        $alumno = new Alumno();

        $alumno->setNombre($nombre);
        $alumno->setApellidos($apellido);
        $alumno->setEdad($edad);

        //Entity Manager
        $em = $this->getDoctrine()->getEntityManager();

        //Persistimos en el objeto
        $em->persist($alumno);

        //Insertarmos en la base de datos
        $flush = $em->flush();

        if ($flush == null) {
            echo "Paciente creado correctamente";
        } else {
            echo "El Paciente no se ha creado";
        }

        die();
    }

    /**
     * @Route("/insert", name="aitor_mis_cursos_nuevo")
     * @Method({"POST"})
     */
    public function insertAction(Request $request) {

        /* El objeto debería llamarse Post pero
         * al ser generado a partir de una base de datos
         * el objeto se llama como la tabla a la
         * que representa.
         */
        $request = Request::createFromGlobals();
        $request->getPathInfo();
        $alumno = new Alumno();

        $alumno->setNombre($request->request->get('nombre'));
        $alumno->setApellidos($request->request->get('apellidos'));
        $alumno->setEdad($request->request->get('edad'));

        //Entity Manager
        $em = $this->getDoctrine()->getEntityManager();

        //Persistimos en el objeto
        $em->persist($alumno);

        //Insertarmos en la base de datos
        $flush = $em->flush();

        if ($flush == null) {
            echo "Paciente creado correctamente";
        } else {
            echo "El Paciente no se ha creado";
        }

        die();
    }
}
