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

    public int $quantity;

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
            'menus' => 'required|array',
            'menus.*.quantity' => 'required|integer'
        ];
    }

    protected function passedValidation()
    {
        //Retrieve each menu items price
        $this->collect('menus')->each(function ($value, $key) {
            $this->items[$key] = $value;
            $this->items[$key]['price'] = Menu::findOrFail($key)?->price;
        });

        //Calculate and merge the total price of the ordererd menu items into the request class
        $this->merge([
            'total_price' => collect($this->items)->sum(
                fn ($item) => $item['price'] * $item['quantity']
            )
        ]);

        //Get total quantity of menu items
        $this->quantity = collect($this->items)->sum(
            fn ($item) => $item['quantity']
        );
    }

    public function fulfil()
    {
        $data = $this->only(['email', 'phone', 'address', 'total_price', 'quantity']);

        $order = tap(user()->orders()->create($data), function (Order $order) {
            $order->menus()->attach($this->items);
        });

        return $order->refresh();
    }
}
