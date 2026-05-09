<?php

namespace Database\Seeders;

use App\Models\LeaveRequest;
use App\Models\LeaveRequestAttachment;
use App\Models\User;
use Illuminate\Database\Seeder;

class LeaveRequestAttachmentSeeder extends Seeder
{
    public function run(): void
    {
        $parent = User::where('email', 'parent@example.com')->first();

        // attach a sample medical certificate to each "sick" leave request
        LeaveRequest::where('leave_type', 'sick')->get()->each(function (LeaveRequest $lr) use ($parent) {
            LeaveRequestAttachment::updateOrCreate(
                ['leave_request_id' => $lr->id, 'original_name' => 'medical-certificate.pdf'],
                [
                    'uploaded_by'  => optional($parent)->id,
                    'file_path'    => 'leaves/'.$lr->request_no.'/medical-certificate.pdf',
                    'mime_type'    => 'application/pdf',
                    'file_size'    => 145678,
                ]
            );
        });
    }
}
