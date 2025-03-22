<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Validation\Rule;

class HotelController extends Controller
{
    // Listar hoteles
    public function index()
    {
        return response()->json(Hotel::with('roomConfigurations')->get());
    }

    // Registrar un nuevo hotel con sus configuraciones
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'             => 'required|unique:hotels,name',
            'address'          => 'required',
            'city'             => 'required',
            'nit'              => 'required|unique:hotels,nit',
            'number_of_rooms'  => 'required|integer|min:1',
            'room_configurations' => 'required|array|min:1',
            'room_configurations.*.quantity' => 'required|integer|min:1',
            'room_configurations.*.room_type' => ['required', Rule::in(['Estándar', 'Junior', 'Suite'])],
            'room_configurations.*.accommodation' => ['required', Rule::in(['Sencilla', 'Doble', 'Triple', 'Cuádruple'])],
        ]);

        // Validar reglas de acomodación según el tipo de habitación
        foreach ($validatedData['room_configurations'] as $config) {
            $roomType = $config['room_type'];
            $accommodation = $config['accommodation'];

            if ($roomType === 'Estándar' && !in_array($accommodation, ['Sencilla', 'Doble'])) {
                return response()->json([
                    'error' => "Para habitaciones Estándar, la acomodación debe ser Sencilla o Doble."
                ], 422);
            }
            if ($roomType === 'Junior' && !in_array($accommodation, ['Triple', 'Cuádruple'])) {
                return response()->json([
                    'error' => "Para habitaciones Junior, la acomodación debe ser Triple o Cuádruple."
                ], 422);
            }
            if ($roomType === 'Suite' && !in_array($accommodation, ['Sencilla', 'Doble', 'Triple'])) {
                return response()->json([
                    'error' => "Para habitaciones Suite, la acomodación debe ser Sencilla, Doble o Triple."
                ], 422);
            }
        }

        // Crear hotel
        $hotel = Hotel::create($validatedData);

        $totalRoomsConfigured = 0;
        // Agregar configuraciones y validar que la suma no exceda el número máximo
        foreach ($validatedData['room_configurations'] as $config) {
            $totalRoomsConfigured += $config['quantity'];
            $hotel->roomConfigurations()->create($config);
        }

        if ($totalRoomsConfigured > $hotel->number_of_rooms) {
            // Revertir la operación
            $hotel->delete();
            return response()->json([
                'error' => "La cantidad total de habitaciones configuradas ($totalRoomsConfigured) supera el máximo definido en el hotel ({$hotel->number_of_rooms})."
            ], 422);
        }

        return response()->json($hotel->load('roomConfigurations'), 201);
    }

    // Mostrar hotel por id
    public function show($id)
    {
        $hotel = Hotel::with('roomConfigurations')->findOrFail($id);
        return response()->json($hotel);
    }

    // Actualizar hotel (por implementar)
    public function update(Request $request, $id)
    {
        //
    }

    // Eliminar hotel
    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return response()->json(['message' => 'Hotel eliminado correctamente.']);
    }
}


