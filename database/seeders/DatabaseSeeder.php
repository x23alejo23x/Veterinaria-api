<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\User;
use App\Infrastructure\Persistence\Eloquent\Models\Owner;
use App\Infrastructure\Persistence\Eloquent\Models\Patient;
use App\Infrastructure\Persistence\Eloquent\Models\Medication;
use App\Infrastructure\Persistence\Eloquent\Models\Appointment;
use App\Infrastructure\Persistence\Eloquent\Models\MedicalHistory;
use App\Infrastructure\Persistence\Eloquent\Models\FollowUp;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        $admin = User::create([
            'name'     => 'Admin Nura',
            'email'    => 'admin@nuravetcare.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Dr. Samayaca',
            'email'    => 'samayaca@nuravetcare.com',
            'password' => Hash::make('password'),
            'role'     => 'vet',
        ]);

        // Owners
        $owners = [
            ['name' => 'María García',   'email' => 'maria.garcia@email.com',   'phone' => '+57 310 123 4567', 'city' => 'Bogotá'],
            ['name' => 'Carlos López',   'email' => 'carlos.lopez@email.com',   'phone' => '+57 320 234 5678', 'city' => 'Medellín'],
            ['name' => 'Ana Martínez',   'email' => 'ana.martinez@email.com',   'phone' => '+57 315 345 6789', 'city' => 'Cali'],
            ['name' => 'Luis Rodríguez', 'email' => 'luis.rodriguez@email.com', 'phone' => '+57 300 456 7890', 'city' => 'Barranquilla'],
            ['name' => 'Sofia Jiménez',  'email' => 'sofia.jimenez@email.com',  'phone' => '+57 311 567 8901', 'city' => 'Bogotá'],
        ];

        $ownerModels = [];
        foreach ($owners as $o) {
            $ownerModels[] = Owner::create($o);
        }

        // Patients
        $patients = [
            ['name' => 'Max',     'species' => 'Canino', 'breed' => 'Golden Retriever', 'age' => 3, 'weight' => 28.5, 'owner_id' => $ownerModels[0]->id, 'status' => 'activo',   'avatar_color' => 'amber'],
            ['name' => 'Luna',    'species' => 'Felino', 'breed' => 'Siamés',           'age' => 2, 'weight' => 4.2,  'owner_id' => $ownerModels[1]->id, 'status' => 'activo',   'avatar_color' => 'violet'],
            ['name' => 'Rocky',   'species' => 'Canino', 'breed' => 'Bulldog',          'age' => 5, 'weight' => 22.0, 'owner_id' => $ownerModels[2]->id, 'status' => 'critico',  'avatar_color' => 'rose'],
            ['name' => 'Mia',     'species' => 'Felino', 'breed' => 'Persa',            'age' => 1, 'weight' => 3.8,  'owner_id' => $ownerModels[3]->id, 'status' => 'activo',   'avatar_color' => 'sky'],
            ['name' => 'Toby',    'species' => 'Canino', 'breed' => 'Labrador',         'age' => 4, 'weight' => 30.1, 'owner_id' => $ownerModels[4]->id, 'status' => 'inactivo', 'avatar_color' => 'teal'],
        ];

        $patientModels = [];
        foreach ($patients as $p) {
            $patientModels[] = Patient::create($p);
        }

        // Medications
        $medications = [
            ['name' => 'Amoxicilina 500mg',  'category' => 'Antibiótico',    'stock' => 150, 'unit' => 'tabletas', 'price' => 12500,  'supplier' => 'FarmaVet S.A.',    'status' => 'disponible'],
            ['name' => 'Ivermectina 1%',      'category' => 'Antiparasitario','stock' => 80,  'unit' => 'ml',       'price' => 28000,  'supplier' => 'BioAnimal Ltda.',  'status' => 'disponible'],
            ['name' => 'Tramadol 50mg',       'category' => 'Analgésico',     'stock' => 8,   'unit' => 'tabletas', 'price' => 45000,  'supplier' => 'MedVet Colombia',  'status' => 'disponible'],
            ['name' => 'Fluconazol 150mg',    'category' => 'Antifúngico',    'stock' => 0,   'unit' => 'cápsulas', 'price' => 32000,  'supplier' => 'FarmaVet S.A.',    'status' => 'agotado'],
            ['name' => 'Dexametasona 4mg/ml', 'category' => 'Corticoide',     'stock' => 45,  'unit' => 'ampollas', 'price' => 18500,  'supplier' => 'VetSupplies Co.',  'status' => 'disponible'],
        ];

        foreach ($medications as $m) {
            Medication::create($m);
        }

        // Appointments
        $appointments = [
            ['patient_id' => $patientModels[0]->id, 'owner_id' => $ownerModels[0]->id, 'vet_id' => $admin->id, 'date' => '2026-10-20', 'time' => '09:00', 'type' => 'Consulta general',   'status' => 'confirmada'],
            ['patient_id' => $patientModels[1]->id, 'owner_id' => $ownerModels[1]->id, 'vet_id' => $admin->id, 'date' => '2026-10-21', 'time' => '10:30', 'type' => 'Vacunación',          'status' => 'pendiente'],
            ['patient_id' => $patientModels[2]->id, 'owner_id' => $ownerModels[2]->id, 'vet_id' => $admin->id, 'date' => '2026-10-19', 'time' => '08:00', 'type' => 'Emergencia',          'status' => 'completada'],
            ['patient_id' => $patientModels[3]->id, 'owner_id' => $ownerModels[3]->id, 'vet_id' => null,       'date' => '2026-10-22', 'time' => '14:00', 'type' => 'Control de peso',     'status' => 'pendiente'],
            ['patient_id' => $patientModels[4]->id, 'owner_id' => $ownerModels[4]->id, 'vet_id' => $admin->id, 'date' => '2026-10-18', 'time' => '11:00', 'type' => 'Desparasitación',     'status' => 'cancelada'],
        ];

        foreach ($appointments as $a) {
            Appointment::create($a);
        }

        // Medical Histories
        MedicalHistory::create([
            'patient_id'  => $patientModels[0]->id,
            'vet_id'      => $admin->id,
            'date'        => '2026-10-15',
            'type'        => 'Consulta general',
            'diagnosis'   => 'Paciente sano, sin novedades.',
            'treatment'   => 'Vitaminas preventivas.',
            'weight'      => 28.5,
            'temperature' => 38.2,
        ]);

        MedicalHistory::create([
            'patient_id'  => $patientModels[2]->id,
            'vet_id'      => $admin->id,
            'date'        => '2026-10-19',
            'type'        => 'Emergencia',
            'diagnosis'   => 'Gastroenteritis aguda.',
            'treatment'   => 'Suero IV + Metronidazol.',
            'notes'       => 'Requiere monitoreo 48h.',
            'weight'      => 21.8,
            'temperature' => 39.5,
        ]);

        // Follow-ups
        FollowUp::create([
            'patient_id' => $patientModels[2]->id,
            'owner_id'   => $ownerModels[2]->id,
            'date'       => '2026-10-21',
            'type'       => 'Post-consulta',
            'status'     => 'pendiente',
            'notes'      => 'Verificar recuperación de gastroenteritis.',
        ]);

        FollowUp::create([
            'patient_id' => $patientModels[0]->id,
            'owner_id'   => $ownerModels[0]->id,
            'date'       => '2026-11-01',
            'type'       => 'Vacuna anual',
            'status'     => 'pendiente',
        ]);
    }
}
