<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Notebook;

class NotebookApiTest extends TestCase
{
    /**
     * Тест успешного получения списка контактов.
     */
    public function testNotebookIndex()
    {
        // Отправляем GET запрос
        $response = $this->getJson('/api/v1/notebook');

        // Проверяем статус 200 (успешно)
        $response->assertStatus(200);

        // Проверка ответа
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'fullname',
                    'company',
                    'phone',
                    'email',
                    'birthdate',
                    'photo',
                ]
            ],
        ]);
    }

    /**
     * Тест успешного создания контакта.
     */
    public function testNotebookStore()
    {
        // Данные для нового контакта
        $data = [
            'fullname' => 'Романов Иван Иванович',
            'phone' => '79111111111',
            'email' => 'test1@mail.com',
            'company' => 'ООО "ААА"',
            'birthdate' => '1997-01-01',
            'photo' => 'https://www.images.com/1.jpg',
        ];

        // Отправляем POST запрос
        $response = $this->postJson('/api/v1/notebook', $data);

        // Проверяем статус 201 (создано)
        $response->assertStatus(201);

        // Проверка наличия в базе данных
        $this->assertDatabaseHas('notebook', [
            'fullname' => 'Романов Иван Иванович',
            'email' => 'test1@mail.com',
        ]);

        // Проверка структуры ответа
        $response->assertJsonStructure([
            'id',
            'fullname',
            'company',
            'phone',
            'email',
            'birthdate',
            'photo',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * Тест успешного получения записи из записной книжки по ID.
     */
    public function testNotebookShow()
    {
        // Выбираем первую запись
        $contact = Notebook::first();

        // Отправляем GET запрос
        $response = $this->getJson("/api/v1/notebook/{$contact->id}");

        // Проверяем статус 200 (успешно)
        $response->assertStatus(200);

        // Проверяем ответ
        $response->assertJson([
            'id' => $contact->id,
            'fullname' => $contact->fullname,
            'email' => $contact->email,
        ]);
    }

    /**
     * Тест успешного удаления записи из записной книжки.
     */
    public function testNotebookDelete()
    {
        // Выбираем первую запись
        $contact = Notebook::first();

        // Отправляем запрос на удаление
        $response = $this->deleteJson("/api/v1/notebook/{$contact->id}");

        // Проверяем статус 204 (успешное удаление)
        $response->assertStatus(204);

        // Убедимся, что запись удалена из базы данных
        $this->assertDatabaseMissing('notebook', ['id' => $contact->id]);
    }
}
