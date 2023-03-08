<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'client_id',
        'start',
        'end',
        'notes',
    ];

    protected $dates = [
        'start',
        'end',
    ];
    protected $appends = [
        'booking_time',
    ];

    public function getBookingTimeAttribute()
    {
//        can be improved using different approach. But this one is simple and much readable
        if ($this->start->format("y") != $this->end->format("y")) {
            $formattedBookingTime = "{$this->start->format("D d M Y, h:m")} to {$this->end->format("D d M Y, h:m")}";
        } elseif ($this->start->format("m") != $this->end->format("m")) {
            $formattedBookingTime = "{$this->start->format("D d M Y, h:m")} to {$this->end->format("D d M, h:m")}";
        }elseif ($this->start->format("d") != $this->end->format("d")){
            $formattedBookingTime = "{$this->start->format("D d M Y, h:m")} to {$this->end->format("D d, h:m")}";
        }else{
            $formattedBookingTime = "{$this->start->format("D d M Y, h:m")} to {$this->end->format("h:m")}";
        }
        return $formattedBookingTime;
    }
}
