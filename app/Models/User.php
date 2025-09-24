<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tahvel_cookie',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tahvelUser(): mixed
    {
        $response = Http::withHeaders([
            'cookie' => $this->tahvel_cookie,
        ])->get('https://tahvel.edu.ee/hois_back/user');

       if(!$response->ok() || empty($response->body())) {
            return null;
       }

       return $response->json();
    }

    public function tahvelAbsence(): mixed
    {
        $response = Http::withHeaders([
            'cookie' => $this->tahvel_cookie,
        ])->get('https://tahvel.edu.ee/hois_back/students/132755/myAbsences/sum?absenceTypeH=true&absenceTypeP=true&absenceTypePR=true&absenceTypeV=true&lang=ET&page=0&size=50&sort=entry_date,desc&studyYear=708');

       if(!$response->ok() || empty($response->body())) {
            return null;
       }

       return $response->json();
    }

    
    public function tahvelJournal(): mixed
    {
        $response = Http::withHeaders([
            'cookie' => $this->tahvel_cookie,
        ])->get('https://tahvel.edu.ee/hois_back/journals/studentJournals?studentId=132755&studyYearId=708');

       if(!$response->ok() || empty($response->body())) {
            return null;
       }

       return $response->json();
    }

    public function tahvelTimetable(): mixed
    {
        $response = Http::withHeaders([
            'cookie' => $this->tahvel_cookie,
        ])->get('https://tahvel.edu.ee/hois_back/journals/studentJournalTasks');

       if(!$response->ok() || empty($response->body())) {
            return null;
       }

       return $response->json();
    }
    
}
