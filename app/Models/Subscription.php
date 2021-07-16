<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'status',
        'reference',
        'type',
        'quantity',
        'start_date',
        'end_date',
    ];

    public function SubIssues()
    {
        return $this->hasMany(SelectedIssue::class,'subscription_id');
    }

    public function SubIssuesItemCode()
    {
        $itemCodes = [];
        $items = SelectedIssue::whereSubscriptionId($this->id)->get();
        foreach($items as $item) {
            $magazine = Magazine::whereIssueNo($item->issue_no)->value('item_code');
            array_push($itemCodes, $magazine);
        }

        return $itemCodes;
    }

    public function SubIssuesAmount()
    {
        $amounts = [];
        $items = SelectedIssue::whereSubscriptionId($this->id)->get();
        foreach($items as $item) {
            $amount = Amount::whereSubscriptionPlanId($this->subscription_plan_id)->value($this->type);
            $figure = $amount / ($this->quantity * $items->count());
            array_push($amounts, number_format((float)$figure, 2, '.', ''));
        }

        return $amounts;
    }

    public function SubIssuesQuantity()
    {
        $quantities = [];
        $items = SelectedIssue::whereSubscriptionId($this->id)->get();
        foreach($items as $item) {
            array_push($quantities, $this->quantity);
        }

        return $quantities;
    }
}
