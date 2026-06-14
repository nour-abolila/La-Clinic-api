<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Doctor\StoreDoctorRequest;
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Mail\DoctorMail;
use App\Models\DoctorProfile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = DoctorProfile::with('user')->get();

        return success(
            'Doctors retrieved successfully',
            DoctorResource::collection($doctors)
        );
    }


    public function show(DoctorProfile $doctor)
    {
        return success(
            'Doctor retrieved successfully',
            new DoctorResource($doctor->load('user'))
        );
    }


    public function store(StoreDoctorRequest $request)
    {
        $data = $request->validated();

        $generatedPassword = Str::random(10);

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($generatedPassword),
            'role' => 'doctor',
            'email_verified_at' => now(),
        ]);

        $doctor = $user->doctorProfile()->create([
            'specialization' => $data['specialization'],
            'years_of_experience' => $data['years_of_experience'],
            'bio' => $data['bio'],
            'session_price' => $data['session_price'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'working_days' => $data['working_days'],
        ]);

        Mail::to($user->email)->send(new DoctorMail($user, $generatedPassword));

        return success(
            'Doctor added successfully',
            new DoctorResource($doctor->load('user'))
        );
    }


    public function update(UpdateDoctorRequest $request, DoctorProfile $doctor)
    {
        $data = $request->validated();

        $doctor->user->update([
            'first_name'   => $data['first_name'] ?? $doctor->user->first_name,
            'last_name'    => $data['last_name'] ?? $doctor->user->last_name,
            'email'        => $data['email'] ?? $doctor->user->email,
            'phone_number' => $data['phone_number'] ?? $doctor->user->phone_number,
        ]);

        $doctor->update([
            'specialization'       => $data['specialization'] ?? $doctor->specialization,
            'years_of_experience'  => $data['years_of_experience'] ?? $doctor->years_of_experience,
            'bio'                  => $data['bio'] ?? $doctor->bio,
            'session_price'        => $data['session_price'] ?? $doctor->session_price,
            'start_time'           => $data['start_time'] ?? $doctor->start_time,
            'end_time'             => $data['end_time'] ?? $doctor->end_time,
            'working_days'         => $data['working_days'] ?? $doctor->working_days,
        ]);

        return success(
            'Doctor updated successfully',
            new DoctorResource(
                $doctor->fresh()->load('user')
            )
        );
    }

    public function destroy(DoctorProfile $doctor)
    {
        $doctor->user->delete();
        $doctor->delete(); 
        return success(
            'Doctor deleted successfully'
        );
    }



    public function myProfile()
    {
        $doctor = auth()->user()->doctorProfile()->with('user')->first();

        return success(
            'Profile retrieved successfully',
            new DoctorResource($doctor)
        );
    }
}
