<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\StudentDocument;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentDocumentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        // Add 1 sample document (birth certificate) for the first 5 students.
        Student::query()->orderBy('id')->limit(5)->get()->each(function (Student $student) use ($admin) {
            StudentDocument::updateOrCreate(
                ['student_id' => $student->id, 'document_type' => 'birth_certificate'],
                [
                    'uploaded_by' => optional($admin)->id,
                    'title'       => 'Birth certificate — '.$student->name_en,
                    'file_path'   => 'documents/students/'.$student->student_code.'/birth-certificate.pdf',
                    'mime_type'   => 'application/pdf',
                    'file_size'   => 245678,
                ]
            );
        });
    }
}
