<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class CarController extends Controller
{
    /**
     * Display all cars.
     *
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *     path="/car",
     *     tags={"car"},
     *     operationId="getcars",
     *     description="Получение всех автомобилей",
     *     @OA\Response(response="200", description="Display a listing of cars.")
     * )
     */
    public function index()
    {
        return response(Car::all());
    }

    /**
     * Create Car
     *
     * @OA\Post(
     *      path="/car",
     *      tags={"car"},
     *      description="Добавление автомобиля",
     *      operationId="createcar",
     *      security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                 )
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=402,
     *          description="Unauthenticated",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     * )
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'description' => 'string',
        ]);
        $car = Car::create([
            'name' => $fields['name'],
            'description' => $fields['description'],
        ]);

        $response = [
            'car' => $car,
        ];
        return response($response,201);
    }

    /**
     * Display car.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/car/{id}",
     *     tags={"car"},
     *     operationId="getcar",
     *     description="Получение автомобиля",
     *      @OA\Parameter(
     *          name="id",
     *          description="car id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(response="200", description="Display a car.")
     * )
     */
    public function show($id)
    {
        return Car::find($id);
    }

    /**
     * Update car.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @OA\Put(
     *      path="/car/{id}",
     *      tags={"car"},
     *      description="Обновление автомобиля",
     *      operationId="updatecar",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="car id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                 )
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=402,
     *          description="Unauthenticated",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *    )
     * )
     */

    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'name' => 'string',
            'description' => 'string',
            'user_id' => 'integer',
        ]);
        $car = Car::find($id);
        $car->update([
            'name' => ($fields['name']) ?: ($car['name']),
            'description' => ($fields['description']) ?: $car['description'],
            'user_id' => ($fields['user_id']) ?: $car['user_id'],
        ]);
        $response = [
            'car' => $car,
        ];
        return response($response,201);
    }

    /**
     * Delete car.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *     path="/car/{id}",
     *     tags={"car"},
     *     operationId="deletecar",
     *     description="Удаление автомобиля",
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="car id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(response="200", description="Delete car.")
     * )
     */
    public function destroy($id)
    {
        return response(Car::destroy($id));
    }
    /**
     * Get user by car.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/car/{id}/user",
     *     tags={"car"},
     *     operationId="getuserbycar",
     *     description="Получение пользователя по автомобилю",
     *      @OA\Parameter(
     *          name="id",
     *          description="car id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(response="200", description="Display user by car.")
     * )
     */
    public function getuser($id)
    {
        return Car::find($id)->user()->get();
    }
}
