<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notebook;

/**
 * @OA\Info(
 *     title="Notebook API",
 *     version="1.0.0",
 *     description="API записной книжки"
 * )
 */
class NotebookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/notebook/",
     *     summary="Получение списка контактов",
     *     tags={"Записная книжка"},
     *     @OA\Response(
     *         response=200,
     *         description="Список контактов",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="fullname", type="string", example="Романов Иван Иванович"),
     *                 @OA\Property(property="company", type="string", example="ООО 'ААА'"),
     *                 @OA\Property(property="phone", type="string", example="79111111111"),
     *                 @OA\Property(property="email", type="string", example="test@mail.ru"),
     *                 @OA\Property(property="birthdate", type="string", example="1997-01-01"),
     *                 @OA\Property(property="photo", type="string", example="img/photo.jpg")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=500, description="Ошибка сервера")
     * )
     */
    public function index(Request $request)
    {
        $contacts = Notebook::paginate(2);
        return response()->json($contacts, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/notebook/",
     *     summary="Создание новой записи в записной книжке",
     *     tags={"Записная книжка"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"fullname", "phone", "email"},
     *             @OA\Property(property="fullname", type="string", example="Романов Иван Иванович"),
     *             @OA\Property(property="company", type="string", example="ООО 'ААА'"),
     *             @OA\Property(property="phone", type="string", example="79111111111"),
     *             @OA\Property(property="email", type="string", example="test@mail.ru"),
     *             @OA\Property(property="birthdate", type="string", example="1997-01-01"),
     *             @OA\Property(property="photo", type="string", example="img/photo.jpg")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Запись в записной книжке успешно создана"),
     *     @OA\Response(response=400, description="Неверный запрос"),
     *     @OA\Response(response=500, description="Ошибка сервера")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:notebook,email',
            'birthdate' => 'nullable|date',
            'photo' => 'nullable|string',
        ]);
        $contact = Notebook::create($validated);
        return response()->json($contact, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/notebook/{id}",
     *     summary="Получение записи в записной книжке по id",
     *     tags={"Записная книжка"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID записи в записной книжке",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Данные контакта в записной книжке",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="fullname", type="string", example="Романов Иван Иванович"),
     *             @OA\Property(property="company", type="string", example="ООО 'ААА'"),
     *             @OA\Property(property="phone", type="string", example="79111111111"),
     *             @OA\Property(property="email", type="string", example="test@mail.ru"),
     *             @OA\Property(property="birthdate", type="string", example="1997-01-01"),
     *             @OA\Property(property="photo", type="string", example="img/photo.jpg")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Запись не найдена")
     * )
     */
    public function show($id)
    {
        $contact = Notebook::findOrFail($id);
        return response()->json($contact, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/notebook/{id}",
     *     summary="Обновление записи в записной книжке по id",
     *     tags={"Записная книжка"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID записи в записной книжке",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"fullname", "phone", "email"},
     *             @OA\Property(property="fullname", type="string", example="Романов Иван Иванович"),
     *             @OA\Property(property="company", type="string", example="ООО 'ААА'"),
     *             @OA\Property(property="phone", type="string", example="79111111111"),
     *             @OA\Property(property="email", type="string", example="test@mail.ru"),
     *             @OA\Property(property="birthdate", type="string", example="1997-01-01"),
     *             @OA\Property(property="photo", type="string", example="img/photo.jpg")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Запись обновлена"),
     *     @OA\Response(response=404, description="Запись не найдена"),
     *     @OA\Response(response=500, description="Ошибка сервера")
     * )
     */
    public function update(Request $request, $id)
    {
        $contact = Notebook::findOrFail($id);
   
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:notebook,email,' . $contact->id,
            'birthdate' => 'nullable|date',
            'photo' => 'nullable|string',
        ]);

        $contact->update($validated);

        return response()->json($contact, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/notebook/{id}",
     *     summary="Удаление записи в записной книжке",
     *     tags={"Записная книжка"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID записи в записной кнжике для удаления",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Запись успешно удалена"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Запись не найдена"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера"
     *     )
     * )
     */
    public function destroy($id)
    {
        $contact = Notebook::findOrFail($id);
        $contact->delete();
        return response()->json(null, 204);
    }
}
