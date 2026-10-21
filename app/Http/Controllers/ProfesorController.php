<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use \Exception;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProfesorController extends Controller
{
   private const RULES = [
        'nombre'        => 'required|string|max:100|min:2',
        'apellidos'     => 'required|string|max:130|min:3',
        'especialidad'  => 'nullable|string|max:100',
        'fechalta'      => 'nullable|date|before_or_equal:today',
        'salario'       => 'nullable|numeric|gte:0|lte:10000|decimal:0,2', 
    ];

    private const MESSAGES = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.string'   => 'El nombre debe ser una cadena de texto.',
        'nombre.min'      => 'El nombre debe tener al menos 2 caracteres.',
        'nombre.max'      => 'El nombre no puede superar los 100 caracteres.',

        'apellidos.required' => 'Los apellidos son obligatorios.',
        'apellidos.string'   => 'Los apellidos deben ser una cadena de texto.',
        'apellidos.min'      => 'Los apellidos deben tener al menos 3 caracteres.',
        'apellidos.max'      => 'Los apellidos no pueden superar los 130 caracteres.',

        'especialidad.string' => 'La especialidad debe ser una cadena de texto.',
        'especialidad.max'    => 'La especialidad no puede superar los 100 caracteres.',

        'fechalta.date'              => 'La fecha de alta no es válida.',
        'fechalta.before_or_equal'   => 'La fecha de alta no puede ser posterior a hoy.',

        'salario.numeric' => 'El salario debe ser un valor numérico.',
        'salario.gte'     => 'El salario no puede ser negativo.',
        'salario.lte'     => 'El salario no puede ser superior a 10000.',
        'salario.decimal' => 'El salario debe tener entre 0 y 2 decimales.',
    ];

    public function create()
    {
        return view('profesor.create', []);
    }

    public function destroy(Profesor $profesor): RedirectResponse {
        //delete from profesor where id = $profesor->id
        try {
            $profesor->delete();
        }catch(Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al borrar el profesor',]);
        }
        return redirect()->route('profesor.index')->with(['success' => 'Se ha borrado el profesor exitosamente']);
    }

    public function edit(Profesor $profesor): View {
        return view('profesor.edit', ['profesor' => $profesor]);
    } 

    public function index(): View {
        //$profesor = 'select * from profesor';
        $profesor = Profesor::all();
        return view('profesor.index', ['profesor' => $profesor]);
    }

    public function show(Profesor $profesor): View {
        return view('profesor.show', ['profesor' => $profesor]);
    }


    public function store(Request $request): RedirectResponse {
        //1º validar
        //$rules = self::getRules();
        //$messages =  self::getMessages();
        $validator = Validator::make($request->all(), self::RULES, self::MESSAGES);
        if($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        // Comprobar si ya existe el mismo nombre y apellidos
        $existe = Profesor::where('nombre', trim($request->nombre))
                           ->where('apellidos', trim($request->apellidos))
                           ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors([
                    'nombre' => 'Ya existe un profesor con ese nombre y apellidos.',
                ]);
        }

        //Guardamos
        $profesor = new Profesor($request->all());

        try {
            $profesor->save();
        } catch(UniqueConstraintViolationException $e) {
            return back()->withInput()->withErrors([
                //'error' => 'Clave única duplicada.',
                'nombre'     => 'Este campo forma parte de la clave única.',
                //'apellidos'  => 'Este campo también forma parte de la clave única',
            ]);
        } catch(Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al crear el profesor',]);
        }
          
        return redirect()->route('profesor.index')->with(['success' => 'Se ha creado el profesor correctamente']);
    }

    public function update(Request $request, Profesor $profesor): RedirectResponse {
        $validator = Validator::make($request->all(), self::RULES, self::MESSAGES);
        if($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
        try {
            $profesor->update($request->all());
        }catch (UniqueConstraintViolationException $e) {
            return back()->withInput()->withErrors(['error' => 'Clave única duplicada.',]);
        }catch(Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al editar el profesor',]);
        }    
        return redirect()->route('profesor.index');
    }

}
