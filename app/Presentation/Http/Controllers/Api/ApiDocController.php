<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Api;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Nura VetCare API',
    version: '1.0.0',
    description: 'API REST para gestion clinica veterinaria Nura VetCare.',
    contact: new OA\Contact(email: 'hola@nuravetcare.com')
)]
#[OA\Server(
    url: 'http://localhost:8080/api',
    description: 'Servidor de desarrollo local'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT',
    description: 'Token Sanctum. Obtenerlo en POST /auth/login'
)]
#[OA\Tag(name: 'Auth', description: 'Autenticacion')]
#[OA\Tag(name: 'Patients', description: 'Gestion de pacientes')]
#[OA\Tag(name: 'Owners', description: 'Gestion de propietarios')]
#[OA\Tag(name: 'Medications', description: 'Catalogo de medicamentos')]
#[OA\Tag(name: 'Appointments', description: 'Citas clinicas')]
#[OA\Tag(name: 'MedicalHistory', description: 'Historial medico')]
#[OA\Tag(name: 'FollowUps', description: 'Seguimientos')]
class ApiDocController {}
