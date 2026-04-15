<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Citizen extends Model
{
    use HasFactory;

    protected $fillable = [
        'national_id', 'last_name', 'middle_name', 'first_name',
        'email', 'birth_date', 'birth_place', 'gender', 'address',
        'province', 'territory', 'sector', 'phone',
        'father_name', 'mother_name', 'photo', 'qr_code', 'agent_id',
        'criminal_record_number', 
        'health_record_number', 
        'student_card_number', 
        'social_security_number', 
        'tax_id_number', 
        'passport_number'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($citizen) {
            if (empty($citizen->national_id)) {
                do {
                    $id = mt_rand(10000000000, 99999999999); 
                } while (self::where('national_id', $id)->exists());
                
                $citizen->national_id = (string)$id;
            }
        });

        static::created(function ($citizen) {
            $citizen->generateQrCode();
        });
    }

    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
   
    public function generateQrCode()
    {
        $signature = substr(hash_hmac('sha256', $this->national_id, config('app.key')), 0, 8);
        $data = "RDC-ID:" . $this->national_id . ":" . $signature;
        
        $fileName = 'qrcodes/qr_' . $this->national_id . '.png';
        
        $logoPath = base_path('public/photos/logo-rdc.png'); 

        $qr = QrCode::format('png')
            ->size(300)
            ->errorCorrection('H')
            ->margin(1);

        if (file_exists($logoPath)) {
            try {
                $qr->merge($logoPath, 0.3, true);
            } catch (\Exception $e) {
                \Log::warning("Impossible d'intégrer le logo au QR Code : " . $e->getMessage());
            }
        }

        $image = $qr->generate($data);

        Storage::disk('public')->put($fileName, $image);

        $this->qr_code = $fileName;
        $this->saveQuietly();
        
        return $fileName;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}