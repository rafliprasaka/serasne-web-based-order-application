<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Table;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index($table)
    {
        $cart = Cart::where('table_id', $table)
            ->where('status', 'open')
            ->get();

        return view('customer.cart.index', compact('cart'));
    }

    public function order($table, $product)
    {
        // Check if there is already an entry in Cart for this table_id and product_id
        $existingCart = Cart::where('table_id', $table)
                            ->where('product_id', $product)
                            ->where('status', 'open')
                            ->first();

        if ($existingCart) {
            // If entry exists, update the quantity by incrementing it
            $existingCart->quantity += 1;
            $existingCart->save();
        } else {
            // If no entry exists, create a new entry in Cart
            Cart::create([
                'table_id' => $table,
                'product_id' => $product,
                'quantity' => 1,
                'status' => 'open'
            ]);
        }
        Session::flash('order_success', 'Pesanan berhasil dimasukkan keranjang.');
        // Redirect to the menu route with the table parameter
        return redirect()->route('menu', ['table' => $table]);
    }

    public function update(Request $request, Cart $cart)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check if the cart status is 'open' before updating
        if ($cart->status === 'open') {
            // Update the cart item's quantity
            $cart->update(['quantity' => $validatedData['quantity']]);

            // Calculate the new total price
            $totalPrice = $cart->product->price * $cart->quantity;

            return response()->json([
                'message' => 'Cart item updated successfully',
                'total_price' => $totalPrice,
            ]);
        } else {
            return response()->json([
                'message' => 'Cannot update cart item: status is not open',
            ], 400); // Return a 400 Bad Request status or another appropriate HTTP status code
        }
    }

    public function destroy(Cart $cart)
    {
        if ($cart->status === 'open') {
            $cart->delete();

            return response()->json([
                'message' => 'Cart item removed successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'Cannot delete cart item: status is not open',
            ], 400); // Return a 400 Bad Request status or another appropriate HTTP status code
        }
    }

    public function placeOrder($table)
    {
        // Retrieve cart items with status 'open' for the specified table
        $cartItems = Cart::where('table_id', $table)
            ->where('status', 'open')
            ->get();

        // Loop through each cart item
        foreach ($cartItems as $cartItem) {
            // Find the corresponding product
            $product = $cartItem->product;

            // Find if there is already a closed cart item for the same table and product
            $existingCartItem = Cart::where('table_id', $table)
                ->where('product_id', $product->id)
                ->where('status', 'closed')
                ->first();

            if ($existingCartItem) {
                // Update the quantity of the existing closed cart item
                $existingCartItem->quantity += $cartItem->quantity;
                $existingCartItem->save();

                // Delete the current open cart item
                $cartItem->delete();
            } else {
                // Update the cart item status to 'closed'
                $cartItem->status = 'closed';
                $cartItem->save();
            }
        }
        Session::flash('order_success', 'Pesanan anda sedang di proses.');
        return redirect()->route('menu', $table)->with('success', 'Product created successfully.');
    }

    public function bill($table)
    {
        $bill = Cart::where('table_id', $table)
            ->where('status', 'closed')
            ->get();

        return view('customer.bill.index', compact('bill'));
    }

    public function closeBill($table)
    {
        // Retrieve closed cart items for the specified table
        $bill = Cart::where('table_id', $table)
            ->where('status', 'closed')
            ->get();

        // Calculate sub-total
        $subTotal = $bill->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Calculate tax (PPN) - assuming a tax rate of 11%
        $ppn = $subTotal * 0.11;

        // Calculate total amount
        $totalAmount = $subTotal + $ppn;

        // Create a new transaction record
        $transaction = Transaction::create([
            'invoice_id' => uniqid('INV-'),
            'table_id' => $table,
            'sub_total' => $subTotal,
            'ppn' => $ppn,
            'total_amount' => $totalAmount,
        ]);

        // Create transaction detail records for each cart item
        foreach ($bill as $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item->product->id,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
            ]);
        }

        // Truncate the cart table for the specified table ID
        Cart::where('table_id', $table)->delete();

        $table = Table::findOrFail($table);
        $table->update(['status' => 'close-bill']);

        return redirect()->route('menu', $table)->with('success', 'Product created successfully.');
    }

}
