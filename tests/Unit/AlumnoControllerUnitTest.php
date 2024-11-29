<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase; //Este usaremos
use App\Models\Alumno;
use App\Http\Controllers\AlumnoController;
use Illuminate\Validation\ValidationException;
use illuminate\Http\Request;

class AlumnoControllerUnitTest extends TestCase
{
    //prueba de que al no ingresar dataos genera una exception
    public function test_validacion_falla_para_crear_alumnos()
    {
        //variable para el controlador, aqui se crea la instancia de dicho controlador
        $controller = new AlumnoController();
        $request = Request::create('/alumnos', 'POST', [
            'nombre' => '',//Ingresando dato vacio para comprobar la validacion de require
            'apellido' => '',
            'email' => '',
            'edad' => ''
        ]);
        $this->expectException(ValidationException::class);
        // Se espera que falle la validación
        $controller->store($request);
    }
    //prueba de que al ingresar los datos de forma correcta se ejecuta la captura de los datos correctamente
    public function test_validacion_correcta_para_crear_alumnos()
    {
        //variable para el controlador, aqui se crea la instancia de dicho controlador
        $controller = new AlumnoController();
        $request = Request::create('/alumnos', 'POST', [
            'nombre' => 'Jennyfer',//Ingresando dato para comprobar la validacion
            'apellido' => 'Garcia',
            'email' => 'jjnnhg@unicah.edu',
            'edad' => '17'
        ]);
        $this->expectException(ValidationException::class);
        // Se espera que funcione la validación
        $response = $controller->store($request);
        $this->assertTrue($response->isRedirect(route('alumnos.index')));
    }

    public function test_validacion_respuesta_falsa()
    {
        $controller = new AlumnoController();
        $request = Request::create('/alumnos', 'POST', [
            'nombre' => '',
            'apellido' => '',
            'email' => '',
            'edad' => ''
        ]);
        $this->expectException(ValidationException::class);
        $response = $controller->store($request);
        $this->assertFalse($response->isRedirect(route('alumnos.index')));
    }

    public function test_guardar_redirige_correctamente()
    {
        $controller = new AlumnoController();
        $request = Request::create('/alumnos', 'POST', [
            'name' => 'Jennyfer',
            'surname' => 'Garcia',
            'email' => 'jjnnhg@unicah.edu',
            'age' => 17
        ]);

        $response = $controller->store($request);
        $this->assertSame(route('alumnos.index'), $response->headers->get('Location'));
    }

    public function test_datos_correctos()
    {
        $alumno = Alumno::latest()->first();
        $this->assertEquals('Jennyfer', $alumno->nombre);
        $this->assertEquals('Garcia', $alumno->apellido);
        $this->assertEquals('jjnnhg@unicah.edu', $alumno->email);
        $this->assertEquals(17, $alumno->edad);
    }
    public function test_edad_es_numerica()
    {
        $alumno = Alumno::latest()->first();
        $this->assertIsNumeric($alumno->edad);
    }

}
