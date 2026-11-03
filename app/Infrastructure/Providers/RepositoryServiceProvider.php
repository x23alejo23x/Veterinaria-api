<?php

declare(strict_types=1);

namespace App\Infrastructure\Providers;

use App\Domain\Appointment\Repositories\AppointmentRepositoryInterface;
use App\Domain\FollowUp\Repositories\FollowUpRepositoryInterface;
use App\Domain\MedicalHistory\Repositories\MedicalHistoryRepositoryInterface;
use App\Domain\Medication\Repositories\MedicationRepositoryInterface;
use App\Domain\Owner\Repositories\OwnerRepositoryInterface;
use App\Domain\Patient\Repositories\PatientRepositoryInterface;
use App\Domain\Prescription\Repositories\PrescriptionRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentAppointmentRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentFollowUpRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentMedicalHistoryRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentMedicationRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentOwnerRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentPatientRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentPrescriptionRepository;
use Illuminate\Support\ServiceProvider;

final class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PatientRepositoryInterface::class, EloquentPatientRepository::class);
        $this->app->bind(OwnerRepositoryInterface::class, EloquentOwnerRepository::class);
        $this->app->bind(MedicationRepositoryInterface::class, EloquentMedicationRepository::class);
        $this->app->bind(AppointmentRepositoryInterface::class, EloquentAppointmentRepository::class);
        $this->app->bind(MedicalHistoryRepositoryInterface::class, EloquentMedicalHistoryRepository::class);
        $this->app->bind(FollowUpRepositoryInterface::class, EloquentFollowUpRepository::class);
        $this->app->bind(PrescriptionRepositoryInterface::class, EloquentPrescriptionRepository::class);
    }
}
