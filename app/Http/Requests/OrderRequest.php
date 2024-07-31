<?php

namespace App\Http\Requests;

use App\Enums\OrderStatus;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    public array $items;

    public float $total_price;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'phone' => 'required|digits_between:11,15',
            'address' => 'required|string',
            'status' => ['nullable', Rule::in(OrderStatus::values())],
            'quantity' => 'nullable',
            'total_price' => 'nullable',
            'products' => 'required|array',
            'products.*.quantity' => 'required|integer'
        ];
    }

    protected function passedValidation()
    {
        $this->collect('products')->each(function ($value, $key) {
            $this->items[$key] = $value;
            $this->items[$key]['price'] = Menu::find($key)->price;
        });

        $this->total_price = collect($this->items)->sum(
            fn ($item) => $item['price'] * $item['quantity']
        );
    }

    public function fulfil()
    {
        $data = $this->only(['email', 'phone', 'address', 'total_price', 'quantity']);

        $order = user()->orders()->create($data)->tap(function (Order $order) {
            $order->menus()->attach($this->items);
        });

        return $order;
    }
}
